@extends('layouts.print')

@section('title', 'Cetak Laporan Pendapatan')
@section('judul', 'LAPORAN PENDAPATAN')

@section('content')
<table class="tabel-data">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="18%">Tanggal</th>
            <th width="20%">Kategori</th>
            <th width="37%">Keterangan</th>
            <th width="20%">Nominal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}</td>
                <td>{{ $item['kategori'] ?? '-' }}</td>
                <td>{{ $item['keterangan'] }}</td>
                <td class="text-right">Rp {{ number_format($item['pemasukan'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data transaksi.</td>
            </tr>
        @endforelse
    </tbody>
    @if(count($laporan) > 0)
    <tfoot>
        <tr>
            <td colspan="4" class="text-right text-bold">TOTAL PENDAPATAN:</td>
            <td class="text-right text-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
    @endif
</table>
@endsection
