@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div class="w-full mb-4 d-flex flex-wrap align-items-center justify-between">
        <div>
            <h2 class="fw-bold text-dark mb-0">Pembayaran</h2>
            <p class="text-muted mb-0">Kelola data pembayaran siswa</p>
        </div>
        <a href="{{ route('bendahara.pembayaran.tambah') }}"
            class="btn btn-custom-primary text-nowrap shadow-sm ms-2"
            style="padding: 0.5rem 1.25rem;">
            <i class="bi bi-plus-circle me-1"></i> Tambah
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th class="border-0 rounded-start">No.</th>
                    <th class="border-0">No Induk</th>
                    <th class="border-0">Nama Siswa</th>
                    <th class="border-0">No Kwitansi</th>
                    <th class="border-0 text-end">Total Pembayaran</th>
                    <th class="border-0">Status</th>
                    <th class="border-0 rounded-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($pembayarans->count())
                @foreach($pembayarans as $index => $pembayaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pembayaran->nis }}</td>
                    <td>{{ $pembayaran->nama_siswa }}</td>
                    <td>{{ $pembayaran->no_kwitansi }}</td>
                    <td class="text-end">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                    <td>{{ $pembayaran->nama_pembayaran }}</td>
                    <td>
                        <a href="{{ route('bendahara.pembayaran.edit', $pembayaran->id) }}"
                            class="btn btn-sm btn-warning text-white btn-action">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Data pembayaran belum tersedia.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
