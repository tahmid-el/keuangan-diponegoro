@extends('layouts.app')

@section('content')
<style>
    /* Styling similar to Histori / Pemasukan */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    .table-custom th {
        background: rgba(19, 62, 135, 0.05);
        color: #fff !important;
        font-weight: 600;
        border-bottom: 2px solid rgba(19, 62, 135, 0.1);
        padding: 1rem;
    }
    .table-custom td {
        vertical-align: middle;
        padding: 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.03);
    }
    .text-success-custom { color: #10b981; }
    .text-danger-custom { color: #ef4444; }
    
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { 
            visibility: visible; 
            color: #000 !important; 
        }
        .print-area { 
            position: absolute; left: 0; top: 0; width: 100%; 
        }
        .no-print { display: none !important; }
        
        /* Hilangkan styling modern untuk cetak */
        .glass-card { background: transparent !important; border: none !important; box-shadow: none !important; }
        .summary-cards { display: none !important; } /* Sembunyikan kartu di PDF, cukup tampilkan tabel */
        
        /* Header Form Profesional Hitam Putih */
        .print-header-boxes { display: flex !important; margin-bottom: 20px; gap: 15px; }
        .print-box { background-color: transparent !important; padding: 12px; flex: 1; border: 1px solid #000; }
        .print-box-title { font-size: 9pt; color: #000 !important; text-transform: uppercase; margin-bottom: 4px; font-weight: bold; }
        .print-box-value { font-size: 11pt; font-weight: bold; color: #000 !important; }

        /* Styling tabel profesional hitam-putih */
        .table-custom { border-collapse: collapse !important; width: 100% !important; margin-top: 10px; }
        .table-custom th, .table-custom td { 
            border: 1px solid #000 !important; 
            padding: 10px !important; 
            font-size: 10pt !important;
        }
        /* Header Hitam Putih */
        .table-custom thead th { 
            background-color: transparent !important; 
            color: #000 !important; 
            font-weight: bold !important; 
            text-align: center !important; 
            text-transform: uppercase;
            font-size: 9pt !important;
        }
        /* Hapus Selang-seling baris */
        .table-custom tbody tr:nth-child(even) { background-color: transparent !important; }
        
        /* Baris Total Hitam Putih */
        .table-custom tfoot td { 
            background-color: transparent !important; 
            color: #000 !important; 
            font-weight: bold !important; 
            font-size: 11pt !important;
        }
        
        /* Netralkan badge dan warna teks */
        .badge { font-weight: normal !important; padding: 0 !important; border: none !important; font-size: 10pt !important; background: transparent !important; color: inherit !important; }
    }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 no-print">
    <div>
        @php
            $months = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            ];
            $judulLaporan = match($jenisLaporan) {
                'pendapatan' => 'Laporan Pendapatan',
                'beban' => 'Laporan Beban',
                'penghasilan_komprehensif' => 'Laporan Penghasilan Komprehensif (ISAK 35)',
                'posisi_keuangan' => 'Laporan Posisi Keuangan (ISAK 35)',
                'arus_kas' => 'Laporan Arus Kas',
                default => 'Laporan'
            };
        @endphp
        <h2 class="fw-bold text-dark mb-0">{{ $judulLaporan }}</h2>
        <p class="text-muted mb-0">
            @if($bulan)
                Periode {{ $months[$bulan] ?? '' }} {{ $tahun }}
            @else
                Tahun {{ $tahun }}
            @endif
        </p>
    </div>
    
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <form action="{{ url()->current() }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
            <!-- Filter Bulan & Tahun -->
            <div class="d-flex align-items-center gap-2 bg-white rounded-4 shadow-sm px-3 py-1" style="border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px);">
                <i class="bi bi-calendar-month text-muted me-1"></i>
                <select name="bulan" class="form-select border-0 bg-transparent py-1 pe-4" style="min-width: 130px; cursor: pointer;">
                    <option value="" {{ $bulan == '' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                <div class="vr mx-1"></div>
                <select name="tahun" class="form-select border-0 bg-transparent py-1 pe-4" style="min-width: 100px; cursor: pointer;">
                    @php
                        $currentYear = date('Y');
                        $years = range($currentYear - 3, $currentYear + 2);
                    @endphp
                    @foreach($years as $yr)
                        <option value="{{ $yr }}" {{ $tahun == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Jenis Laporan -->
            <div class="d-flex align-items-center gap-2 bg-white rounded-4 shadow-sm px-2 py-1" style="border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px);">
                <select name="jenis_laporan" class="form-select border-0 bg-transparent py-1 ps-2 pe-4" style="min-width: 140px;">
                    <option value="pendapatan" {{ $jenisLaporan == 'pendapatan' ? 'selected' : '' }}>Laporan Pendapatan (Pemasukan)</option>
                    <option value="beban" {{ $jenisLaporan == 'beban' ? 'selected' : '' }}>Laporan Beban (Pengeluaran)</option>
                    <option value="penghasilan_komprehensif" {{ $jenisLaporan == 'penghasilan_komprehensif' ? 'selected' : '' }}>Laporan Penghasilan Komprehensif (ISAK 35)</option>
                    <option value="posisi_keuangan" {{ $jenisLaporan == 'posisi_keuangan' ? 'selected' : '' }}>Laporan Posisi Keuangan (ISAK 35)</option>
                    <option value="arus_kas" {{ $jenisLaporan == 'arus_kas' ? 'selected' : '' }}>Laporan Arus Kas</option>
                </select>
                <div class="vr mx-1"></div>
                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 fw-medium" style="background-color: var(--sidebar-bg); border: none;">Terapkan</button>
            </div>
        </form>
        
        <div>
            <button onclick="exportToExcel()" class="btn text-white text-nowrap shadow-sm ms-2" style="padding: 0.5rem 1.25rem; background-color: #10b981; border-color: #10b981; border-radius: 8px;">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </button>
            <a href="{{ url()->current() . '/print?' . http_build_query(request()->query()) }}" target="_blank" class="btn text-white text-nowrap shadow-sm ms-2" style="padding: 0.5rem 1.25rem; background-color: #3b82f6; border-color: #3b82f6; border-radius: 8px; text-decoration: none;">
                <i class="bi bi-printer me-1"></i> Cetak Laporan
            </a>
        </div>
    </div>
</div>

<div class="print-area" style="background: none !important;">
    <!-- Header Print (Kop Surat) -->
    <div class="d-none d-print-block mb-4">
        <table style="width: 100%; border-bottom: 3px solid #000; margin-bottom: 2px;">
            <tr>
                <td style="width: 15%; text-align: center; padding-bottom: 10px;">
                    <div style="width: 80px; height: 80px; border: 1px dashed #ccc; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; color: #999; margin: auto;">
                        <img src="{{ asset('images/dipo.png') }}" alt="Logo Sekolah" onerror="this.src='https://ui-avatars.com/api/?name=MTs+D&background=133e87&color=fff&size=128'">
                    </div>
                </td>
                <td style="width: 70%; text-align: center; padding-bottom: 10px; line-height: 1.3;">
                    <div style="font-size: 14pt; font-weight: bold;">YAYASAN PENDIDIKAN DAN SOSIAL ISLAM DIPONEGORO</div>
                    <div style="font-size: 16pt; font-weight: bold;">MADRASAH TSANAWIYAH (MTsS) DIPONEGORO</div>
                    <div style="font-size: 10pt;">NPSN : 20581699 | NSM : 121235100014</div>
                    <div style="font-size: 10pt;">Jl. Diponegoro No. 01, Tegalsari, Banyuwangi 68491</div>
                </td>
                <td style="width: 15%; text-align: center; padding-bottom: 10px;">
                </td>
            </tr>
        </table>
        <div style="border-bottom: 1px solid #000; margin-bottom: 20px;"></div>
        
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 14pt; font-weight: bold;">{{ $judulLaporan }}</div>
            <div style="font-size: 11pt;">Periode: @if($bulan) {{ $months[$bulan] }} {{ $tahun }} @else Tahun {{ $tahun }} @endif</div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4 summary-cards">
        <div class="col-md-6">
            <div class="glass-card p-3">
                <div class="text-muted small fw-medium mb-1">Total Pemasukan</div>
                <h4 class="text-success-custom fw-bold mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="glass-card p-3">
                <div class="text-muted small fw-medium mb-1">Total Pengeluaran</div>
                <h4 class="text-danger-custom fw-bold mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
            </div>
        </div>
        @if($jenisLaporan == 'penghasilan_komprehensif' || $jenisLaporan == 'posisi_keuangan' || $jenisLaporan == 'arus_kas')
        <div class="col-md-6">
            <div class="glass-card p-3">
                <div class="text-muted small fw-medium mb-1">Surplus / Defisit</div>
                <h4 class="fw-bold mb-0 {{ $saldoAkhir >= 0 ? 'text-success-custom' : 'text-danger-custom' }}">Rp {{ number_format(abs($saldoAkhir), 0, ',', '.') }}</h4>
            </div>
        </div>
        @endif
    </div>

    <!-- Table -->
    <div class="overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="15%">Tipe</th>
                        <th width="20%">Kategori</th>
                        <th width="25%">Keterangan</th>
                        <th width="10%" class="text-end">Masuk</th>
                        <th width="10%" class="text-end">Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @php $saldoBerjalan = 0; @endphp
                    @forelse($laporan as $index => $item)
                        @php $saldoBerjalan += $item['pemasukan'] - $item['pengeluaran']; @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $item['tipe'] == 'Pemasukan' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $item['tipe'] == 'Pemasukan' ? 'text-success' : 'text-danger' }}" style="font-size: 0.75rem;">
                                    {{ $item['tipe'] }}
                                </span>
                            </td>
                            <td>{{ $item['kategori'] ?? '-' }}</td>
                            <td>{{ $item['keterangan'] }}</td>
                            <td class="text-end {{ $item['pemasukan'] > 0 ? 'text-success-custom fw-medium' : 'text-muted' }}">
                                {{ $item['pemasukan'] > 0 ? number_format($item['pemasukan'], 0, ',', '.') : '-' }}
                            </td>
                            <td class="text-end {{ $item['pengeluaran'] > 0 ? 'text-danger-custom fw-medium' : 'text-muted' }}">
                                {{ $item['pengeluaran'] > 0 ? number_format($item['pengeluaran'], 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 mb-3 d-block text-black-50"></i>
                                Tidak ada data transaksi untuk rentang tanggal / filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($laporan) > 0)
                <tfoot style="background-color: rgba(19, 62, 135, 0.05); font-weight: 700;">
                    <tr>
                        <td colspan="5" class="text-end text-dark">TOTAL:</td>
                        <td class="text-end text-success-custom">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                        <td class="text-end text-danger-custom">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<!-- Script Export ke Excel Asli menggunakan ExcelJS (Mendukung Styling Penuh) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script>
async function exportToExcel() {
    var rawData = {!! json_encode($laporan) !!};
    
    var monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    var monthName = '{{ $bulan }}' ? monthNames[parseInt('{{ $bulan }}') - 1] : '';
    var period = monthName ? monthName + ' {{ $tahun }}' : 'Tahun {{ $tahun }}';
    
    var workbook = new ExcelJS.Workbook();
    var worksheet = workbook.addWorksheet('Laporan Keuangan');
    
    // 1. Kop Surat
    worksheet.mergeCells('A1:G1');
    worksheet.getCell('A1').value = 'YAYASAN PENDIDIKAN DAN SOSIAL ISLAM DIPONEGORO';
    worksheet.getCell('A1').font = { name: 'Arial', size: 12, bold: true };
    worksheet.getCell('A1').alignment = { horizontal: 'center' };

    worksheet.mergeCells('A2:G2');
    worksheet.getCell('A2').value = 'MADRASAH TSANAWIYAH (MTsS) DIPONEGORO';
    worksheet.getCell('A2').font = { name: 'Arial', size: 14, bold: true };
    worksheet.getCell('A2').alignment = { horizontal: 'center' };

    worksheet.mergeCells('A3:G3');
    worksheet.getCell('A3').value = 'TERAKREDITASI "A"';
    worksheet.getCell('A3').font = { name: 'Arial', size: 11, bold: true };
    worksheet.getCell('A3').alignment = { horizontal: 'center' };

    worksheet.mergeCells('A4:G4');
    worksheet.getCell('A4').value = 'NPSN : 20581699 | NSM : 121235100014';
    worksheet.getCell('A4').font = { name: 'Arial', size: 10 };
    worksheet.getCell('A4').alignment = { horizontal: 'center' };

    worksheet.mergeCells('A5:G5');
    worksheet.getCell('A5').value = 'Jl. Diponegoro No. 01, Tegalsari, Banyuwangi 68491';
    worksheet.getCell('A5').font = { name: 'Arial', size: 10 };
    worksheet.getCell('A5').alignment = { horizontal: 'center' };

    worksheet.mergeCells('A6:G6');
    worksheet.getCell('A6').value = 'Telp. : .......................... | Email : ........................................';
    worksheet.getCell('A6').font = { name: 'Arial', size: 10 };
    worksheet.getCell('A6').alignment = { horizontal: 'center' };

    // Garis Bawah Kop Surat (Border)
    worksheet.mergeCells('A7:G7');
    worksheet.getCell('A7').border = { bottom: { style: 'double' } };

    // 2. Judul Laporan
    worksheet.mergeCells('A9:G9');
    var titleCell = worksheet.getCell('A9');
    titleCell.value = 'LAPORAN';
    titleCell.font = { name: 'Arial', size: 14, bold: true };
    titleCell.alignment = { horizontal: 'center' };
    
    worksheet.mergeCells('A10:G10');
    var periodCell = worksheet.getCell('A10');
    periodCell.value = 'Periode: ' + period;
    periodCell.font = { name: 'Arial', size: 11 };
    periodCell.alignment = { horizontal: 'center' };
    
    worksheet.getRow(11).values = []; // Empty row as spacing
    
    // 3. Header Tabel (Gaya Navy Blue)
    var headerRow = worksheet.addRow([
        "NO", "TANGGAL", "TIPE TRANSAKSI", "KATEGORI", "KETERANGAN", "PEMASUKAN (Rp)", "PENGELUARAN (Rp)"
    ]);
    headerRow.font = { name: 'Arial', size: 11, bold: true, color: { argb: 'FFFFFFFF' } }; // Putih
    headerRow.eachCell(function(cell) {
        cell.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FF1E3A8A' } // Navy Blue
        };
        cell.alignment = { vertical: 'middle', horizontal: 'center' };
        cell.border = {
            top: {style:'thin', color: {argb:'FFCBD5E1'}}, 
            left: {style:'thin', color: {argb:'FFCBD5E1'}}, 
            bottom: {style:'thin', color: {argb:'FFCBD5E1'}}, 
            right: {style:'thin', color: {argb:'FFCBD5E1'}}
        };
    });
    
    var totalPemasukan = 0;
    var totalPengeluaran = 0;
    var saldo = 0;
    
    // 4. Baris Data (Warna Selang-Seling)
    rawData.forEach(function(item, index) {
        var masuk = parseFloat(item.pemasukan);
        var keluar = parseFloat(item.pengeluaran);
        
        totalPemasukan += masuk;
        totalPengeluaran += keluar;
        saldo += (masuk - keluar);
        
        var row = worksheet.addRow([
            index + 1,
            item.tanggal,
            item.tipe,
            item.kategori || '-',
            item.keterangan,
            masuk,
            keluar
        ]);
        
        // Pemformatan nominal uang (#,##0)
        row.getCell(6).numFmt = '#,##0';
        row.getCell(7).numFmt = '#,##0';
        
        // Warna baris genap: abu-abu muda, ganjil: putih
        var bgColor = (index % 2 === 1) ? 'FFF8FAFC' : 'FFFFFFFF'; 
        
        row.eachCell(function(cell) {
            cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: bgColor } };
            cell.border = {
                top: {style:'thin', color: {argb:'FFCBD5E1'}}, 
                left: {style:'thin', color: {argb:'FFCBD5E1'}}, 
                bottom: {style:'thin', color: {argb:'FFCBD5E1'}}, 
                right: {style:'thin', color: {argb:'FFCBD5E1'}}
            };
            if(cell.col <= 3) cell.alignment = { horizontal: 'center' };
        });
    });
    
    // 5. Baris Total (Gaya Slate Gelap)
    var totalRow = worksheet.addRow([
        "", "", "", "", "TOTAL:", 
        totalPemasukan, 
        totalPengeluaran
    ]);
    
    totalRow.font = { bold: true, color: { argb: 'FFFFFFFF' } }; // Putih
    totalRow.eachCell(function(cell, colNumber) {
        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF1E293B' } }; // Slate/Hitam
        cell.border = {
            top: {style:'thin', color: {argb:'FFCBD5E1'}}, 
            left: {style:'thin', color: {argb:'FFCBD5E1'}}, 
            bottom: {style:'thin', color: {argb:'FFCBD5E1'}}, 
            right: {style:'thin', color: {argb:'FFCBD5E1'}}
        };
        if(colNumber >= 6) cell.numFmt = '#,##0';
        if(colNumber === 5) cell.alignment = { horizontal: 'right' };
    });
    
    // 6. Atur Lebar Kolom secara Profesional
    worksheet.columns = [
        { width: 6 },   // No
        { width: 15 },  // Tanggal
        { width: 18 },  // Tipe
        { width: 25 },  // Kategori
        { width: 45 },  // Keterangan
        { width: 20 },  // Pemasukan
        { width: 20 }   // Pengeluaran
    ];
    
    // 7. Simpan File sebagai unduhan binary .xlsx yang sesungguhnya (Beri nama Baru agar Cache Browser hilang)
    var fileName = 'Laporan_Keuangan_Terbaru_' + monthName + '_{{ $tahun }}.xlsx';
    
    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = fileName;
    link.click();
}
</script>
@endsection