<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan</title>
    <style>
        /* Reset margin and padding for print */
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
            /* Disable any shadows, blur, or transparency */
            box-shadow: none !important;
            backdrop-filter: none !important;
        }
        
        /* Kop Surat */
        .kop-surat {
            width: 100%;
            border-bottom: 3px solid #000;
            margin-bottom: 2px;
            border-collapse: collapse;
        }
        .kop-surat td {
            vertical-align: middle;
            padding-bottom: 10px;
        }
        .kop-logo {
            width: 15%;
            text-align: center;
        }
        .kop-text {
            width: 70%;
            text-align: center;
            line-height: 1.3;
        }
        .kop-surat img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        .garis-bawah {
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
        }
        
        /* Judul Laporan */
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
        }
        .judul-laporan p {
            margin: 5px 0 0 0;
            font-size: 11pt;
        }
        
        /* Tabel Data */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .tabel-data th, .tabel-data td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 11pt;
        }
        .tabel-data th {
            background-color: #f3f4f6; /* Abu-abu muda */
            font-weight: bold;
            text-align: center;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-bold { font-weight: bold; }
        
        /* Tanda Tangan */
        .tanda-tangan {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .tanda-tangan td {
            width: 33%;
            text-align: center;
            vertical-align: top;
        }
        .ttd-space {
            height: 80px;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <table class="kop-surat">
        <tr>
            <td class="kop-logo">
                <img src="{{ asset('images/dipo.png') }}" alt="Logo Sekolah" onerror="this.src='https://ui-avatars.com/api/?name=MTs+D&background=133e87&color=fff&size=128'">
            </td>
            <td class="kop-text">
                <div style="font-size: 12pt; font-weight: bold;">YAYASAN PENDIDIKAN DAN SOSIAL ISLAM DIPONEGORO</div>
                <div style="font-size: 14pt; font-weight: bold;">MADRASAH TSANAWIYAH (MTsS) DIPONEGORO</div>
                <div style="font-size: 10pt;">NPSN : 20581699 | NSM : 121235100014</div>
                <div style="font-size: 10pt;">Jl. Diponegoro No. 01, Tegalsari, Banyuwangi 68491</div>
            </td>
            <!-- <td class="kop-logo">
                Ruang opsional untuk logo kanan
            </td> -->
        </tr>
    </table>
    <div class="garis-bawah"></div>

    @php
        $monthsName = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
    @endphp

    <!-- Judul Laporan -->
    <div class="judul-laporan">
        <h3>LAPORAN KEUANGAN</h3>
        <p>Periode: {{ $monthsName[$bulan] ?? $bulan }} {{ $tahun }}</p>
    </div>

    <!-- Tabel Data -->
    <table class="tabel-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Tipe</th>
                <th width="20%">Kategori</th>
                <th width="25%">Keterangan</th>
                <th width="10%">Masuk</th>
                <th width="10%">Keluar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}</td>
                    <td class="text-center">{{ $item['tipe'] }}</td>
                    <td>{{ $item['kategori'] ?? '-' }}</td>
                    <td>{{ $item['keterangan'] }}</td>
                    <td class="text-right">{{ $item['pemasukan'] > 0 ? number_format($item['pemasukan'], 0, ',', '.') : '-' }}</td>
                    <td class="text-right">{{ $item['pengeluaran'] > 0 ? number_format($item['pengeluaran'], 0, ',', '.') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($laporan) > 0)
        <tfoot>
            <tr>
                <td colspan="5" class="text-right text-bold">TOTAL:</td>
                <td class="text-right text-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td class="text-right text-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Tanda Tangan -->
    <table class="tanda-tangan">
        <tr>
            <td>
                Mengetahui,<br>
                Kepala Madrasah
                <div class="ttd-space"></div>
                <span style="font-weight: bold; text-decoration: underline;">...................................</span>
            </td>
            <td></td>
            <td>
                Banyuwangi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                Bendahara
                <div class="ttd-space"></div>
                <span style="font-weight: bold; text-decoration: underline;">{{ Auth::user()->name }}</span>
            </td>
        </tr>
    </table>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
