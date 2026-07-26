<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cetak Laporan')</title>
    <style>
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
        }
        .kop-surat {
            width: 100%;
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
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-bold { font-weight: bold; }
        .section-title {
            font-size: 13pt;
            font-weight: bold;
            margin-top: 24px;
            margin-bottom: 8px;
        }
        .sub-section {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 16px;
            margin-bottom: 4px;
        }
        .line-item {
            font-size: 11pt;
            padding: 2px 0;
        }
        .line-item td:first-child {
            padding-left: 24px;
        }
        .total-line {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 4px;
            margin-top: 4px;
        }
        .page-break {
            page-break-before: always;
        }
        .ttd-table {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            width: 33%;
            text-align: center;
            vertical-align: top;
        }
        .ttd-space {
            height: 80px;
        }
    </style>
    @stack('styles')
</head>
<body>

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
        </tr>
    </table>

    <br>

    @php
        $monthsName = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $periodeLabel = $bulan
            ? ($monthsName[$bulan] ?? $bulan) . ' ' . $tahun
            : 'Tahun ' . $tahun;
    @endphp

    <div class="judul-laporan">
        <h3>@yield('judul', 'LAPORAN')</h3>
        <p>Periode: {{ $periodeLabel }}</p>
    </div>

    @yield('content')

    <!-- <table class="ttd-table">
        <tr>
            <td></td>
            <td></td>
            <td>
                Banyuwangi, {{ $periodeLabel }}<br>
                Kepala Madrasah,<br><br><br><br>
                <u style="font-weight: bold;">_____________________</u><br>
                NIP. _____________________
            </td>
        </tr>
    </table> -->

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
