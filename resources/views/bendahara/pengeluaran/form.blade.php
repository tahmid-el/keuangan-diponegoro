@extends('layouts.app')

@section('title', isset($pengeluaran) ? 'Edit Pengeluaran' : 'Catat Pengeluaran Baru')

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
    .form-floating > label {
        color: #64748b;
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 1rem 0.75rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25);
    }
    .btn-custom-danger {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        padding: 0.75rem 1.5rem;
    }
    .btn-custom-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        color: white;
    }
    .slide-up {
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('bendahara.pengeluaran.index') }}" class="btn btn-light rounded-circle me-3 shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h3 class="fw-bold text-dark mb-0">{{ isset($pengeluaran) ? 'Edit Pengeluaran' : 'Catat Pengeluaran Baru' }}</h3>
        </div>

        @if($errors->any())
        <div class="alert alert-danger rounded-4 shadow-sm border-0 mb-4 slide-up">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="glass-card p-4 p-md-5 slide-up">
            <form action="{{ isset($pengeluaran) ? route('bendahara.pengeluaran.update', $pengeluaran->id) : route('bendahara.pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($pengeluaran))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', isset($pengeluaran) ? $pengeluaran->tanggal : date('Y-m-d')) }}" required>
                            <label for="tanggal">Tanggal Transaksi</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control nominal-input" id="nominal" name="nominal" placeholder="0" value="{{ old('nominal', isset($pengeluaran) ? number_format((float)$pengeluaran->nominal, 0, ',', '.') : '') }}" required>
                            <label for="nominal">Nominal Keluar (Rp)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="jenis_pengeluaran" name="jenis_pengeluaran" required>
                                <option value="" disabled {{ !isset($pengeluaran) ? 'selected' : '' }}>Pilih Jenis...</option>
                                <option value="Operasional" {{ old('jenis_pengeluaran', $pengeluaran->jenis_pengeluaran ?? '') == 'Operasional' ? 'selected' : '' }}>Operasional Sekolah</option>
                                <option value="Gaji & Honor" {{ old('jenis_pengeluaran', $pengeluaran->jenis_pengeluaran ?? '') == 'Gaji & Honor' ? 'selected' : '' }}>Gaji & Honor</option>
                                <option value="Pemeliharaan" {{ old('jenis_pengeluaran', $pengeluaran->jenis_pengeluaran ?? '') == 'Pemeliharaan' ? 'selected' : '' }}>Pemeliharaan Fasilitas</option>
                                <option value="Konsumsi" {{ old('jenis_pengeluaran', $pengeluaran->jenis_pengeluaran ?? '') == 'Konsumsi' ? 'selected' : '' }}>Konsumsi</option>
                                <option value="Lainnya" {{ old('jenis_pengeluaran', $pengeluaran->jenis_pengeluaran ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <label for="jenis_pengeluaran">Jenis Pengeluaran</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan singkat" value="{{ old('keterangan', isset($pengeluaran) ? $pengeluaran->keterangan : '') }}" required>
                            <label for="keterangan">Keterangan / Judul</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Penjelasan lengkap" style="height: 100px">{{ old('deskripsi', isset($pengeluaran) ? $pengeluaran->deskripsi : '') }}</textarea>
                            <label for="deskripsi">Deskripsi Detail (Opsional)</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label for="bukti" class="form-label text-muted ms-1">Unggah Kuitansi / Bukti (Opsional)</label>
                            <input class="form-control" type="file" id="bukti" name="bukti" accept="image/*">
                            @if(isset($pengeluaran) && $pengeluaran->bukti)
                                <div class="mt-2 text-muted small">
                                    <i class="bi bi-info-circle"></i> File saat ini: <a href="{{ asset('storage/' . $pengeluaran->bukti) }}" target="_blank" class="text-danger">Lihat Bukti</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-2">
                    <button type="submit" class="btn btn-custom-danger btn-lg">
                        <i class="bi bi-save me-2"></i> {{ isset($pengeluaran) ? 'Simpan Perubahan' : 'Simpan Pengeluaran' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nominalInput = document.querySelector('.nominal-input');
    if(nominalInput) {
        nominalInput.addEventListener('input', function(e) {
            let val = this.value.replace(/[^0-9]/g, '');
            if(val != "") {
                val = parseInt(val, 10).toString();
                this.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            } else {
                this.value = "";
            }
        });
    }
});
</script>
@endpush
