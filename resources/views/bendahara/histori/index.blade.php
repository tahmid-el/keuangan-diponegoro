@extends('layouts.app')

@section('title', 'History Log Aktivitas')

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
    .table-hover tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.05);
        transition: background-color 0.2s ease;
    }
    .badge-create { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
    .badge-update { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .badge-delete { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold text-dark mb-0">History Log Aktivitas</h2>
        <p class="text-muted mb-0">Pantau seluruh jejak aktivitas pengguna di sistem</p>
    </div>
    
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <form action="{{ request()->url() }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
            <!-- Filter Tanggal -->
            <div class="d-flex align-items-center gap-2 bg-white rounded-4 shadow-sm px-3 py-1" style="border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px);">
                <span class="text-muted fw-medium" style="font-size: 14px;">Dari</span>
                <input type="date" name="startdate" class="form-control border-0 bg-transparent p-1" value="{{ request('startdate') }}" style="max-width: 130px; cursor: pointer;" title="Dari Tanggal">
                <div class="vr mx-1"></div>
                <span class="text-muted fw-medium" style="font-size: 14px;">Sampai</span>
                <input type="date" name="enddate" class="form-control border-0 bg-transparent p-1" value="{{ request('enddate') }}" style="max-width: 130px; cursor: pointer;" title="Sampai Tanggal">
            </div>
            
            <!-- Filter Tipe Aktivitas & Pencarian -->
            <div class="d-flex align-items-center gap-2 bg-white rounded-4 shadow-sm px-2 py-1" style="border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px);">
                <select name="aktivitas" class="form-select border-0 bg-transparent py-1 ps-2 pe-4">
                    <option value="">Semua Aktivitas</option>
                    <option value="CREATE" {{ request('aktivitas') == 'CREATE' ? 'selected' : '' }}>CREATE</option>
                    <option value="UPDATE" {{ request('aktivitas') == 'UPDATE' ? 'selected' : '' }}>UPDATE</option>
                    <option value="DELETE" {{ request('aktivitas') == 'DELETE' ? 'selected' : '' }}>DELETE</option>
                </select>
                
                <div class="vr mx-1"></div>
                
                <select name="transaksi" class="form-select border-0 bg-transparent py-1 ps-2 pe-4">
                    <option value="">Semua Transaksi</option>
                    <option value="Pemasukan" {{ request('transaksi') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="Pengeluaran" {{ request('transaksi') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>

                <div class="vr mx-1"></div>

                <input type="text" name="search" class="form-control border-0 bg-transparent p-1" placeholder="Cari keterangan..." value="{{ request('search') }}" style="max-width: 150px;">
            </div>
            
            <button type="submit" class="btn btn-primary text-white fw-medium rounded-pill shadow-sm px-4 d-flex align-items-center gap-2" style="height: 40px; border: 1px solid rgba(255,255,255,0.4);">
                <i class="bi bi-funnel"></i> Filter
            </button>
            @if(request('startdate') || request('enddate') || request('aktivitas') || request('transaksi') || request('search'))
                <a href="{{ request()->url() }}" class="btn btn-danger text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center transition" style="width:40px; height:40px; border: 1px solid rgba(255,255,255,0.4);" title="Reset Filter">
                    <i class="bi bi-x-lg" style="font-size: 14px; font-weight: bold;"></i>
                </a>
            @endif
        </form>
    </div>
</div>

<div class="glass-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="border-0 rounded-start">Waktu</th>
                    <th class="border-0">Pengguna</th>
                    <th class="border-0">Aktivitas</th>
                    <th class="border-0">Transaksi</th>
                    <th class="border-0">Keterangan</th>
                    <th class="border-0 rounded-end text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $h)
                <tr>
                    <td>
                        <span class="fw-medium text-dark">{{ \Carbon\Carbon::parse($h->created_at)->format('d M Y') }}</span><br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($h->created_at)->format('H:i:s') }}</small>
                    </td>
                    <td>
                        <span class="fw-medium">{{ $h->user->name ?? 'Sistem' }}</span><br>
                        <small class="text-muted">{{ $h->user->role ?? '-' }}</small>
                    </td>
                    <td>
                        @php
                            $badgeClass = 'bg-secondary';
                            if($h->aktivitas == 'CREATE') $badgeClass = 'badge-create';
                            if($h->aktivitas == 'UPDATE') $badgeClass = 'badge-update';
                            if($h->aktivitas == 'DELETE') $badgeClass = 'badge-delete';
                        @endphp
                        <span class="badge {{ $badgeClass }} px-2 py-1">{{ $h->aktivitas }}</span>
                    </td>
                    <td><span class="fw-medium text-primary">{{ $h->transaksi }}</span></td>
                    <td>{{ $h->keterangan }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalData{{ $h->id }}">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada rekaman aktivitas (History).
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-4">
        {{ $histories->links() }}
    </div>
</div>

<!-- Modals for History Details -->
@foreach($histories as $h)
<div class="modal fade" id="modalData{{ $h->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px; overflow:hidden; background-color: #f3f4f6;">
            <div class="modal-header border-bottom" style="background-color: #f3f4f6;">
                <h5 class="modal-title fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">Detail History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Info Utama -->
                <div class="p-4 border-bottom">
                    <div class="row mb-3 align-items-center">
                        <div class="col-5 text-dark">Tanggal</div>
                        <div class="col-7 text-dark">: {{ \Carbon\Carbon::parse($h->created_at)->format('d - m - Y') }}</div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-5 text-dark">User</div>
                        <div class="col-7 text-dark">: {{ $h->user->name ?? 'Sistem' }}</div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-5 text-dark">Jenis Transaksi</div>
                        <div class="col-7 text-dark">: {{ $h->transaksi }}</div>
                    </div>
                    <div class="row mb-0 align-items-center">
                        <div class="col-5 text-dark">Aktivitas</div>
                        <div class="col-7 text-dark">: {{ $h->aktivitas == 'UPDATE' ? 'Edit' : ($h->aktivitas == 'CREATE' ? 'Tambah' : 'Hapus') }}</div>
                    </div>
                </div>

                <!-- Data Sebelum -->
                @if($h->data_sebelum)
                <div class="p-4 border-bottom">
                    <h6 class="fw-bold mb-3 text-dark">Data Sebelum</h6>
                    @foreach($h->data_sebelum as $key => $value)
                        @if(!in_array($key, ['id', 'created_at', 'updated_at', 'user_id', 'id_user', 'bukti']))
                        <div class="row mb-2">
                            <div class="col-5 text-dark">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                            <div class="col-7 text-dark">: 
                                @if($key == 'nominal')
                                    Rp {{ number_format((float)$value, 0, ',', '.') }}
                                @else
                                    {{ is_array($value) ? json_encode($value) : $value }}
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif

                <!-- Data Sesudah -->
                @if($h->data_sesudah)
                <div class="p-4 border-bottom">
                    <h6 class="fw-bold mb-3 text-dark">Data Sesudah</h6>
                    @foreach($h->data_sesudah as $key => $value)
                        @if(!in_array($key, ['id', 'created_at', 'updated_at', 'user_id', 'id_user', 'bukti']))
                        <div class="row mb-2">
                            <div class="col-5 text-dark">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                            <div class="col-7 text-dark">: 
                                @if($key == 'nominal')
                                    Rp {{ number_format((float)$value, 0, ',', '.') }}
                                @else
                                    {{ is_array($value) ? json_encode($value) : $value }}
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif

                <!-- Keterangan -->
                <div class="p-4">
                    <h6 class="fw-bold mb-2 text-dark">Keterangan</h6>
                    <p class="text-dark mb-0">{{ $h->keterangan }}</p>
                </div>
            </div>
            <div class="modal-footer border-top-0 justify-content-center" style="background-color: #f3f4f6; padding-bottom: 2rem;">
                <button type="button" class="btn btn-light px-5 shadow-sm border" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
