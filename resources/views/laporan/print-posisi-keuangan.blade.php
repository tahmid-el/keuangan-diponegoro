@extends('layouts.print')

@section('title', 'Cetak Laporan Posisi Keuangan')
@section('judul', 'LAPORAN POSISI KEUANGAN')

@section('content')
    {{-- ASET --}}
    <div class="section-title">ASET</div>

    <div class="sub-section">Aset Lancar</div>
    <table class="tabel-data" style="margin-bottom: 4px;">
        <tr>
            <td style="border: none; padding-left: 24px; width: 70%;">Kas</td>
            <td style="border: none; text-align: right; width: 30%;">Rp {{ number_format($kas, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-line">
            <td style="border: none; text-align: right; font-weight: bold;">TOTAL ASET</td>
            <td style="border: none; text-align: right; font-weight: bold;">Rp {{ number_format($totalAset, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- LIABILITAS --}}
    <div class="section-title">LIABILITAS</div>
    <table class="tabel-data" style="margin-bottom: 20px;">
        <tr>
            <td style="border: none; padding-left: 24px; width: 70%;">-</td>
            <td style="border: none; text-align: right; width: 30%;">Rp 0</td>
        </tr>
        <tr class="total-line">
            <td style="border: none; text-align: right; font-weight: bold;">TOTAL LIABILITAS</td>
            <td style="border: none; text-align: right; font-weight: bold;">Rp 0</td>
        </tr>
    </table>

    {{-- ASET NETO --}}
    <div class="section-title">ASET NETO</div>
    <table class="tabel-data" style="margin-bottom: 4px;">
        <tr>
            <td style="border: none; padding-left: 24px; width: 70%;">Tanpa Pembatasan</td>
            <td style="border: none; text-align: right; width: 30%;">Rp {{ number_format($asetNetoTanpa, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="border: none; padding-left: 24px;">Dengan Pembatasan</td>
            <td style="border: none; text-align: right;">Rp {{ number_format($asetNetoDengan, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-line">
            <td style="border: none; text-align: right; font-weight: bold;">TOTAL ASET NETO</td>
            <td style="border: none; text-align: right; font-weight: bold;">Rp {{ number_format($totalAsetNeto, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="tabel-data" style="margin-top: 16px;">
        <tr class="total-line" style="font-size: 12pt;">
            <td style="border: none; text-align: right; width: 70%; font-weight: bold;">TOTAL LIABILITAS DAN ASET NETO</td>
            <td style="border: none; text-align: right; width: 30%; font-weight: bold;">Rp {{ number_format($totalLiabilitasDanAsetNeto, 0, ',', '.') }}</td>
        </tr>
    </table>
@endsection
