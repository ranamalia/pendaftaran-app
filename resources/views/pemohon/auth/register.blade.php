<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Pemohon Magang</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/pemohon.css') }}">
</head>

<body>
  <div class="container">
    <div class="card">
      <h1 class="title">Daftar Pemohon Magang</h1>
      <p class="subtitle">Pemerintah Kabupaten Sragen</p>

      @if ($errors->any())
        <div class="error">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('pemohon.register.store') }}" novalidate>
        @csrf

        <!-- Nama Lengkap -->
        <div class="row">
          <label for="name">Nama Lengkap</label>
          <input
            class="input @error('name') input-error @enderror"
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            required>
        </div>

        <!-- Email & No HP -->
        <div class="grid-2">
          <div class="row">
            <label for="email">Email</label>
            <input
              class="input @error('email') input-error @enderror"
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              required>
          </div>
          <div class="row">
            <label for="no_hp">No HP (opsional)</label>
            <input
              class="input"
              type="tel"
              id="no_hp"
              name="no_hp"
              value="{{ old('no_hp') }}"
              placeholder="Contoh: 081234567890">
          </div>
        </div>

        <!-- Tipe Pemohon -->
        <div class="row">
          <label for="pemohon_tipe">Tipe Pemohon</label>
          <select
            class="input @error('pemohon_tipe') input-error @enderror"
            id="pemohon_tipe"
            name="pemohon_tipe"
            required>
            <option value="">-- Pilih --</option>
            <option value="smk" @selected(old('pemohon_tipe')==='smk')>SMK</option>
            <option value="mahasiswa" @selected(old('pemohon_tipe')==='mahasiswa')>Mahasiswa</option>
          </select>
        </div>

        <!-- Nama Sekolah / Kampus -->
        <div class="row">
          <label for="instansi_nama">Nama Sekolah / Kampus</label>
          <input
            class="input @error('instansi_nama') input-error @enderror"
            type="text"
            id="instansi_nama"
            name="instansi_nama"
            value="{{ old('instansi_nama') }}"
            required>
        </div>

        <!-- Jurusan / Prodi & NISN / NIM -->
        <div class="grid-2">
          <div class="row">
            <label for="jurusan">Jurusan / Prodi</label>
            <input
              class="input @error('jurusan') input-error @enderror"
              type="text"
              id="jurusan"
              name="jurusan"
              value="{{ old('jurusan') }}"
              required>
          </div>
          <div class="row">
            <label for="nomor_induk">NISN / NIM</label>
            <input
              class="input @error('nomor_induk') input-error @enderror"
              type="text"
              id="nomor_induk"
              name="nomor_induk"
              value="{{ old('nomor_induk') }}"
              required>
          </div>
        </div>

        <!-- Alamat -->
        <div class="row">
          <label for="alamat">Alamat (opsional)</label>
          <textarea
            class="input"
            id="alamat"
            name="alamat"
            rows="3"
            placeholder="Masukkan alamat lengkap Anda">{{ old('alamat') }}</textarea>
        </div>

        <!-- Password & Konfirmasi Password -->
        <div class="grid-2">
          <div class="row">
            <label for="password">Password</label>
            <input
              class="input @error('password') input-error @enderror"
              type="password"
              id="password"
              name="password"
              required>
          </div>
          <div class="row">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input
              class="input @error('password_confirmation') input-error @enderror"
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              required>
          </div>
        </div>

        <!-- Submit Button -->
        <button class="btn" type="submit">Daftar</button>
      </form>

      <!-- Login Link -->
      <div style="margin-top: 14px; text-align: center; font-size: 13px; color: #475569;">
        Sudah punya akun?
        <a class="link" href="{{ route('pemohon.login') }}">Login</a>
      </div>
    </div>
  </div>
</body>
</html>
