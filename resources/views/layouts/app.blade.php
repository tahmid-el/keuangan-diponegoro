<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SRIKAN-Diponegoro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-bg: #133e87;
            --sidebar-width: 280px;
            --navbar-height: 70px;
            --text-light: #ffffff;
            --text-dark: #000000;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top left, #e2e8f0 0%, #cbd5e1 100%);
            margin: 0;
            padding: 0;
            color: var(--text-dark);
            min-height: 100vh;
            position: relative;
        }

        /* Animated Blobs for Background */
        body::before, body::after {
            content: ''; position: fixed; border-radius: 50%; filter: blur(80px);
            z-index: -1; animation: float 10s infinite ease-in-out alternate;
        }
        body::before { width: 400px; height: 400px; background: rgba(19,62,135,0.25); top: -100px; right: -100px; }
        body::after  { width: 500px; height: 500px; background: rgba(76,201,240,0.25); bottom: -150px; left: -150px; animation-delay: -5s; }
        @keyframes float { 0% { transform: translate(0,0); } 100% { transform: translate(30px,30px); } }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(19, 62, 135, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 10px 15px;
            display: flex;
            gap: 20px;
            align-items: top;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 10px;
        }

        .sidebar-logo {
            width: 45px;
            height: 45px;
            background-color: white;
            border-radius: 8px;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo img {
            max-width: 100%;
            max-height: 100%;
        }

        .sidebar-title-container {
            line-height: 1.2;
        }

        .sidebar-title {
            font-size: 11px;
            font-weight: 500;
        }

        .sidebar-subtitle {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Navigation Menu */
        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            padding-right: 15px; /* Leave space on right for the rounded corners */
            flex: 1;
            padding: 0 15px; /* Leave space on right for the rounded corners */
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 4px 20px;
            min-height: 46px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-left: none;
            border-radius: 0 10px 10px 0;
            transition: all 0.2s ease;
        }

        .nav-link i {
            font-size: 20px;
            margin-right: 15px;
            width: 24px;
            text-align: center;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-light);
        }

        /* Active Menu Item */
        .nav-link.active {
            background-color: white;
            color: var(--sidebar-bg);
            border-color: white;
            font-weight: 600;
        }

        .nav-link.active i {
            color: var(--sidebar-bg);
        }

        /* Logout Button */
        .logout-container {
            padding: 20px 15px 30px 15px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px 20px;
            background-color: transparent;
            color: var(--text-light);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-logout i {
            margin-right: 10px;
            font-size: 20px;
        }

        .btn-logout:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Main Content Area */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background-color: transparent;
            transition: margin-left 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            height: var(--navbar-height);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .menu-toggle {
            font-size: 24px;
            cursor: pointer;
            margin-right: 20px;
            color: var(--text-dark);
        }

        .role-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        /* Search Bar */
        .search-container {
            position: relative;
            width: 300px;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background-color: white;
            font-size: 14px;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--sidebar-bg);
            box-shadow: 0 0 0 2px rgba(19, 62, 135, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 14px;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
            flex-grow: 1;
            background-color: var(--main-bg);
        }

        /* Date Button */
        .date-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .btn-date {
            background-color: var(--sidebar-bg);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(19, 62, 135, 0.2);
        }

        .btn-date i {
            margin-left: 10px;
            font-size: 16px;
        }

        .btn-date:hover {
            background-color: #0e2d63;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
            .search-container {
                width: 200px;
            }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false }">

    <!-- SIDEBAR -->
    <aside class="sidebar" :class="{ 'show': sidebarOpen }">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('images/dipo.png') }}" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=MTs+D&background=133e87&color=fff'">
            </div>
            <div class="sidebar-title-container">
                <div class="sidebar-title">Sistem Rekapitulasi Informasi Keuangan</div>
                <div class="sidebar-subtitle">MTs DIPONEGORO TEGALSARI</div>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('bendahara.tahun_ajaran.index') }}"
                class="nav-link {{ request()->routeIs('bendahara.tahun_ajaran.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3"></i>
                    Tahun Ajaran
                </a>
            </li>

            @if(auth()->check() && auth()->user()->role == 'bendahara')
            <li class="nav-item">
                <a href="{{ route('bendahara.siswa.index') ?? '#' }}" 
                   class="nav-link {{ request()->routeIs('bendahara.siswa.*') ? 'active' : '' }}">
                    <i class="bi bi-mortarboard"></i>
                    Data Siswa
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bendahara.tagihan.index') ?? '#' }}" 
                   class="nav-link {{ request()->routeIs('bendahara.tagihan.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    Tagihan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bendahara.pembayaran.index') ?? '#' }}" 
                   class="nav-link {{ request()->routeIs('bendahara.pembayaran.*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i>
                    Pembayaran
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bendahara.tabungan.index') ?? '#' }}" 
                   class="nav-link {{ request()->routeIs('bendahara.tabungan.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    Tabungan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bendahara.histori.index') ?? '#' }}" 
                   class="nav-link {{ request()->routeIs('bendahara.histori.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    Histori
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bendahara.pemasukan.index') ?? '#' }}" class="nav-link {{ request()->routeIs('bendahara.pemasukan.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    Pemasukan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bendahara.pengeluaran.index') ?? '#' }}" class="nav-link {{ request()->routeIs('bendahara.pengeluaran.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-arrow-up"></i>
                    Pengeluaran
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bendahara.laporan') ?? '#' }}" class="nav-link {{ request()->routeIs('bendahara.laporan') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    Laporan
                </a>
            </li>
            @endif

            @if(auth()->check() && auth()->user()->role == 'kepala_sekolah')
            <li class="nav-item">
                <a href="{{ route('kepsek.histori.index') ?? '#' }}" 
                   class="nav-link {{ request()->routeIs('kepsek.histori.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    Histori
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kepsek.laporan') ?? '#' }}" class="nav-link {{ request()->routeIs('kepsek.laporan') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    Laporan
                </a>
            </li>
            @endif

            @if(auth()->check() && auth()->user()->role == 'siswa')
            <li class="nav-item">
                <a href="{{ route('siswa.tagihan') ?? '#' }}" class="nav-link {{ request()->routeIs('siswa.tagihan') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    Tagihan Saya
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.tabungan') ?? '#' }}" class="nav-link {{ request()->routeIs('siswa.tabungan') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    Tabungan Saya
                </a>
            </li>
            @endif
        </ul>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        
        <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <div class="navbar-left d-flex align-items-center">
                <i class="bi bi-list menu-toggle me-3" style="cursor:pointer;" @click="sidebarOpen = !sidebarOpen"></i>
                <!-- <h1 class="role-title m-0 d-none d-md-block" style="color: var(--sidebar-bg);">{{ ucfirst(auth()->user()->role ?? 'Guest') }}</h1> -->
            </div>
            
            <div class="navbar-right d-flex align-items-center">
                <div class="search-container me-4 d-none d-lg-block">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Cari di sini...">
                </div>

                <!-- User Profile Dropdown (Alpine.js) -->
                <div class="user-profile position-relative" x-data="{ userMenuOpen: false }">
                    <div class="d-flex align-items-center p-2" style="cursor: pointer; border-radius: 30px; transition: background 0.2s;" @click="userMenuOpen = !userMenuOpen" @click.outside="userMenuOpen = false" :style="userMenuOpen ? 'background: rgba(19, 62, 135, 0.08);' : ''" onmouseover="this.style.background='rgba(19, 62, 135, 0.05)'" onmouseout="if(!userMenuOpen) this.style.background='transparent'">
                        <div class="text-end me-3 d-none d-sm-block">
                            <div style="font-weight: 600; font-size: 14px; color: var(--text-dark);">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                            <div style="font-size: 12px; color: #64748b;">{{ auth()->user()->email ?? 'user@email.com' }}</div>
                        </div>
                        <div class="avatar-circle shadow-sm" style="width: 40px; height: 40px; background: linear-gradient(135deg, #133e87, #2463d1); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <i class="bi bi-chevron-down ms-2 text-muted" style="font-size: 14px;"></i>
                    </div>

                    <!-- Dropdown Menu -->
                    <div x-show="userMenuOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         style="display: none; position: absolute; right: 0; top: 120%; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.5); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 240px; z-index: 1000; padding: 12px;">
                        
                        <div class="d-block d-sm-none p-2 border-bottom mb-2">
                            <div style="font-weight: 600; font-size: 14px;">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                            <div style="font-size: 12px; color: #64748b; word-break: break-all;">{{ auth()->user()->email ?? 'user@email.com' }}</div>
                        </div>
                        
                        <div class="p-2">
                            <div style="font-size: 11px; text-transform: uppercase; color: #888; font-weight: bold; margin-bottom: 5px;">Akses & Peran</div>
                            <div class="badge rounded-pill" style="background-color: rgba(19, 62, 135, 0.1); color: var(--sidebar-bg); font-weight: 600; padding: 6px 12px;">
                                <i class="bi bi-shield-check me-1"></i> {{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'Guest')) }}
                            </div>
                        </div>
                        
                        <hr class="my-2" style="border-color: #eee;">
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn w-100 text-start d-flex align-items-center" style="color: #ef4444; border-radius: 8px; padding: 10px 12px; font-weight: 500; transition: background 0.2s;" onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                                <i class="bi bi-box-arrow-right me-2" style="font-size: 18px;"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <main class="content-area">

            <!-- ALERT SUCCESS -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
            @endif

            <!-- ALERT ERROR -->
            @if ($errors->any())
            <div class="alert alert-danger">

                <strong>
                    Data belum tersimpan, perbaiki form berikut:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
            @endif
                        
            <!-- Page Content injects here -->
            @yield('content')

        </main>
    </div>

    <!-- Alpine.js for interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- ApexCharts for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    <!-- Script untuk membatasi input Date Range secara dinamis -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startInputs = document.querySelectorAll('input[name="startdate"]');
            const endInputs = document.querySelectorAll('input[name="enddate"]');
            
            startInputs.forEach((startInput, index) => {
                const endInput = endInputs[index];
                if (startInput && endInput) {
                    // Set batasan awal saat dimuat
                    if (startInput.value) endInput.min = startInput.value;
                    if (endInput.value) startInput.max = endInput.value;
                    
                    // Update batasan saat tanggal dipilih
                    startInput.addEventListener('change', function() {
                        endInput.min = this.value;
                    });
                    endInput.addEventListener('change', function() {
                        startInput.max = this.value;
                    });
                }
            });
        });
    </script>
</body>
</html>
