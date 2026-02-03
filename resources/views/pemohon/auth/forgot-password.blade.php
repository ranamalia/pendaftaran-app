@extends('pemohon.layouts.app')

@section('content')
<div class="app-main" style="max-width:520px;margin:auto;">
    <h1 class="page-title">Lupa Password</h1>
    <p class="page-desc">Masukkan email akun. Karena MAIL_MAILER=log, link reset ada di storage/logs/laravel.log</p>

    @if(session('success')) <div class="toast-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="toast-error">{{ session('error') }}</div> @endif

    <div class="card2" style="margin-top:14px;">
        <form method="POST" action="{{ route('pemohon.password.email') }}" class="form2">
            @csrf
            <div class="form2-row">
                <label class="form2-label">Email</label>
                <input type="email" name="email" class="form2-input" required value="{{ old('email') }}">
                @error('email') <small class="form2-error">{{ $message }}</small> @enderror
            </div>

            <div class="actions" style="margin-top:14px;">
                <button class="btn-primary2" type="submit">Buat Link Reset</button>
                <a class="btn-outline2" href="{{ route('pemohon.login') }}">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
