<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Portal Magang')</title>
  <link rel="icon" href="{{ asset('images/favicon.png') }}?v=3">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}?v=3">
  <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}?v=3">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/pemohon.css') }}">
</head>
<body class="app-body">

  <!-- TOP NAV -->
  <header class="app-nav">
    <div class="app-nav-inner">

      <!-- BRAND -->
      <a href="{{ route('pemohon.dashboard') }}" class="app-brand">
        <img src="{{ asset('images/pomas.png') }}" alt="Portal Magang Sragen">
      </a>

      <!-- Toggle (Mobile) -->
<button class="nav-toggle" type="button" id="navToggleBtn" aria-label="Buka Menu">
  ☰
</button>

<!-- MENU -->
<nav class="app-menu" id="appMenu">
  <a
    class="app-link {{ request()->routeIs('pemohon.dashboard') ? 'active' : '' }}"
    href="{{ route('pemohon.dashboard') }}"
  >
    Beranda
  </a>

  <a
    class="app-link {{ request()->routeIs('pemohon.usulan.*') ? 'active' : '' }}"
    href="{{ route('pemohon.usulan.index') }}"
  >
    Usulan Magang
  </a>

  <!-- Profile Dropdown -->
  <div class="dropdown" id="profileDropdownWrap">
    <button class="dropdown-btn" type="button" id="profileDropdownBtn">
      Profil <span class="caret">▾</span>
    </button>

    <div class="dropdown-menu" id="profileDropdownMenu">
      <a class="dropdown-item" href="{{ route('pemohon.profile') }}">
        Edit Profil
      </a>

      <form method="POST" action="{{ route('pemohon.logout') }}">
        @csrf
        <button class="dropdown-item danger" type="submit">
          Logout
        </button>
      </form>
    </div>
  </div>
</nav>


    </div>
  </header>

  <!-- PAGE CONTENT -->
  <main class="app-main">
    @yield('content')
  </main>

  <script>
  (function () {
    // ===== Dropdown Profil =====
    const wrap = document.getElementById('profileDropdownWrap');
    const btn  = document.getElementById('profileDropdownBtn');
    const menu = document.getElementById('profileDropdownMenu');

    const closeProfileMenu = () => menu && menu.classList.remove('show');

    if (wrap && btn && menu) {
      btn.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.toggle('show');
      });

      document.addEventListener('click', function (e) {
        if (!wrap.contains(e.target)) closeProfileMenu();
      });

      menu.addEventListener('click', function (e) {
        const clickedLink = e.target.closest('a.dropdown-item');
        if (clickedLink) closeProfileMenu();
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeProfileMenu();
      });
    }

    // ===== Toggle Navbar (Mobile) =====
    const navBtn = document.getElementById('navToggleBtn');
    const appMenu = document.getElementById('appMenu');

    const closeNav = () => appMenu && appMenu.classList.remove('open');

    if (navBtn && appMenu) {
      navBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        appMenu.classList.toggle('open');
      });

      // tutup menu kalau klik di luar navbar
      document.addEventListener('click', function (e) {
        const navInner = document.querySelector('.app-nav-inner');
        if (navInner && !navInner.contains(e.target)) closeNav();
      });

      // tutup menu setelah klik link
      appMenu.addEventListener('click', function (e) {
        const clickedLink = e.target.closest('a.app-link');
        if (clickedLink) closeNav();
      });

      // tutup menu pakai ESC juga
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeNav();
      });
    }
  })();
</script>


</body>
</html>
