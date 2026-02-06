<?php

namespace App\Http\Controllers;

use App\Models\ApplicationFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationFileDownloadController extends Controller
{
    public function download(ApplicationFile $file)
    {
        $application = $file->application;

        $jenisDokumen = match ($file->type->value) {
            'surat_pengantar' => 'surat_pengantar',
            'proposal' => 'proposal',
            'cv' => 'cv',
            'transkrip_rapor' => 'transkrip_rapor',
            'surat_jawaban_izin', 'surat_jawaban' => 'surat_jawaban',
            'surat_keterangan_selesai', 'surat_selesai' => 'surat_selesai',
            default => 'dokumen',
        };

        $namaPemohon = Str::slug($application->user->name, '_');
        $tanggal = $file->created_at?->format('Ymd') ?? now()->format('Ymd');
        $ext = pathinfo($file->path, PATHINFO_EXTENSION) ?: 'pdf';

        $namaFile = "{$jenisDokumen}_{$namaPemohon}_{$tanggal}.{$ext}";

        $absolutePath = Storage::disk('public')->path($file->path);

        return response()->download($absolutePath, $namaFile);
    }
}
