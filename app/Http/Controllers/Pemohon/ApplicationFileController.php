<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\ApplicationFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // added
use Illuminate\Support\Facades\Response;

class ApplicationFileController extends Controller
{
    public function download(ApplicationFile $file)
    {
        // pastikan file ini milik user login
        $userId = Auth::id(); // changed from auth()->id();

        if ($file->application->user_id !== $userId) {
            abort(403, "Anda tidak punya akses download file ini.");
        }

        $downloadName = $file->original_name ?? basename($file->path);
        $filePath = Storage::disk('public')->path($file->path);

        return Response::download($filePath, $downloadName);
    }
}
