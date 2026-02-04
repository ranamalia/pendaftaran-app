@extends('pemohon.layouts.app')

@section('content')
@php
    use App\Enums\ApplicationStatus;

    $statusLabel = fn ($status) => match ($status) {
        ApplicationStatus::DIPROSES->value => 'DIPROSES',
        ApplicationStatus::DISETUJUI->value => 'DISETUJUI',
        ApplicationStatus::DITOLAK->value => 'DITOLAK',
        ApplicationStatus::SELESAI->value => 'SELESAI',
        default => strtoupper((string) $status),
    };

    $statusPill = function ($status) use ($statusLabel) {
        $label = $statusLabel($status);

        return match ($status) {
            ApplicationStatus::DIPROSES->value => '<span class="pill" style="background:#fef3c7;color:#92400e;">'.$label.'</span>',
            ApplicationStatus::DISETUJUI->value => '<span class="pill" style="background:#dcfce7;color:#166534;">'.$label.'</span>',
            ApplicationStatus::DITOLAK->value => '<span class="pill" style="background:#fee2e2;color:#991b1b;">'.$label.'</span>',
            ApplicationStatus::SELESAI->value => '<span class="pill" style="background:#e0e7ff;color:#3730a3;">'.$label.'</span>',
            default => '<span class="pill">'.$label.'</span>',
        };
    };
@endphp

<div class="app-main">
    <h1 class="page-title">Beranda</h1>

    <div class="hero2" style="margin-top: 14px;">
        <div class="hero2-inner">
            <div>
                <h2 class="hero2-title">Halo, {{ $user->name }}</h2>
                <p class="hero2-subtitle">Selamat datang di sistem pengajuan magang</p>
                <p class="hero2-desc">
                    @if(!$last)
                        Mulai proses pengajuan magang Anda sekarang untuk mendapatkan pengalaman praktik di berbagai organisasi.
                    @else
                        Pantau status pengajuan magang Anda dan kelola dokumen-dokumen penting untuk kesuksesan praktik Anda.
                    @endif
                </p>
            </div>

            <div class="hero2-right">
                <img class="hero2-img" src="{{ asset('images/hero-dashboard.png') }}" alt="Hero Dashboard">
            </div>
        </div>
    </div>

    <div class="dash2" style="margin-top: 20px;">
        <div class="dash2-grid">
            <!-- Status Card -->
            <div class="card2">
                <h2>Status Pengajuan Terakhir</h2>

                @if(!$last)
                    <p class="muted">Anda belum pernah mengajukan usulan magang.</p>
                    <div class="actions">
                        <a href="{{ route('pemohon.usulan.index') }}" class="btn-primary2">Ajukan Magang</a>
                    </div>
                @else
                    <div class="kv">
                        <div class="kv-row">
                            <span>Status</span>
                            <b>{!! $statusPill($last->status) !!}</b>
                        </div>
                        <div class="kv-row">
                            <span>OPD Tujuan</span>
                            <b>{{ $last->opd->nama ?? '-' }}</b>
                        </div>
                        <div class="kv-row">
                            <span>Periode</span>
                            <b>{{ $last->tanggal_mulai->format('d M Y') }} - {{ $last->tanggal_selesai->format('d M Y') }}</b>
                        </div>
                    </div>

                    @if($last->status === ApplicationStatus::DITOLAK->value && $last->alasan_penolakan)
                        <div class="alert alert-error" style="margin-top: 12px;">
                            <strong>Alasan Penolakan:</strong><br>
                            {{ $last->alasan_penolakan }}
                        </div>
                    @endif

                    <div class="actions">
                        <a href="{{ route('pemohon.usulan.index') }}" class="btn-primary2">Lihat Detail</a>

                        @if(in_array($last->status, [ApplicationStatus::DITOLAK->value, ApplicationStatus::SELESAI->value], true))
                            <a href="{{ route('pemohon.usulan.index') }}" class="btn-outline2">Ajukan Lagi</a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Informasi Akun -->
            <div class="card2">
                <h2>Informasi Akun</h2>

                <ul class="info-list">
                    <li><b>Email:</b> {{ $user->email }}</li>
                    <li><b>Tipe:</b> {{ ucfirst($user->pemohon_tipe) }}</li>
                    <li><b>Akun Dibuat:</b> {{ $user->created_at->format('d M Y') }}</li>
                </ul>

                <div class="actions" style="margin-top: 14px;">
                    <a href="{{ route('pemohon.profile') }}" class="btn-outline2">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
