<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRIKAN-Diponegoro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar p-3" style="width:270px;">
        <div class="d-flex align-items-center mb-4">
                    <!-- Logo -->
                    <div class="bg-white rounded-circle p-2 me-3">
            <img 
                src="{{ asset('images/logo_sekolah.png') }}" 
                width="40"
            >
        </div>
        <div class="text-white">
            <div style="font-size: 13px; font-weight: 600; line-height: 1.2;">
                Sistem Rekapitulasi Informasi Keuangan
            </div>

            <div style="font-size: 13px; line-height: 1.2;">
                MTs DIPONEGORO TEGALSARI
            </div>
            </div>
        </div>
        
        <!-- Menu -->
        <ul class="nav flex-column">

            <li class="nav-item mb-2">
                <a href="/dashboard" class="nav-link active">
                    <i class="bi bi-house-door me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/data_siswa" class="nav-link">
                    <i class="bi bi-mortarboard me-2"></i> Data Siswa
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/tagihan" class="nav-link">
                    <i class="bi bi-receipt me-2"></i> Tagihan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/pembayaran" class="nav-link">
                    <i class="bi bi-wallet2 me-2"></i> Pembayaran
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/tabungan" class="nav-link">
                    <i class="bi bi-cash-stack me-2"></i> Tabungan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/pemasukan" class="nav-link">
                    <i class="bi bi-graph-up-arrow me-2"></i> Pemasukan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/pengeluaran" class="nav-link">
                    <i class="bi bi-graph-down-arrow me-2"></i> Pengeluaran
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/history" class="nav-link">
                    <i class="bi bi-clock-history me-2"></i> History
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="/laporan" class="nav-link">
                    <i class="bi bi-file-earmark-text me-2"></i> Laporan
                </a>
            </li>
        </ul>

        <!-- Logout -->
        <div class="mt-auto pt-5">
            <a href="/logout" class="nav-link border rounded-pill text-center">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="flex-grow-1">

        <!-- TOP NAVBAR -->
        <div class="navbar-custom d-flex justify-content-between align-items-center p-3">

            <!-- Role -->
            <div class="d-flex align-items-center">
                <i class="bi bi-list fs-4 me-3"></i>
                <h5 class="mb-0 fw-bold">Admin</h5>
            </div>

            <!-- Search -->
            <div>
                <input 
                    type="text" 
                    class="form-control"
                    placeholder="Cari di sini..."
                    style="width:250px;"
                >
            </div>
        </div>

        <!-- Calendar -->
        <div class="p-3 text-end">
            <button class="btn btn-primary">
                Maret 01 - Maret 31
                <i class="bi bi-calendar-event ms-2"></i>
            </button>
        </div>

        <!-- Dynamic Content -->
        <div class="content">
            @yield('content')
        </div>

    </div>
</div>

</body>
</html>