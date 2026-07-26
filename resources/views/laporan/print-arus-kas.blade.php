@extends('layouts.print')

@section('title', 'Cetak Laporan Arus Kas')
@section('judul', 'LAPORAN ARUS KAS')

@php
    $kasMasuk = $laporan->filter(fn($i) => $i['tipe'] == 'Pemasukan');
    $kasKeluar = $laporan->filter(fn($i) => $i['tipe'] == 'Pengeluaran');

    $kasMasukKelompok = $kasMasuk->groupBy('kategori')->sortKeys();
    $kasKeluarKelompok = $kasKeluar->groupBy(fn($i) => $i['kelompok_isak35'] ?: 'Beban Lainnya')->sortKeys();
@endphp

@section('content')
    {{-- ARUS KAS MASUK --}}
    <div class="section-title">ARUS KAS MASUK</div>

    @forelse($kasMasukKelompok as $kategori => $items)
        @php $subtotal = $items->sum('pemasukan'); @endphp
        <div class="sub-section">{{ $kategori }}</div>
        <table class="tabel-data" style="margin-bottom: 4px;">
            @foreach($items as $item)
                <tr>
                    <td style="border: none; padding-left: 24px; width: 10%;">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d/m') }}</td>
                    <td style="border: none; width: 60%;">{{ $item['keterangan'] }}</td>
                    <td style="border: none; text-align: right; width: 30%;">Rp {{ number_format($item['pemasukan'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-line">
                <td colspan="2" style="border: none; text-align: right; font-weight: bold;">Total {{ $kategori }}</td>
                <td style="border: none; text-align: right; font-weight: bold;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        </table>
    @empty
        <table class="tabel-data">
            <tr><td style="border: none;">Tidak ada arus kas masuk.</td></tr>
        </table>
    @endforelse

    <table class="tabel-data" style="margin-bottom: 20px;">
        <tr>
            <td style="border: none; text-align: right; width: 70%;">Jumlah Arus Kas Masuk</td>
            <td style="border: none; text-align: right; width: 30%; font-weight: bold;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- ARUS KAS KELUAR --}}
    <div class="section-title">ARUS KAS KELUAR</div>

    @forelse($kasKeluarKelompok as $kelompok => $items)
        @php $totalKelompok = $items->sum('pengeluaran'); @endphp
        <div class="sub-section">{{ $kelompok }}</div>
        <table class="tabel-data" style="margin-bottom: 4px;">
            @foreach($items->groupBy('kategori') as $kategori => $detail)
                @php $subtotalKat = $detail->sum('pengeluaran'); @endphp
                <tr>
                    <td style="border: none; padding-left: 24px; width: 70%;">{{ $kategori }}</td>
                    <td style="border: none; text-align: right; width: 30%;">Rp {{ number_format($subtotalKat, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-line">
                <td style="border: none; text-align: right; font-weight: bold;">Total {{ $kelompok }}</td>
                <td style="border: none; text-align: right; font-weight: bold;">Rp {{ number_format($totalKelompok, 0, ',', '.') }}</td>
            </tr>
        </table>
    @empty
        <table class="tabel-data">
            <tr><td style="border: none;">Tidak ada arus kas keluar.</td></tr>
        </table>
    @endforelse

    <table class="tabel-data" style="margin-bottom: 4px;">
        <tr>
            <td style="border: none; text-align: right; width: 70%;">Jumlah Arus Kas Keluar</td>
            <td style="border: none; text-align: right; width: 30%; font-weight: bold;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="tabel-data" style="margin-top: 16px;">
        <tr>
            <td style="border: none; text-align: right; width: 70%; font-size: 11pt;">Kas Masuk</td>
            <td style="border: none; text-align: right; width: 30%; font-size: 11pt;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="border: none; text-align: right; font-size: 11pt;">dikurangi</td>
            <td style="border: none;"></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right; font-size: 11pt;">Kas Keluar</td>
            <td style="border: none; text-align: right; font-size: 11pt;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-line">
            <td style="border: none; text-align: right; font-weight: bold; font-size: 12pt;">Kenaikan / Penurunan Kas</td>
            <td style="border: none; text-align: right; font-weight: bold; font-size: 12pt;">Rp {{ number_format(abs($saldoAkhir), 0, ',', '.') }}</td>
        </tr>
    </table>
@endsection
