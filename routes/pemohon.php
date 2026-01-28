<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pemohon\Auth\LoginController;
use App\Http\Controllers\Pemohon\Auth\ForgotPasswordController;
use App\Http\Controllers\Pemohon\Auth\ResetPasswordController;
use App\Http\Controllers\Pemohon\ProfileController;

Route::prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('/', fn () => view('pemohon.landing'))->name('home');

    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store'])->name('login.store');

        Route::get('register', [\App\Http\Controllers\Pemohon\Auth\RegisterController::class, 'create'])->name('register');
        Route::post('register', [\App\Http\Controllers\Pemohon\Auth\RegisterController::class, 'store'])->name('register.store');
    });


    Route::middleware(['auth', 'pemohon'])->group(function () {
        Route::get('dashboard', fn () => view('pemohon.dashboard'))->name('dashboard');
        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
        Route::get('dashboard', fn () => view('pemohon.pages.beranda'))->name('dashboard');

        Route::get('usulan', fn () => view('pemohon.pages.usulan.index'))->name('usulan.index');

        Route::get('profil', fn () => view('pemohon.pages.profile'))->name('profile');

        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

        Route::get('profil', [ProfileController::class, 'edit'])->name('profile');
        Route::post('profil', [ProfileController::class, 'update'])->name('profile.update');
    });

});
