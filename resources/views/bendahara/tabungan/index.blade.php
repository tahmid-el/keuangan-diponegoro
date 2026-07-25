@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div class="w-full mb-4 d-flex flex-wrap align-items-center justify-between">
        <div>
            <h2 class="fw-bold text-dark mb-0">Tabungan</h2>
            <p class="text-muted mb-0">Kelola data tabungan siswa</p>
        </div>
        <a href="{{ route('bendahara.tabungan.create') }}"
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
@if(session('error'))
<div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
    <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
</div>
@endif

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th class="border-0 rounded-start">No</th>
                    <th class="border-0">No. Induk</th>
                    <th class="border-0">Nama</th>
                    <th class="border-0">Tanggal</th>
                    <th class="border-0">Transaksi</th>
                    <th class="border-0 text-end">Saldo</th>
                    <th class="border-0 text-end">Total Saldo</th>
                    <th class="border-0 rounded-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tabungans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nis }}</td>
                    <td>{{ $item->nama_siswa }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        @if($item->jenis=='setor')
                            <span class="badge bg-success">Setor</span>
                        @else
                            <span class="badge bg-danger">Tarik</span>
                        @endif
                    </td>
                    <td class="text-end">Rp {{ number_format($item->nominal,0,',','.') }}</td>
                    <td class="text-end">Rp {{ number_format($item->saldo_akhir,0,',','.') }}</td>
                    <td>
                        <a href="{{ route('bendahara.tabungan.show',$item->tabungan_id) }}"
                           class="btn btn-sm btn-info text-white btn-action">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Belum ada data tabungan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex gap-3">
    <a href="{{ route('bendahara.tabungan.setor') }}" class="btn btn-custom-primary text-nowrap shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Saldo
    </a>
    <a href="{{ route('bendahara.tabungan.tarik') }}" class="btn btn-outline-primary text-nowrap shadow-sm"
       style="border-radius:12px; padding:0.5rem 1.25rem; font-weight:500;">
        <i class="bi bi-dash-circle me-1"></i> Tarik Saldo
    </a>
</div>

@endsection
