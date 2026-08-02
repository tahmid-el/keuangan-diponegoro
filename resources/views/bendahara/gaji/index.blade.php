@extends('layouts.app')

@section('title', 'Data Gaji Guru')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }
    .btn-custom-primary {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        color: white;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        padding: 0.5rem 1.25rem;
    }
    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        color: white;
    }
    .btn-action {
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
        transition: all 0.2s ease;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.05);
        transition: background-color 0.2s ease;
    }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div class="w-full mb-4 d-flex flex-wrap align-items-center justify-between">
        <div>
            <h2 class="fw-bold text-dark mb-0">Data Gaji Guru</h2>
            <p class="text-muted mb-0">Kelola data gaji guru dan karyawan</p>
        </div>

        <a href="{{ route('bendahara.gaji.create') }}" class="btn btn-custom-primary text-nowrap shadow-sm ms-2" style="padding: 0.5rem 1.25rem;">
            <i class="bi bi-plus-circle me-1"></i> Tambah
        </a>
    </div>
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <form action="{{ route('bendahara.gaji.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
            <div class="d-flex align-items-center gap-2 bg-white rounded-4 shadow-sm px-2 py-1" style="border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px);">
                <input type="text" name="search" class="form-control border-0 bg-transparent p-1" placeholder="Cari nama..." value="{{ request('search') }}" style="max-width: 200px;">
            </div>
            
            <button type="submit" class="btn btn-primary text-white fw-medium rounded-pill shadow-sm px-4 d-flex align-items-center gap-2" style="height: 40px; border: 1px solid rgba(255,255,255,0.4);">
                <i class="bi bi-search"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('bendahara.gaji.index') }}" class="btn btn-danger text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center transition" style="width:40px; height:40px; border: 1px solid rgba(255,255,255,0.4);" title="Reset Filter">
                    <i class="bi bi-x-lg" style="font-size: 14px; font-weight: bold;"></i>
                </a>
            @endif
        </form>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="border-0 rounded-start">Nama</th>
                    <th class="border-0 text-end">Jumlah Jam</th>
                    <th class="border-0 text-end">Bisyaroh</th>
                    <th class="border-0 text-end">Tunj. Kamad/WK</th>
                    <th class="border-0 text-end">Tunj. Piket</th>
                    <th class="border-0 text-end">Total</th>
                    <th class="border-0 rounded-end text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gajis as $gaji)
                <tr>
                    <td>
                        <span class="fw-medium text-dark">{{ $gaji->nama }}</span>
                    </td>
                    <td class="text-end">{{ $gaji->jumlah_jam }} jam</td>
                    <td class="text-end">Rp {{ number_format($gaji->bisyaroh, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($gaji->tunjangan_kamad_wk, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($gaji->tunjangan_piket, 0, ',', '.') }}</td>
                    <td class="text-end fw-bold text-success">Rp {{ number_format($gaji->jumlah, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('bendahara.gaji.edit', $gaji->id) }}" class="btn btn-sm btn-warning text-white btn-action" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('bendahara.gaji.destroy', $gaji->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada data gaji.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">
        {{ $gajis->links() }}
    </div>
</div>
@endsection
