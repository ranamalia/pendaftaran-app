<?php

namespace App\Http\Controllers\Pemohon\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('pemohon.auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'pemohon_tipe' => ['required','in:smk,mahasiswa'],

            'instansi_nama' => ['required','string','max:255'],
            'jurusan' => ['required','string','max:255'],
            'nomor_induk' => ['required','string','max:50'],

            'no_hp' => ['nullable','string','max:30'],
            'alamat' => ['nullable','string','max:1000'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),

            'role' => 'pemohon',
            'pemohon_tipe' => $data['pemohon_tipe'],
            'instansi_nama' => $data['instansi_nama'],
            'jurusan' => $data['jurusan'],
            'nomor_induk' => $data['nomor_induk'],
            'no_hp' => $data['no_hp'] ?? null,
            'alamat' => $data['alamat'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('pemohon.dashboard');
    }
}
