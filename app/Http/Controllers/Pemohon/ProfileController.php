<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('pemohon.pages.profile-edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'pemohon_tipe' => ['required', 'in:smk,mahasiswa'],
            'instansi_nama' => ['required', 'string', 'max:150'],
            'jurusan' => ['required', 'string', 'max:120'],
            'nomor_induk' => ['required', 'string', 'max:60'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
