@extends('pemohon.layouts.app')

@section('content')
<div class="app-main" style="max-width:520px;margin:auto;">
    <h1 class="page-title">Reset Password</h1>

    @if(session('error')) <div class="toast-error">{{ session('error') }}</div> @endif

    <div class="card2" style="margin-top:14px;">
        <form method="POST" action="{{ route('pemohon.password.update') }}" class="form2">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form2-row">
                <label class="form2-label">Email</label>
                <input type="email" name="email" class="form2-input" required value="{{ old('email', $email) }}">
                @error('email') <small class="form2-error">{{ $message }}</small> @enderror
            </div>

            <div class="form2-row">
                <label class="form2-label">Password Baru</label>
                <input type="password" name="password" class="form2-input" required>
                @error('password') <small class="form2-error">{{ $message }}</small> @enderror
            </div>

            <div class="form2-row">
                <label class="form2-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form2-input" required>
            </div>

            <div class="actions" style="margin-top:14px;">
                <button class="btn-primary2" type="submit">Reset Password</button>
                <a class="btn-outline2" href="{{ route('pemohon.login') }}">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
