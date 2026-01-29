<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Opd;
use Illuminate\Http\Request;
use App\Enums\ApplicationStatus;
use App\Enums\ApplicationFileType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsulanMagangController extends Controller
{
    private function bolehAjukan(?Application $last): bool
    {
        // Aturan: boleh ajukan jika belum ada usulan, atau terakhir DITOLAK/SELESAI
        if (!$last) return true;

        return in_array($last->status, [
            ApplicationStatus::DITOLAK->value,
            ApplicationStatus::SELESAI->value,
        ], true);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $last = $user->applications()
            ->latest('created_at')
            ->with(['opd', 'files']) // penting untuk tampil link file
            ->first();

        $bolehAjukan = $this->bolehAjukan($last);

        $opds = Opd::where('aktif', true)->orderBy('nama')->get();

        return view('pemohon.pages.usulan-index', compact('last', 'bolehAjukan', 'opds'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $last = $user->applications()
            ->latest('created_at')
            ->first();

        if (!$this->bolehAjukan($last)) {
            return back()->with(
                'error',
                'Anda belum bisa mengajukan usulan baru karena status usulan terakhir masih: ' . strtoupper($last->status)
            );
        }

        $validated = $request->validate([
            'opd_id' => ['required', 'exists:opds,id'],
            'kategori' => ['required', 'in:mahasiswa,smk'],
            'institusi' => ['required', 'string', 'max:255'],
            'jurusan' => ['nullable', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],

            // WAJIB SEMUA FILE
            'surat_pengantar' => ['required', 'file', 'mimes:pdf', 'max:4096'],
            'proposal'        => ['required', 'file', 'mimes:pdf', 'max:4096'],
            'cv'              => ['required', 'file', 'mimes:pdf', 'max:4096'],
            'transkrip_rapor' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        return DB::transaction(function () use ($user, $request, $validated) {
            $app = Application::create([
                'user_id' => $user->id,
                'opd_id' => $validated['opd_id'],
                'kategori' => $validated['kategori'],
                'institusi' => $validated['institusi'],
                'jurusan' => $validated['jurusan'] ?? null,
                'telepon' => $validated['telepon'] ?? null,
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'status' => ApplicationStatus::DIPROSES->value,
            ]);

            $saveRequiredFile = function (string $inputName, ApplicationFileType $type) use ($request, $app) {
                // karena required, pasti ada file
                $file = $request->file($inputName);

                // unique(application_id, type) => kalau ada, replace
                $old = $app->files()->where('type', $type->value)->first();

                $path = $file->store("applications/{$app->id}", 'public');

                $app->files()->updateOrCreate(
                    ['type' => $type->value],
                    [
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'uploaded_by' => 'user',
                    ]
                );

                // hapus file lama biar storage gak numpuk
                if ($old && $old->path && $old->path !== $path) {
                    Storage::disk('public')->delete($old->path);
                }
            };

            $saveRequiredFile('surat_pengantar', ApplicationFileType::SURAT_PENGANTAR);
            $saveRequiredFile('proposal', ApplicationFileType::PROPOSAL);
            $saveRequiredFile('cv', ApplicationFileType::CV);
            $saveRequiredFile('transkrip_rapor', ApplicationFileType::TRANSKRIP_RAPOR);

            return redirect()->route('pemohon.usulan.index')
                ->with('success', 'Usulan magang berhasil dikirim beserta berkas. Silakan tunggu verifikasi.');
        });
    }
}
