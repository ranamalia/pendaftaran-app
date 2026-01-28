<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Magang - Kabupaten Sragen</title>
  <meta name="description" content="Platform resmi untuk mendaftarkan diri mengikuti program magang di berbagai instansi pemerintahan Kabupaten Sragen.">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/pemohon.css') }}">
</head>
<body class="landing-body">

  <!-- NAVBAR -->
  <header class="nav">
    <div class="nav-inner">
      <div class="brand">Portal Magang</div>
      <nav class="nav-actions">
        <a class="btn-outline" href="{{ route('pemohon.login') }}">Masuk</a>
        <a class="btn-primary" href="{{ route('pemohon.register') }}">Daftar</a>
      </nav>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-inner">
      <h1>Pendaftaran Magang Pemerintah</h1>
      <p class="hero-subtitle">Kabupaten Sragen</p>
      <p class="hero-desc">
        Platform resmi untuk mendaftarkan diri mengikuti program magang di berbagai instansi pemerintahan Kabupaten Sragen.
      </p>
      <div class="hero-actions">
        <a class="btn-primary" href="{{ route('pemohon.register') }}">Daftar Sekarang</a>
        <a class="btn-outline" href="{{ route('pemohon.login') }}">Masuk</a>
      </div>
    </div>
  </section>

  <!-- ALUR PENDAFTARAN -->
<section class="section">
  <h2 class="section-title">Alur Pendaftaran</h2>
  <p class="section-desc">Ikuti langkah berikut agar pengajuan magang Anda diproses.</p>

  <div class="flow-wrap">

    <!-- Desktop: Timeline SVG horizontal -->
    <svg class="flow-svg flow-svg-desktop" viewBox="0 0 1000 220" role="img" aria-label="Alur pendaftaran magang">
      <line x1="90" y1="110" x2="910" y2="110" stroke="#cbd5e1" stroke-width="6" stroke-linecap="round"/>

      <circle cx="90" cy="110" r="28" fill="#FF6600"/>
      <text x="90" y="118" text-anchor="middle" font-size="18" font-family="Poppins" fill="#FFFFFF" font-weight="700">1</text>

      <circle cx="295" cy="110" r="28" fill="#FF6600"/>
      <text x="295" y="118" text-anchor="middle" font-size="18" font-family="Poppins" fill="#FFFFFF" font-weight="700">2</text>

      <circle cx="500" cy="110" r="28" fill="#FF6600"/>
      <text x="500" y="118" text-anchor="middle" font-size="18" font-family="Poppins" fill="#FFFFFF" font-weight="700">3</text>

      <circle cx="705" cy="110" r="28" fill="#FF6600"/>
      <text x="705" y="118" text-anchor="middle" font-size="18" font-family="Poppins" fill="#FFFFFF" font-weight="700">4</text>

      <circle cx="910" cy="110" r="28" fill="#FF6600"/>
      <text x="910" y="118" text-anchor="middle" font-size="18" font-family="Poppins" fill="#FFFFFF" font-weight="700">5</text>
    </svg>

    <!-- Desktop: Cards 5 kolom -->
    <div class="flow-grid-desktop">
      <div class="flow-item">
        <div class="flow-title">Daftar Akun</div>
        <div class="flow-text">Pilih tipe SMK/Mahasiswa lalu buat akun.</div>
      </div>
      <div class="flow-item">
        <div class="flow-title">Lengkapi Profil</div>
        <div class="flow-text">Isi data instansi, jurusan/prodi, dan kontak.</div>
      </div>
      <div class="flow-item">
        <div class="flow-title">Ajukan Magang</div>
        <div class="flow-text">Pilih instansi tujuan dan periode magang.</div>
      </div>
      <div class="flow-item">
        <div class="flow-title">Upload Berkas</div>
        <div class="flow-text">Unggah surat, CV, dan dokumen pendukung.</div>
      </div>
      <div class="flow-item">
        <div class="flow-title">Pantau Status</div>
        <div class="flow-text">Lihat status: menunggu/diterima/ditolak.</div>
      </div>
    </div>

    <!-- Mobile: Node sejajar dengan card -->
    <div class="flow-mobile">
      <div class="flow-row">
        <div class="flow-node">
          <div class="dot">1</div>
          <div class="vline"></div>
        </div>
        <div class="flow-item">
          <div class="flow-title">Daftar Akun</div>
          <div class="flow-text">Pilih tipe SMK/Mahasiswa lalu buat akun.</div>
        </div>
      </div>

      <div class="flow-row">
        <div class="flow-node">
          <div class="dot">2</div>
          <div class="vline"></div>
        </div>
        <div class="flow-item">
          <div class="flow-title">Lengkapi Profil</div>
          <div class="flow-text">Isi data instansi, jurusan/prodi, dan kontak.</div>
        </div>
      </div>

      <div class="flow-row">
        <div class="flow-node">
          <div class="dot">3</div>
          <div class="vline"></div>
        </div>
        <div class="flow-item">
          <div class="flow-title">Ajukan Magang</div>
          <div class="flow-text">Pilih instansi tujuan dan periode magang.</div>
        </div>
      </div>

      <div class="flow-row">
        <div class="flow-node">
          <div class="dot">4</div>
          <div class="vline"></div>
        </div>
        <div class="flow-item">
          <div class="flow-title">Upload Berkas</div>
          <div class="flow-text">Unggah surat, CV, dan dokumen pendukung.</div>
        </div>
      </div>

      <div class="flow-row">
        <div class="flow-node">
          <div class="dot">5</div>
        </div>
        <div class="flow-item">
          <div class="flow-title">Pantau Status</div>
          <div class="flow-text">Lihat status: menunggu/diterima/ditolak.</div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- PERSYARATAN PENDAFTARAN -->
  <section class="section section-light">
    <h2 class="section-title">Persyaratan Pendaftaran</h2>

    <div class="req-grid">
      <div class="req-card">
        <h3>Untuk SMK</h3>
        <ul>
          <li>NISN yang terdaftar</li>
          <li>Surat rekomendasi dari sekolah</li>
          <li>CV yang terstruktur</li>
          <li>Surat lamaran</li>
        </ul>
      </div>

      <div class="req-card">
        <h3>Untuk Mahasiswa</h3>
        <ul>
          <li>NIM yang terdaftar</li>
          <li>Surat rekomendasi dari kampus</li>
          <li>CV yang profesional</li>
          <li>Surat lamaran</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- CTA SECTION -->
  <section class="cta">
    <div class="cta-inner">
      <h2>Siap Memulai Magang?</h2>
      <p>Daftarkan diri Anda sekarang dan mulai perjalanan karir Anda bersama kami.</p>
      <a class="btn-primary" href="{{ route('pemohon.register') }}">Daftar Sekarang</a>
    </div>
  </section>

</body>
</html>
