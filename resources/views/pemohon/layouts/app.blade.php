<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Portal Magang')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/pemohon.css') }}">
</head>
<body class="app-body">

  <!-- TOP NAV -->
  <header class="app-nav">
    <div class="app-nav-inner">
      <a href="{{ route('pemohon.dashboard') }}" class="app-brand">
        Portal Magang
      </a>

      <nav class="app-menu">
        <a class="app-link {{ request()->routeIs('pemohon.dashboard') ? 'active' : '' }}"
           href="{{ route('pemohon.dashboard') }}">
          Beranda
        </a>

        <a class="app-link {{ request()->routeIs('pemohon.usulan.*') ? 'active' : '' }}"
           href="{{ route('pemohon.usulan.index') }}">
          Usulan Magang
        </a>

        <!-- Profile Dropdown -->
        <div class="dropdown">
          <button class="dropdown-btn" type="button" onclick="toggleDropdown()">
            Profil
            <span class="caret">▾</span>
          </button>

          <div class="dropdown-menu" id="profileDropdown">
            <a class="dropdown-item" href="{{ route('pemohon.profile') }}">Edit Profil</a>

            <form method="POST" action="{{ route('pemohon.logout') }}">
              @csrf
              <button class="dropdown-item danger" type="submit">Logout</button>
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
    function toggleDropdown() {
      const el = document.getElementById('profileDropdown');
      if (!el) return;
      el.classList.toggle('show');
    }

    // close dropdown if click outside
    document.addEventListener('click', function(e){
      const btn = document.querySelector('.dropdown-btn');
      const menu = document.getElementById('profileDropdown');
      if (!btn || !menu) return;

      const isInside = e.target.closest('.dropdown');
      if (!isInside) menu.classList.remove('show');
    });
  </script>
</body>
</html>
