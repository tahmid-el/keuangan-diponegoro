@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div class="w-full mb-4 d-flex flex-wrap align-items-center justify-between">
        <div>
            <h2 class="fw-bold text-dark mb-0">Data Tagihan</h2>
            <p class="text-muted mb-0">Kelola semua daftar tagihan yang ada</p>
        </div>
        <a href="{{ route('bendahara.tagihan.create') }}" class="btn btn-custom-primary text-nowrap shadow-sm ms-2" style="padding: 0.5rem 1.25rem;">
            <i class="bi bi-plus-circle me-1"></i> Tambah Tagihan
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
                    <th class="border-0 rounded-start" width="50">No</th>
                    <th class="border-0">Kelas</th>
                    <th class="border-0">Jenis Pembayaran</th>
                    <th class="border-0">Jenis Tagihan</th>
                    <th class="border-0">Tahun Ajaran</th>
                    <th class="border-0">Semester</th>
                    <th class="border-0 text-end">Nominal</th>
                    <th class="border-0 rounded-end" width="130">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihan as $index => $item)
                <tr>
                    <td>{{ $tagihan->firstItem() + $index }}</td>
                    <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->jenisPembayaran->nama ?? '-' }}</td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ ucfirst($item->jenisTagihan->nama_tagihan ?? '-') }}</span></td>
                    <td>{{ $item->tahunAjaran->nama ?? '-' }}</td>
                    <td>{{ ucfirst($item->tahunAjaran->semester ?? '-') }}</td>
                    <td class="text-end fw-bold text-success">Rp {{ number_format($item->nominal,0,',','.') }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('bendahara.tagihan.edit',$item->id) }}" class="btn btn-sm btn-warning text-white btn-action" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('bendahara.tagihan.arsip',$item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button onclick="return confirm('Arsipkan tagihan ini?')" class="btn btn-sm btn-secondary btn-action" title="Arsipkan">
                                    <i class="bi bi-archive"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Belum ada data tagihan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tagihan->hasPages())
    <div class="d-flex justify-content-end mt-3">
        {{ $tagihan->links() }}
    </div>
    @endif
</div>
@endsection