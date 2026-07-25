@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div class="w-full mb-4 d-flex flex-wrap align-items-center justify-between">
        <div>
            <h2 class="fw-bold text-dark mb-0">Tahun Ajaran</h2>
            <p class="text-muted mb-0">Kelola tahun ajaran dan status aktif</p>
        </div>
        <a href="{{ route('bendahara.tahun_ajaran.create') }}" class="btn btn-custom-primary text-nowrap shadow-sm ms-2" style="padding: 0.5rem 1.25rem;">
            <i class="bi bi-plus-circle me-1"></i> Tambah
        </a>
    </div>
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="position-relative">
            <input type="text" class="form-control rounded-pill ps-3 pe-5 border-0 shadow-sm" placeholder="Cari Tahun Ajaran..." style="width:230px; border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px);">
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted">
                <i class="bi bi-search"></i>
            </span>
        </div>
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
                    <th class="border-0">Tahun Ajaran</th>
                    <th class="border-0">Semester</th>
                    <th class="border-0">Tanggal Mulai</th>
                    <th class="border-0">Tanggal Selesai</th>
                    <th class="border-0">Status</th>
                    <th class="border-0 rounded-end" width="220">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tahunAjarans as $index => $tahun)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-medium text-dark">{{ $tahun->nama }}</td>
                    <td>{{ $tahun->semester }}</td>
                    <td>{{ \Carbon\Carbon::parse($tahun->tanggal_mulai)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($tahun->tanggal_selesai)->format('d-m-Y') }}</td>
                    <td>
                        @if($tahun->is_aktif)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            @if(!$tahun->is_aktif)
                            <form action="{{ route('bendahara.tahun_ajaran.aktifkan', $tahun->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-success btn-action text-white" title="Aktifkan">
                                    <i class="bi bi-check2-circle"></i> Aktifkan
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('bendahara.tahun_ajaran.edit', $tahun->id) }}" class="btn btn-sm btn-warning text-white btn-action" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada data Tahun Ajaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection