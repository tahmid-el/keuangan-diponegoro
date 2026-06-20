@extends('layouts.app')

@section('title', isset($pemasukan) ? 'Edit Pemasukan' : 'Catat Pemasukan Baru')

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
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
    }
    .btn-custom-primary {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        color: white;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        padding: 0.75rem 1.5rem;
    }
    .btn-custom-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
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
            <a href="{{ route('bendahara.pemasukan.index') }}" class="btn btn-light rounded-circle me-3 shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h3 class="fw-bold text-dark mb-0">{{ isset($pemasukan) ? 'Edit Pemasukan' : 'Catat Pemasukan Baru' }}</h3>
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
            <form action="{{ isset($pemasukan) ? route('bendahara.pemasukan.update', $pemasukan->id) : route('bendahara.pemasukan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($pemasukan))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', isset($pemasukan) ? $pemasukan->tanggal : date('Y-m-d')) }}" required>
                            <label for="tanggal">Tanggal Transaksi</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control nominal-input" id="nominal" name="nominal" placeholder="0" value="{{ old('nominal', isset($pemasukan) ? number_format((float)$pemasukan->nominal, 0, ',', '.') : '') }}" required>
                            <label for="nominal">Nominal (Rp)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="sumber_dana" name="sumber_dana" required>
                                <option value="" disabled {{ !isset($pemasukan) ? 'selected' : '' }}>Pilih Sumber Dana...</option>
                                <option value="Pembayaran Siswa" {{ old('sumber_dana', $pemasukan->sumber_dana ?? '') == 'Pembayaran Siswa' ? 'selected' : '' }}>Pembayaran Siswa</option>
                                <option value="Assessment" {{ old('sumber_dana', $pemasukan->sumber_dana ?? '') == 'Assessment' ? 'selected' : '' }}>Assessment</option>
                                <option value="Dana BOS" {{ old('sumber_dana', $pemasukan->sumber_dana ?? '') == 'Dana BOS' ? 'selected' : '' }}>Dana BOS</option>
                                <option value="Donasi" {{ old('sumber_dana', $pemasukan->sumber_dana ?? '') == 'Donasi' ? 'selected' : '' }}>Donasi</option>
                                <option value="Lainnya" {{ old('sumber_dana', $pemasukan->sumber_dana ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <label for="sumber_dana">Sumber Dana</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan singkat" value="{{ old('keterangan', isset($pemasukan) ? $pemasukan->keterangan : '') }}" required>
                            <label for="keterangan">Keterangan / Judul</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Penjelasan lengkap" style="height: 100px">{{ old('deskripsi', isset($pemasukan) ? $pemasukan->deskripsi : '') }}</textarea>
                            <label for="deskripsi">Deskripsi Detail (Opsional)</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label for="bukti" class="form-label text-muted ms-1">Unggah Bukti Transaksi (Opsional)</label>
                            <input class="form-control" type="file" id="bukti" name="bukti" accept="image/*">
                            @if(isset($pemasukan) && $pemasukan->bukti)
                                <div class="mt-2 text-muted small">
                                    <i class="bi bi-info-circle"></i> File saat ini: <a href="{{ asset('storage/' . $pemasukan->bukti) }}" target="_blank">Lihat Bukti</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-2">
                    <button type="submit" class="btn btn-custom-primary btn-lg">
                        <i class="bi bi-save me-2"></i> {{ isset($pemasukan) ? 'Simpan Perubahan' : 'Simpan Pemasukan' }}
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
