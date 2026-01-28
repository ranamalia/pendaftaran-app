@extends('pemohon.layouts.app')

@section('title', 'Profil - Portal Magang')

@section('content')
  <section class="page">
    <h1 class="page-title">Edit Profil</h1>
    <p class="page-desc">Pastikan data Anda benar agar proses pengajuan magang lancar.</p>

    @if (session('success'))
      <div class="toast-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="toast-error">
        <ul>
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card2">
      <form method="POST" action="{{ route('pemohon.profile.update') }}" novalidate>
        @csrf

        <div class="form2-grid">
          <div class="form2-row">
            <label class="form2-label" for="name">Nama Lengkap</label>
            <input
              id="name"
              class="form2-input"
              name="name"
              value="{{ old('name', $user->name) }}"
              required
            >
          </div>

          <div class="form2-row">
            <label class="form2-label" for="no_hp">No HP</label>
            <input
              id="no_hp"
              class="form2-input"
              name="no_hp"
              value="{{ old('no_hp', $user->no_hp) }}"
              placeholder="08xxxxxxxxxx"
            >
          </div>
        </div>

        <div class="form2-row">
          <label class="form2-label" for="pemohon_tipe">Tipe Pemohon</label>
          <select id="pemohon_tipe" class="form2-input" name="pemohon_tipe" required>
            <option value="smk" @selected(old('pemohon_tipe', $user->pemohon_tipe)==='smk')>SMK</option>
            <option value="mahasiswa" @selected(old('pemohon_tipe', $user->pemohon_tipe)==='mahasiswa')>Mahasiswa</option>
          </select>
          <div class="form2-help">Pilih sesuai status Anda saat magang (SMK/Mahasiswa).</div>
        </div>

        <div class="form2-row">
          <label class="form2-label" for="instansi_nama">Nama Sekolah / Kampus</label>
          <input
            id="instansi_nama"
            class="form2-input"
            name="instansi_nama"
            value="{{ old('instansi_nama', $user->instansi_nama) }}"
            required
          >
        </div>

        <div class="form2-grid">
          <div class="form2-row">
            <label class="form2-label" for="jurusan">Jurusan / Prodi</label>
            <input
              id="jurusan"
              class="form2-input"
              name="jurusan"
              value="{{ old('jurusan', $user->jurusan) }}"
              required
            >
          </div>

          <div class="form2-row">
            <label class="form2-label" for="nomor_induk">NISN / NIM</label>
            <input
              id="nomor_induk"
              class="form2-input"
              name="nomor_induk"
              value="{{ old('nomor_induk', $user->nomor_induk) }}"
              required
            >
          </div>
        </div>

        <div class="form2-row">
          <label class="form2-label" for="alamat">Alamat</label>
          <textarea
            id="alamat"
            class="form2-input"
            name="alamat"
            rows="3"
            placeholder="Alamat lengkap (opsional)"
          >{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <button class="btn-primary2" type="submit">Simpan Perubahan</button>
      </form>
    </div>
  </section>
@endsection
