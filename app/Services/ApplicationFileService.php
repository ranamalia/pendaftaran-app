<?php

namespace App\Services;

use App\Enums\ApplicationFileType;
use App\Models\Application;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ApplicationFileService
{
    /**
     * Simpan file dengan nama otomatis:
     * jenisDokumen_namaPemohon_tanggal.ext
     *
     * Bisa menerima:
     * - UploadedFile (request biasa)
     * - TemporaryUploadedFile (Filament/Livewire)
     * - string (path yang sudah tersimpan oleh Filament)
     */
    public static function store(
        Application $application,
        ApplicationFileType $type,
        UploadedFile|TemporaryUploadedFile|string $file,
        string $uploadedBy
    ): array {
        // Kalau sudah berupa path string (Filament sudah simpan), cukup kembalikan saja
        if (is_string($file)) {
            return [
                'path' => $file,
                'original_name' => basename($file),
                'uploaded_by' => $uploadedBy,
            ];
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: 'pdf');
        $tanggal = now()->format('Ymd'); // sesuai permintaan kamu
        $namaPemohon = Str::slug($application->user->name, '_'); // pakai "_" biar match format

        // jenis dokumen (lebih aman kalau enum kamu belum punya method helper)
        $jenisDokumen = match ($type->value) {
            ApplicationFileType::SURAT_PENGANTAR->value => 'surat_pengantar',
            ApplicationFileType::PROPOSAL->value => 'proposal',
            ApplicationFileType::CV->value => 'cv',
            ApplicationFileType::TRANSKRIP_RAPOR->value => 'transkrip_rapor',
            ApplicationFileType::SURAT_JAWABAN_IZIN->value,
            ApplicationFileType::SURAT_JAWABAN->value => 'surat_jawaban',
            ApplicationFileType::SURAT_KETERANGAN_SELESAI->value,
            ApplicationFileType::SURAT_SELESAI->value => 'surat_selesai',
            default => 'dokumen',
        };

        $filename = "{$jenisDokumen}_{$namaPemohon}_{$tanggal}.{$extension}";

        // folder per aplikasi (rapi)
        $dir = "applications/{$application->id}";

        // simpan ke public disk
        $path = $file->storeAs($dir, $filename, 'public');

        return [
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'uploaded_by' => $uploadedBy,
        ];
    }

    public static function delete(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}
