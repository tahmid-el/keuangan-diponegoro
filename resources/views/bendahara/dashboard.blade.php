@extends('bendahara.layouts.app')

@section('content')

    <!-- Date Filter -->
    <div class="flex justify-end mb-6">
        <button class="bg-[#133e87] hover:bg-[#0e2d63] text-white font-medium py-2 px-4 rounded-lg flex items-center shadow-md transition-colors duration-200 text-sm">
            Maret 01 - Maret 31
            <i class="bi bi-calendar3 ms-3"></i>
        </button>
    </div>

    <!-- 4 Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Saldo Kas -->
        <div class="bg-white rounded-xl p-3 flex flex-col items-start justify-center shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-16 h-16 bg-[#133e87]/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <h6 class="text-sm font-semibold text-gray-500 mb-1">Saldo Kas</h4>
            <p class="text-lg font-bold text-[#133e87]">Rp 85.000.000</p>
        </div>

        <!-- Total Pemasukan -->
        <div class="bg-white rounded-xl p-3 flex items-center shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="w-12 h-12 rounded-full bg-[#133e87]/10 flex items-center justify-center mr-4 flex-shrink-0 text-[#133e87] transition-transform group-hover:scale-110">
                <i class="bi bi-box-arrow-in-down text-2xl"></i>
            </div>
            <div>
                <h6 class="text-sm font-semibold text-gray-500 mb-1">Total Pemasukan</h6>
                <p class="text-lg font-bold text-gray-800">Rp 42.500.000</p>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white rounded-xl p-3 flex items-center shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4 flex-shrink-0 text-red-600 transition-transform group-hover:scale-110">
                <i class="bi bi-box-arrow-right text-2xl"></i>
            </div>
            <div>
                <h6 class="text-sm font-semibold text-gray-500 mb-1">Total Pengeluaran</h6>
                <p class="text-lg font-bold text-gray-800">Rp 12.300.000</p>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white rounded-xl p-3 flex flex-col items-start justify-center shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-16 h-16 bg-[#133e87]/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <h6 class="text-sm font-semibold text-gray-500 mb-1">Total Transaksi</h6>
            <p class="text-lg font-bold text-[#133e87]">210</p>
        </div>

    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Chart Section -->
        <div class="lg:col-span-7">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-800">Grafik Pemasukan & Pengeluaran</h3>
            </div>
            <div class="bg-white shadow-sm border border-gray-100 w-full h-[350px] flex items-center justify-center relative rounded-xl p-4">
                <!-- Navigation Arrows for Chart -->
                <button class="absolute left-4 bg-white border border-gray-200 rounded-full w-8 h-8 flex items-center justify-center shadow-sm z-10 font-bold text-[#133e87] hover:bg-gray-50 transition-colors" style="top: 50%; transform: translateY(-50%);">
                    <i class="bi bi-chevron-left text-sm"></i>
                </button>
                <button class="absolute right-4 bg-white border border-gray-200 rounded-full w-8 h-8 flex items-center justify-center shadow-sm z-10 font-bold text-[#133e87] hover:bg-gray-50 transition-colors" style="top: 50%; transform: translateY(-50%);">
                    <i class="bi bi-chevron-right text-sm"></i>
                </button>

                <!-- ApexCharts container -->
                <div id="finance-chart" class="w-full h-full"></div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="lg:col-span-5">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-bold text-lg text-gray-800">Daftar Aktivitas Transaksi</h3>
            </div>
            <div class="bg-white shadow-sm border border-gray-100 w-full overflow-hidden rounded-xl">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-[#133e87]/5 text-[#133e87] font-semibold border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-4 text-xs uppercase tracking-wider">Tanggal</th>
                            <th class="px-5 py-4 text-xs uppercase tracking-wider">Keterangan</th>
                            <th class="px-5 py-4 text-xs uppercase tracking-wider text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-5 py-4 whitespace-nowrap text-gray-500 text-xs">
                                <div class="font-medium text-gray-800">10-02-2026</div>
                                <div>14:30</div>
                            </td>
                            <td class="px-5 py-4 font-medium text-gray-800">Pembayaran SPP Kelas 7</td>
                            <td class="px-5 py-4 text-right font-bold text-green-600">+ Rp 2.500.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition duration-150 bg-red-50/30">
                            <td class="px-5 py-4 whitespace-nowrap text-gray-500 text-xs">
                                <div class="font-medium text-gray-800">11-02-2026</div>
                                <div>09:15</div>
                            </td>
                            <td class="px-5 py-4 font-medium text-gray-800">Pembelian ATK Kantor</td>
                            <td class="px-5 py-4 text-right font-bold text-red-500">- Rp 1.250.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition duration-150 bg-red-50/30">
                            <td class="px-5 py-4 whitespace-nowrap text-gray-500 text-xs">
                                <div class="font-medium text-gray-800">12-02-2026</div>
                                <div>10:00</div>
                            </td>
                            <td class="px-5 py-4 font-medium text-gray-800">Bayar Listrik & Air</td>
                            <td class="px-5 py-4 text-right font-bold text-red-500">- Rp 3.400.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-5 py-4 whitespace-nowrap text-gray-500 text-xs">
                                <div class="font-medium text-gray-800">13-02-2026</div>
                                <div>11:45</div>
                            </td>
                            <td class="px-5 py-4 font-medium text-gray-800">Sumbangan Alumni</td>
                            <td class="px-5 py-4 text-right font-bold text-green-600">+ Rp 10.000.000</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 text-center">
                    <a href="#" class="text-sm text-[#133e87] hover:underline font-medium">Lihat Semua Transaksi</a>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ApexCharts configuration for the bar chart
            const options = {
                series: [
                    {
                        name: 'Pemasukan',
                        data: [44, 55, 41, 67, 22, 43]
                    },
                    {
                        name: 'Pengeluaran',
                        data: [13, 23, 20, 8, 13, 27]
                    }
                ],
                chart: {
                    type: 'bar',
                    height: '100%',
                    toolbar: {
                        show: false
                    },
                    background: 'transparent',
                    fontFamily: 'Inter, sans-serif'
                },
                // Using Primary Color (#133e87) for Pemasukan and an Accent Color (#4cc9f0) for Pengeluaran
                colors: ['#133e87', '#4cc9f0'], 
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 4,
                        borderRadiusApplication: 'end'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 3,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontSize: '12px',
                            fontWeight: 500
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return val + " Jt";
                        },
                        style: {
                            colors: '#6b7280',
                            fontSize: '12px',
                            fontWeight: 500
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                grid: {
                    show: true,
                    borderColor: '#f3f4f6',
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    markers: {
                        radius: 12
                    },
                    fontWeight: 500,
                    labels: {
                        colors: '#374151'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "Rp " + val + ".000.000";
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#finance-chart"), options);
            chart.render();
        });
    </script>
    @endpush

@endsection
