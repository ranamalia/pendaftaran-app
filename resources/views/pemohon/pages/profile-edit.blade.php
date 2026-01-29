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
      <form method="POST" action="{{ route('pemohon.profile.update') }}" class="form2" novalidate>
        @csrf

        <!-- Informasi Dasar -->
        <div class="form2-section">
          <h3 class="form2-section-title">Informasi Dasar</h3>

          <div class="form2-grid">
            <div class="form2-row">
              <label class="form2-label" for="name">Nama Lengkap <span class="required">*</span></label>
              <input
                id="name"
                class="form2-input @error('name') form2-input-error @enderror"
                name="name"
                value="{{ old('name', $user->name) }}"
                placeholder="Nama lengkap Anda"
                required
              >
              @error('name') <small class="form2-error">{{ $message }}</small> @enderror
            </div>

            <div class="form2-row">
              <label class="form2-label" for="no_hp">No HP</label>
              <input
                id="no_hp"
                class="form2-input @error('no_hp') form2-input-error @enderror"
                name="no_hp"
                value="{{ old('no_hp', $user->no_hp) }}"
                placeholder="08xxxxxxxxxx"
              >
              @error('no_hp') <small class="form2-error">{{ $message }}</small> @enderror
            </div>
          </div>

          <div class="form2-row">
            <label class="form2-label" for="pemohon_tipe">Tipe Pemohon <span class="required">*</span></label>
            <select id="pemohon_tipe" class="form2-input @error('pemohon_tipe') form2-input-error @enderror" name="pemohon_tipe" required>
              <option value="">-- Pilih Tipe --</option>
              <option value="smk" @selected(old('pemohon_tipe', $user->pemohon_tipe)==='smk')>SMK</option>
              <option value="mahasiswa" @selected(old('pemohon_tipe', $user->pemohon_tipe)==='mahasiswa')>Mahasiswa</option>
            </select>
            <small class="form2-help">Pilih sesuai status Anda saat magang</small>
            @error('pemohon_tipe') <small class="form2-error">{{ $message }}</small> @enderror
          </div>
        </div>

        <!-- Informasi Institusi -->
        <div class="form2-section">
          <h3 class="form2-section-title">Informasi Institusi</h3>

          <div class="form2-row">
            <label class="form2-label" for="instansi_nama">Nama Sekolah / Kampus <span class="required">*</span></label>
            <input
              id="instansi_nama"
              class="form2-input @error('instansi_nama') form2-input-error @enderror"
              name="instansi_nama"
              value="{{ old('instansi_nama', $user->instansi_nama) }}"
              placeholder="Nama institusi Anda"
              required
            >
            @error('instansi_nama') <small class="form2-error">{{ $message }}</small> @enderror
          </div>

          <div class="form2-grid">
            <div class="form2-row">
              <label class="form2-label" for="jurusan">Jurusan / Prodi <span class="required">*</span></label>
              <input
                id="jurusan"
                class="form2-input @error('jurusan') form2-input-error @enderror"
                name="jurusan"
                value="{{ old('jurusan', $user->jurusan) }}"
                placeholder="Program studi/jurusan"
                required
              >
              @error('jurusan') <small class="form2-error">{{ $message }}</small> @enderror
            </div>

            <div class="form2-row">
              <label class="form2-label" for="nomor_induk">NISN / NIM <span class="required">*</span></label>
              <input
                id="nomor_induk"
                class="form2-input @error('nomor_induk') form2-input-error @enderror"
                name="nomor_induk"
                value="{{ old('nomor_induk', $user->nomor_induk) }}"
                placeholder="Nomor identitas Anda"
                required
              >
              @error('nomor_induk') <small class="form2-error">{{ $message }}</small> @enderror
            </div>
          </div>
        </div>

        <!-- Alamat -->
        <div class="form2-section">
          <h3 class="form2-section-title">Lokasi</h3>

          <div class="form2-row">
            <label class="form2-label" for="alamat">Alamat</label>
            <textarea
              id="alamat"
              class="form2-input form2-textarea @error('alamat') form2-input-error @enderror"
              name="alamat"
              rows="4"
              placeholder="Alamat lengkap (opsional)"
            >{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat') <small class="form2-error">{{ $message }}</small> @enderror
          </div>
        </div>

        <!-- Buttons -->
        <div class="actions" style="margin-top: 20px;">
          <button class="btn-primary2" type="submit">Simpan Perubahan</button>
          <a href="{{ route('pemohon.dashboard') }}" class="btn-outline2">Batal</a>
        </div>
      </form>
    </div>
  </section>
@endsection
