@extends('pemohon.layouts.app')

@section('content')
@php
    use App\Enums\ApplicationStatus;
    use App\Enums\ApplicationFileType;

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

    // ===== Helpers dokumen (butuh $last->load('files') di controller) =====
    $doc = function ($app, ApplicationFileType $type) {
        if (!$app) return null;
        if (!$app->relationLoaded('files')) return null;
        return $app->files->firstWhere('type', $type);
    };

    $fileLink = function ($file) {
        if (!$file) return '-';

        $download = '<a href="'.route('pemohon.usulan.file.download', $file->id).'" style="margin-left:10px;">Download</a>';

        return $download;
    };
@endphp

<div class="app-main">
    <h1 class="page-title">Usulan Magang</h1>
    <p class="page-desc">Kelola pengajuan magang Anda dan pantau status permohonan</p>

    @if(session('success'))
        <div class="toast-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="toast-error">{{ session('error') }}</div>
    @endif

    <!-- Status Terakhir -->
    @if($last)
        <div class="card2" style="margin-bottom: 20px;">
            <h2>Status Usulan Terakhir</h2>

            <div class="kv" style="margin-bottom: 14px;">
                <div class="kv-row">
                    <span>Status</span>
                    <b>{!! $statusPill($last->status) !!}</b>
                </div>

                <div class="kv-row">
                    <span>OPD Tujuan</span>
                    <b>{{ $last->opd->nama ?? '-' }}</b>
                </div>

                <div class="kv-row">
                    <span>Kategori</span>
                    <b>{{ ucfirst($last->kategori) }}</b>
                </div>

                <div class="kv-row">
                    <span>Institusi</span>
                    <b>{{ $last->institusi }}</b>
                </div>

                <div class="kv-row">
                    <span>Periode</span>
                    <b>{{ $last->tanggal_mulai->format('d M Y') }} - {{ $last->tanggal_selesai->format('d M Y') }}</b>
                </div>

                {{-- Dokumen pemohon --}}
                <div class="kv-row">
                    <span>Surat Pengantar</span>
                    <b>{!! $fileLink($doc($last, ApplicationFileType::SURAT_PENGANTAR)) !!}</b>
                </div>
                <div class="kv-row">
                    <span>Proposal</span>
                    <b>{!! $fileLink($doc($last, ApplicationFileType::PROPOSAL)) !!}</b>
                </div>
                <div class="kv-row">
                    <span>CV</span>
                    <b>{!! $fileLink($doc($last, ApplicationFileType::CV)) !!}</b>
                </div>
                <div class="kv-row">
                    <span>Transkrip/Rapor</span>
                    <b>{!! $fileLink($doc($last, ApplicationFileType::TRANSKRIP_RAPOR)) !!}</b>
                </div>

                {{-- Dokumen admin (kalau sudah ada) --}}
                <div class="kv-row">
                    <span>Surat Jawaban Izin</span>
                    <b>{!! $fileLink($doc($last, ApplicationFileType::SURAT_JAWABAN_IZIN)) !!}</b>
                </div>
                <div class="kv-row">
                    <span>Surat Keterangan Selesai</span>
                    <b>{!! $fileLink($doc($last, ApplicationFileType::SURAT_KETERANGAN_SELESAI)) !!}</b>
                </div>
            </div>

            @if($last->status === ApplicationStatus::DITOLAK->value && $last->alasan_penolakan)
                <div class="alert alert-error">
                    <strong>Alasan Penolakan:</strong><br>
                    {{ $last->alasan_penolakan }}
                </div>
            @endif
        </div>
    @endif

    <!-- Form Pengajuan -->
    <div class="card2">
        <h2>
            @if(!$bolehAjukan && $last)
                Tidak Dapat Mengajukan
            @else
                Form Pengajuan Usulan
            @endif
        </h2>

        @if(!$bolehAjukan && $last)
            <div class="alert alert-error">
                Anda belum bisa mengajukan usulan baru karena status usulan terakhir masih
                <strong>{{ $statusLabel($last->status) }}</strong>.
                <br><br>
                <small>Silakan tunggu hingga status berubah atau hubungi administrator.</small>
            </div>
        @elseif(!$last)
            <p class="muted">Anda belum pernah mengajukan usulan magang sebelumnya. Lengkapi form di bawah untuk memulai.</p>
        @endif

        @if($bolehAjukan)
            <form method="POST"
                  action="{{ route('pemohon.usulan.store') }}"
                  enctype="multipart/form-data"
                  class="form2">
                @csrf

                <div class="form2-section">
                    <h3 class="form2-section-title">Informasi OPD & Kategori</h3>

                    <div class="form2-row">
                        <label class="form2-label">OPD Tujuan <span class="required">*</span></label>
                        <select name="opd_id" class="form2-input" required>
                            <option value="">-- Pilih OPD --</option>
                            @foreach($opds as $opd)
                                <option value="{{ $opd->id }}" @selected(old('opd_id') == $opd->id)>
                                    {{ $opd->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('opd_id') <small class="form2-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="form2-grid">
                        <div class="form2-row">
                            <label class="form2-label">Kategori <span class="required">*</span></label>
                            <select name="kategori" class="form2-input" required>
                                <option value="">-- Pilih --</option>
                                <option value="mahasiswa" @selected(old('kategori')=='mahasiswa')>Mahasiswa</option>
                                <option value="smk" @selected(old('kategori')=='smk')>SMK</option>
                            </select>
                            @error('kategori') <small class="form2-error">{{ $message }}</small> @enderror
                        </div>

                        <div class="form2-row">
                            <label class="form2-label">Institusi <span class="required">*</span></label>
                            <input type="text" name="institusi" value="{{ old('institusi') }}" class="form2-input" placeholder="Nama kampus/sekolah" required>
                            @error('institusi') <small class="form2-error">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="form2-section">
                    <h3 class="form2-section-title">Informasi Kontak</h3>

                    <div class="form2-grid">
                        <div class="form2-row">
                            <label class="form2-label">Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan') }}" class="form2-input" placeholder="Program studi/jurusan">
                            @error('jurusan') <small class="form2-error">{{ $message }}</small> @enderror
                        </div>

                        <div class="form2-row">
                            <label class="form2-label">Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}" class="form2-input" placeholder="Nomor telepon">
                            @error('telepon') <small class="form2-error">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="form2-section">
                    <h3 class="form2-section-title">Periode Magang</h3>

                    <div class="form2-grid">
                        <div class="form2-row">
                            <label class="form2-label">Tanggal Mulai <span class="required">*</span></label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="form2-input" required>
                            @error('tanggal_mulai') <small class="form2-error">{{ $message }}</small> @enderror
                        </div>

                        <div class="form2-row">
                            <label class="form2-label">Tanggal Selesai <span class="required">*</span></label>
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form2-input" required>
                            @error('tanggal_selesai') <small class="form2-error">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                {{-- Upload Berkas (Wajib semua) --}}
                <div class="form2-section">
                    <h3 class="form2-section-title">Upload Berkas (Wajib)</h3>

                    <div class="form2-row">
                        <label class="form2-label">Surat Pengantar (PDF) <span class="required">*</span></label>
                        <input type="file" name="surat_pengantar" class="form2-input" required accept=".pdf,application/pdf">
                        @error('surat_pengantar') <small class="form2-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="form2-row">
                        <label class="form2-label">Proposal (PDF) <span class="required">*</span></label>
                        <input type="file" name="proposal" class="form2-input" required accept=".pdf,application/pdf">
                        @error('proposal') <small class="form2-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="form2-row">
                        <label class="form2-label">CV (PDF) <span class="required">*</span></label>
                        <input type="file" name="cv" class="form2-input" required accept=".pdf,application/pdf">
                        @error('cv') <small class="form2-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="form2-row">
                        <label class="form2-label">Transkrip / Rapor (PDF/JPG/PNG) <span class="required">*</span></label>
                        <input type="file" name="transkrip_rapor" class="form2-input" required accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*">
                        @error('transkrip_rapor') <small class="form2-error">{{ $message }}</small> @enderror
                    </div>

                    <small class="muted">
                        Maks ukuran: 4MB per file.
                    </small>
                </div>

                <div class="actions" style="margin-top: 20px;">
                    <button type="submit" class="btn-primary2">Kirim Usulan</button>
                    <a href="{{ route('pemohon.dashboard') }}" class="btn-outline2">Batal</a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
