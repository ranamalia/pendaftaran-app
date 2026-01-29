<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Pemohon\Auth\LoginController;
use App\Http\Controllers\Pemohon\Auth\RegisterController;
use App\Http\Controllers\Pemohon\DashboardController;
use App\Http\Controllers\Pemohon\UsulanMagangController;
use App\Http\Controllers\Pemohon\ProfileController;
use App\Http\Controllers\Pemohon\ApplicationFileController;

Route::prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('/', fn () => view('pemohon.landing'))->name('home');

    Route::middleware('guest')->group(function () {

        // Login
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store'])->name('login.store');

        // Register
        Route::get('register', [RegisterController::class, 'create'])->name('register');
        Route::post('register', [RegisterController::class, 'store'])->name('register.store');
    });

    Route::middleware(['auth', 'pemohon'])->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Usulan Magang
        Route::get('usulan', [UsulanMagangController::class, 'index'])
            ->name('usulan.index');

        Route::post('usulan', [UsulanMagangController::class, 'store'])
            ->name('usulan.store');

        // Profil Pemohon
        Route::get('profil', [ProfileController::class, 'edit'])
            ->name('profile');

        Route::post('profil', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('usulan/file/{file}/download', [ApplicationFileController::class, 'download'])
            ->name('usulan.file.download');

        // Logout
        Route::post('logout', [LoginController::class, 'destroy'])
            ->name('logout');
    });
});
