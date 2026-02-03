<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // kalau sudah login, langsung ke dashboard pemohon
    if (Auth::check()) {
        return redirect()->route('pemohon.dashboard');
    }

    // kalau belum login, ke landing pemohon
    return redirect()->route('pemohon.home');
});

Route::get('/reset-password/{token}', function (string $token) {
    return redirect()->route('pemohon.password.reset', [
        'token' => $token,
        'email' => request('email'),
    ]);
})->name('password.reset');

require __DIR__.'/pemohon.php';
