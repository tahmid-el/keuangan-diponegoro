@extends('layouts.app')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards;
        opacity: 0;
    }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .glass-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(19, 62, 135, 0.1);
    }
    .icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .icon-primary { background: rgba(19, 62, 135, 0.1); color: var(--sidebar-bg); }
    .icon-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .icon-warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .icon-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    
    .card-title-custom {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .card-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-dark);
        margin-top: 2px;
    }
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }
    .greeting {
        font-size: 20px;
        font-weight: 700;
        color: var(--sidebar-bg);
        margin-bottom: 2px;
    }
    
    /* Input Date Customization */
    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0.6;
        cursor: pointer;
    }
</style>

<div class="dashboard-header">
    <div>
        <h3 class="greeting">Halo, {{ auth()->user()->name ?? 'Pengguna' }}! 👋</h3>
        <p class="text-muted mb-0" style="font-size: 13px;">Selamat datang kembali di Dashboard Anda.</p>
    </div>
    
    <!-- Filter Tanggal -->
    <div class="d-flex align-items-center">
        <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center bg-white rounded-pill p-1 shadow-sm" style="border: 1px solid rgba(0,0,0,0.05);">
            <div class="px-2" style="position: relative;">
                <input type="date" name="startdate" value="{{ $startDate }}" class="form-control border-0 bg-transparent text-muted p-0 m-0" style="font-size: 13px; outline: none; box-shadow: none; width: 110px;">
            </div>
            <span class="text-muted" style="font-size: 13px; font-weight: 600;">-</span>
            <div class="px-2" style="position: relative;">
                <input type="date" name="enddate" value="{{ $endDate }}" class="form-control border-0 bg-transparent text-muted p-0 m-0" style="font-size: 13px; outline: none; box-shadow: none; width: 110px;">
            </div>
            <button type="submit" class="btn rounded-pill btn-sm ms-1 px-3 d-flex align-items-center" style="background: rgba(19, 62, 135, 0.9); color: white; border: none; font-weight: 500; font-size: 13px; transition: 0.3s;" onmouseover="this.style.background='#133e87'" onmouseout="this.style.background='rgba(19, 62, 135, 0.9)'">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
        </form>
    </div>
</div>

<div class="row g-3 mb-3">
    <!-- Card 1 -->
    <div class="col-md-3">
        <div class="glass-card p-3 h-100 d-flex flex-column justify-content-between" style="animation-delay: 0.1s;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="card-title-custom">Saldo Kas</div>
                <div class="icon-wrapper icon-primary"><i class="bi bi-wallet2"></i></div>
            </div>
            <div class="card-value">Rp {{ number_format($saldoKas, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-3">
        <div class="glass-card p-3 h-100 d-flex flex-column justify-content-between" style="animation-delay: 0.2s;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="card-title-custom">Pemasukan</div>
                <div class="icon-wrapper icon-success"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
            <div class="card-value">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-3">
        <div class="glass-card p-3 h-100 d-flex flex-column justify-content-between" style="animation-delay: 0.3s;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="card-title-custom">Pengeluaran</div>
                <div class="icon-wrapper icon-danger"><i class="bi bi-graph-down-arrow"></i></div>
            </div>
            <div class="card-value">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="col-md-3">
        <div class="glass-card p-3 h-100 d-flex flex-column justify-content-between" style="animation-delay: 0.4s;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="card-title-custom">Total Transaksi</div>
                <div class="icon-wrapper icon-warning"><i class="bi bi-arrow-left-right"></i></div>
            </div>
            <div class="card-value">{{ $totalTransaksi }} <span style="font-size: 14px; color: #64748b; font-weight: 500;">Transaksi</span></div>
        </div>
    </div>
</div>

@if(auth()->check() && (auth()->user()->role == 'bendahara' || auth()->user()->role == 'kepala_sekolah'))
<div class="row g-3">
    <div class="col-md-8">
        <div class="glass-card p-3 h-100" style="animation-delay: 0.5s;">
            <h6 style="color: var(--sidebar-bg); font-weight: 600;" class="mb-3">Statistik Keuangan (Pemasukan - Pengeluaran)</h6>
            <div style="background: rgba(255,255,255,0.4); border-radius: 10px;">
                <div id="financeChart" style="min-height: 250px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card p-3 h-100" style="animation-delay: 0.6s;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 style="color: var(--sidebar-bg); font-weight: 600;" class="m-0">Informasi</h6>
            </div>
            
            <div class="alert mb-3" style="background: rgba(19, 62, 135, 0.05); border: 1px solid rgba(19, 62, 135, 0.1); border-radius: 12px; padding: 12px;">
                <div class="d-flex">
                    <i class="bi bi-info-circle-fill me-2 mt-1" style="color: var(--sidebar-bg);"></i>
                    <div style="font-size: 13px; color: var(--text-dark);">
                        <strong>Tampilan Real-time</strong><br>
                        Kartu ringkasan Pemasukan, Pengeluaran, Total Transaksi, beserta Grafik diatur untuk menampilkan data berdasarkan <strong>rentang tanggal</strong> yang Anda pilih. 
                    </div>
                </div>
            </div>

            <div class="alert m-0" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1); border-radius: 12px; padding: 12px;">
                <div class="d-flex">
                    <i class="bi bi-wallet-fill me-2 mt-1" style="color: #10b981;"></i>
                    <div style="font-size: 13px; color: var(--text-dark);">
                        <strong>Saldo Kas</strong><br>
                        Saldo Kas menghitung selisih <u>semua uang masuk</u> dan <u>semua uang keluar</u> sejak awal aplikasi digunakan, tanpa dibatasi filter tanggal.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- ApexCharts Setup -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: [{
                name: 'Pemasukan',
                data: {!! json_encode($pemasukanChart) !!}
            }, {
                name: 'Pengeluaran',
                data: {!! json_encode($pengeluaranChart) !!}
            }],
            chart: {
                type: 'area',
                height: 250,
                toolbar: { show: false },
                fontFamily: 'Outfit, sans-serif',
                zoom: { enabled: false }
            },
            colors: ['#10b981', '#ef4444'],
            fill: {
                type: 'gradient',
                gradient: { 
                    shadeIntensity: 1, 
                    opacityFrom: 0.4, 
                    opacityTo: 0.05, 
                    stops: [0, 90, 100] 
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: {!! json_encode($dates) !!},
                tickAmount: 6,
                tooltip: { enabled: false },
                labels: {
                    style: { colors: '#64748b', fontSize: '11px' },
                    rotate: 0,
                    hideOverlappingLabels: true
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                forceNiceScale: true,
                min: 0,
                decimalsInFloat: 0,
                labels: {
                    style: { colors: '#64748b', fontSize: '11px' },
                    formatter: function (value) {
                        if (value === 0) return "Rp 0";
                        if (value >= 1000000000) return "Rp " + (value / 1000000000).toFixed(1).replace('.0', '') + " M";
                        if (value >= 1000000) return "Rp " + (value / 1000000).toFixed(1).replace('.0', '') + " Jt";
                        if (value >= 1000) return "Rp " + (value / 1000).toFixed(1).replace('.0', '') + " rb";
                        return "Rp " + value;
                    }
                }
            },
            grid: {
                borderColor: 'rgba(0,0,0,0.05)',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                markers: { radius: 12 }
            }
        };

        var chart = new ApexCharts(document.querySelector("#financeChart"), options);
        chart.render();
    });
</script>

@endsection