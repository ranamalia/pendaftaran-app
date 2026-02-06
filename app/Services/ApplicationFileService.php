<?php

namespace App\Services;

use App\Enums\ApplicationFileType;
use App\Models\Application;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationFileService
{
    public static function store(
        Application $application,
        ApplicationFileType $type,
        UploadedFile $file,
        string $uploadedBy
    ): array {
        $extension = strtolower($file->getClientOriginalExtension() ?: 'pdf');
        $date = now()->format('Ymd_His');

        $pemohonSlug = Str::slug($application->user->name);

        // admin pakai kata "admin", user pakai nama pemohon
        $actor = $type->isAdminFile() ? 'admin' : $pemohonSlug;

        $filename = sprintf(
            'APP%05d_%s_%s_%s.%s',
            $application->id,
            $type->filenameSlug(),
            $actor,
            $date,
            $extension
        );

        // folder per aplikasi
        $dir = "applications/{$application->id}";

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
