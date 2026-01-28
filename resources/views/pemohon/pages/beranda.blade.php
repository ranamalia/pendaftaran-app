@extends('pemohon.layouts.app')

@section('title', 'Beranda - Portal Magang')

@section('content')
  <!-- HERO -->
  <section class="hero2">
    <div class="hero2-inner">
      <div class="hero2-left">
        <h1 class="hero2-title">Dashboard Pemohon Magang</h1>
        <p class="hero2-subtitle">Kabupaten Sragen</p>
        <p class="hero2-desc">
          Pantau status usulan magang Anda, lengkapi data, dan unggah berkas dengan mudah.
        </p>
      </div>

      <div class="hero2-right">
        <!-- GANTI GAMBAR INI SESUAI PUNYA KAMU -->
        <img class="hero2-img" src="{{ asset('images/hero-dashboard.png') }}" alt="Hero Dashboard">
      </div>
    </div>
  </section>

  <section class="dash2">
    <div class="dash2-grid">

      <!-- STATUS -->
      <div class="card2 card2-wide">
        <div class="card2-head">
          <h2>Status Usulan Terakhir</h2>
          <span class="pill pill-gray">Belum Mengajukan</span>
        </div>

        <p class="muted">
          Anda belum memiliki usulan magang. Silakan ajukan magang melalui menu <b>Usulan Magang</b>.
        </p>

        <div class="actions">
          <a class="btn-primary2" href="{{ route('pemohon.usulan.index') }}">Ke Usulan Magang</a>
          <a class="btn-outline2" href="{{ route('pemohon.profile') }}">Lengkapi Profil</a>
        </div>
      </div>

      <!-- PROGRESS -->
      <div class="card2">
        <h2>Progress</h2>
        <ul class="steps">
          <li class="done">Registrasi & Login</li>
          <li class="{{ (auth()->user()->instansi_nama && auth()->user()->jurusan && auth()->user()->nomor_induk) ? 'done' : '' }}">
            Lengkapi Profil
          </li>
          <li>Ajukan Magang</li>
          <li>Upload Berkas</li>
          <li>Pantau Status</li>
        </ul>
      </div>

      <!-- RINGKASAN -->
      <div class="card2">
        <h2>Ringkasan</h2>
        <div class="kv">
          <div class="kv-row">
            <span>Email</span>
            <b>{{ auth()->user()->email }}</b>
          </div>
          <div class="kv-row">
            <span>Instansi</span>
            <b>{{ auth()->user()->instansi_nama ?? '-' }}</b>
          </div>
          <div class="kv-row">
            <span>Jurusan/Prodi</span>
            <b>{{ auth()->user()->jurusan ?? '-' }}</b>
          </div>
          <div class="kv-row">
            <span>NISN/NIM</span>
            <b>{{ auth()->user()->nomor_induk ?? '-' }}</b>
          </div>
        </div>
      </div>

      <!-- INFO PENTING -->
      <div class="card2 card2-wide">
        <h2>Informasi Penting</h2>
        <ul class="info-list">
          <li>Pengajuan magang diproses setelah data & berkas lengkap.</li>
          <li>Selama status <b>Menunggu/Diterima</b>, Anda tidak dapat membuat usulan baru.</li>
          <li>Jika <b>Ditolak</b> atau <b>Selesai</b>, Anda dapat mengajukan kembali.</li>
        </ul>
      </div>

    </div>
  </section>
@endsection
