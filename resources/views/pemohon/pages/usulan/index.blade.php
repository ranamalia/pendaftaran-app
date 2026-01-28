@extends('pemohon.layouts.app')

@section('title', 'Usulan Magang - Portal Magang')

@section('content')
  <section class="page">
    <h1 class="page-title">Usulan Magang</h1>
    <p class="page-desc">Halaman ini untuk melihat status usulan dan (besok) membuat pengajuan baru.</p>

    <div class="card2">
      <h2>Status Saat Ini</h2>
      <p class="muted">Belum ada usulan magang.</p>

      <button class="btn-primary2" type="button" disabled title="Besok kita bikin formnya">
        + Buat Usulan Magang
      </button>
    </div>
  </section>
@endsection
