<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Keuangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3">
    <a class="navbar-brand" href="#">Keuangan Sekolah</a>
</nav>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3" style="width:250px;">
        <h5>Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="/dashboard" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Pemasukan</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Pengeluaran</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">History Operasional</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Data Siswa</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Tagihan</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Pembayaran</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Tabungan</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Laporan</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content flex-grow-1">
        @yield('content')
    </div>
</div>

</body>
</html>