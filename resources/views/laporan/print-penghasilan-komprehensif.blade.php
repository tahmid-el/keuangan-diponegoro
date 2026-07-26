@extends('layouts.print')

@section('title', 'Cetak Laporan Penghasilan Komprehensif')
@section('judul', 'LAPORAN PENGHASILAN KOMPREHENSIF')

@php
    $pendapatanTanpa = $laporan->filter(fn($i) => $i['tipe'] == 'Pemasukan' && ($i['status_pembatasan'] == 'Tanpa Pembatasan' || !$i['status_pembatasan']));
    $pendapatanDengan = $laporan->filter(fn($i) => $i['tipe'] == 'Pemasukan' && $i['status_pembatasan'] == 'Dengan Pembatasan');

    $bebanKelompok = $laporan->filter(fn($i) => $i['tipe'] == 'Pengeluaran')
        ->groupBy(fn($i) => $i['kelompok_isak35'] ?: 'Beban Lainnya')
        ->sortKeys();
@endphp

@section('content')
    {{-- PENDAPATAN --}}
    <div class="section-title">PENDAPATAN</div>

    <div class="sub-section">Tanpa Pembatasan</div>
    <table class="tabel-data" style="margin-bottom: 4px;">
        @forelse($pendapatanTanpa->groupBy('kategori') as $kategori => $items)
            @php $subtotal = $items->sum('pemasukan'); @endphp
            <tr>
                <td style="border: none; padding-left: 24px; width: 70%;">{{ $kategori }}</td>
                <td style="border: none; text-align: right; width: 30%;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td style="border: none; padding-left: 24px;" colspan="2">Tidak ada pendapatan tanpa pembatasan.</td>
            </tr>
        @endforelse
        <tr class="total-line">
            <td style="border: none; text-align: right; font-weight: bold;">Subtotal Tanpa Pembatasan</td>
            <td style="border: none; text-align: right; font-weight: bold;">Rp {{ number_format($pendapatanTanpa->sum('pemasukan'), 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="sub-section">Dengan Pembatasan</div>
    <table class="tabel-data" style="margin-bottom: 4px;">
        @forelse($pendapatanDengan->groupBy('kategori') as $kategori => $items)
            @php $subtotal = $items->sum('pemasukan'); @endphp
            <tr>
                <td style="border: none; padding-left: 24px; width: 70%;">{{ $kategori }}</td>
                <td style="border: none; text-align: right; width: 30%;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td style="border: none; padding-left: 24px;" colspan="2">Tidak ada pendapatan dengan pembatasan.</td>
            </tr>
        @endforelse
        <tr class="total-line">
            <td style="border: none; text-align: right; font-weight: bold;">Subtotal Dengan Pembatasan</td>
            <td style="border: none; text-align: right; font-weight: bold;">Rp {{ number_format($pendapatanDengan->sum('pemasukan'), 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="tabel-data" style="margin-bottom: 20px;">
        <tr class="total-line">
            <td style="border: none; text-align: right; width: 70%; font-weight: bold;">TOTAL PENDAPATAN</td>
            <td style="border: none; text-align: right; width: 30%; font-weight: bold;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- BEBAN --}}
    <div class="section-title">BEBAN</div>

    @forelse($bebanKelompok as $kelompok => $items)
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
            <tr><td style="border: none;">Tidak ada data beban.</td></tr>
        </table>
    @endforelse

    <table class="tabel-data" style="margin-top: 8px;">
        <tr class="total-line">
            <td style="border: none; text-align: right; width: 70%; font-weight: bold;">TOTAL BEBAN</td>
            <td style="border: none; text-align: right; width: 30%; font-weight: bold;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- KENAIKAN / PENURUNAN ASET NETO --}}
    <table class="tabel-data" style="margin-top: 16px;">
        <tr class="total-line" style="font-size: 12pt;">
            <td style="border: none; text-align: right; width: 70%; font-weight: bold;">KENAIKAN / (PENURUNAN) ASET NETO</td>
            <td style="border: none; text-align: right; width: 30%; font-weight: bold;">Rp {{ number_format(abs($saldoAkhir), 0, ',', '.') }}</td>
        </tr>
    </table>
@endsection
