@extends('pemohon.layouts.app')

@section('title', 'Profil - Portal Magang')

@section('content')
  <section class="page">
    <h1 class="page-title">Profil</h1>
    <p class="page-desc">Besok kita bikin form edit profil lengkap ya.</p>

    <div class="card2">
      <h2>Data Akun</h2>

      <div class="kv">
        <div class="kv-row"><span>Nama</span><b>{{ auth()->user()->name }}</b></div>
        <div class="kv-row"><span>Email</span><b>{{ auth()->user()->email }}</b></div>
        <div class="kv-row"><span>No HP</span><b>{{ auth()->user()->no_hp ?? '-' }}</b></div>
      </div>
    </div>
  </section>
@endsection
