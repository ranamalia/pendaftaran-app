<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Pemohon</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/pemohon.css') }}">
</head>

<body>
  <div class="login-container">
    <div class="login-box">
      <h2>Login Pemohon</h2>
      <p class="subtitle">Pemerintah Kabupaten Sragen</p>

      @if ($errors->any())
        <div class="alert">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('pemohon.login.store') }}">
        @csrf

        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="Masukkan email anda"
            required
          >
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Masukkan password anda"
            required
          >
        </div>

        <button type="submit" class="btn-submit">Masuk</button>
      </form>

      <div style="margin-top: 24px; text-align: center; font-size: 13px; color: #64748b;">
        Belum punya akun?
        <a href="{{ route('pemohon.register') }}" class="link">Daftar di sini</a>
        <br>
         <!--<a href="{{ route('pemohon.password.request') }}" class="link" style="margin-top:8px; display:inline-block;">Lupa password?</a>-->
      </div>
    </div>
  </div>
</body>
</html>
