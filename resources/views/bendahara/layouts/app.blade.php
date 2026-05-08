<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bendahara Dashboard - SRIKAN-Diponegoro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #133e87;
            --main-bg: #f4f3ea; /* Light beige matching the image */
            --text-light: #ffffff;
            --text-dark: #000000;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--main-bg);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            color: var(--text-light);
            width: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px 15px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-logo {
            width: 45px;
            height: 45px;
            background-color: white;
            border-radius: 8px;
            padding: 2px;
            margin-right: 12px;
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
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
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
            background-color: var(--main-bg);
            color: var(--text-dark);
            border-color: var(--main-bg);
            font-weight: 600;
        }

        .nav-link.active i {
            color: var(--text-dark);
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
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: var(--main-bg);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
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
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('images/logo_sekolah.png') }}" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=MTs+D&background=133e87&color=fff'">
            </div>
            <div class="sidebar-title-container">
                <div class="sidebar-title">Sistem Rekapitulasi Informasi Keuangan</div>
                <div class="sidebar-subtitle">Mts DIPONEGORO TEGALSARI</div>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('bendahara.dashboard') }}" class="nav-link {{ request()->routeIs('bendahara.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    Pemasukan
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-arrow-up"></i>
                    Pengeluaran
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-clock-history"></i>
                    History
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i>
                    Laporan
                </a>
            </li>
        </ul>

        <div class="logout-container">
            <a href="/logout" class="btn-logout">
                <i class="bi bi-box-arrow-in-left"></i>
                Logout
            </a>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        
        <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <div class="navbar-left">
                <i class="bi bi-list menu-toggle"></i>
                <h1 class="role-title">Admin</h1> <!-- Text 'Admin' based on user image -->
            </div>
            
            <div class="search-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Cari di sini...">
            </div>
        </header>

        <!-- CONTENT AREA -->
        <main class="content-area">
            
            <!-- Page Content injects here -->
            @yield('content')

        </main>
    </div>

    <!-- Alpine.js for interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- ApexCharts for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @stack('scripts')
</body>
</html>
