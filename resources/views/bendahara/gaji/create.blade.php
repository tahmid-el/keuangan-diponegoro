@extends('layouts.app')

@section('title', 'Tambah Data Gaji')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    }
    .form-label-sm { font-size: 0.78rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; }
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-size: 0.92rem;
        padding: 0.5rem 0.75rem;
        height: 40px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }
    .btn-custom-primary {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        padding: 0.65rem 1.5rem;
        transition: all 0.2s;
    }
    .btn-custom-primary:hover { opacity: 0.9; color: white; transform: translateY(-1px); }
    .slide-up { animation: slideUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .section-divider { border: none; border-top: 1px solid #e8edf3; margin: 14px 0 16px; }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('bendahara.gaji.index') }}" class="btn btn-light rounded-circle me-3 shadow-sm" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold text-dark mb-0">Tambah Data Gaji</h4>
                <p class="text-muted small mb-0">Isi detail gaji guru atau karyawan</p>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-3 slide-up py-2 px-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li class="small">{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="glass-card p-4 slide-up">
            <form action="{{ route('bendahara.gaji.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-sm">Nama Guru</label>
                        <input type="text" class="form-control" name="nama"
                               placeholder="Contoh: Ahmad Dahlan" value="{{ old('nama') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-sm">Jumlah Jam</label>
                        <input type="number" class="form-control" name="jumlah_jam"
                               placeholder="Contoh: 40" value="{{ old('jumlah_jam') }}" min="0" required>
                    </div>
                </div>

                <hr class="section-divider">

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label-sm">Bisyaroh (Honor)</label>
                        <input type="text" class="form-control nominal-input" name="bisyaroh"
                               placeholder="0" value="{{ old('bisyaroh') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-sm">Tunjangan Kamad/WK</label>
                        <input type="text" class="form-control nominal-input" name="tunjangan_kamad_wk"
                               placeholder="0" value="{{ old('tunjangan_kamad_wk') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-sm">Tunjangan Piket</label>
                        <input type="text" class="form-control nominal-input" name="tunjangan_piket"
                               placeholder="0" value="{{ old('tunjangan_piket') }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-2 mb-3 px-1">
                    <span class="text-muted small me-2">Total Gaji:</span>
                    <span id="total-nominal-display" class="fw-bold fs-5 text-success">Rp 0</span>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('bendahara.gaji.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-custom-primary px-4">
                        <i class="bi bi-check2 me-1"></i> Simpan
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
    function parseNumber(el) {
        return parseInt(el.value.replace(/\./g, '').replace(/,/g, ''), 10) || 0;
    }

    function recalcTotal() {
        let total = 0;
        document.querySelectorAll('.nominal-input').forEach(function(el) {
            total += parseNumber(el);
        });
        const display = document.getElementById('total-nominal-display');
        if (display) {
            display.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    document.querySelectorAll('.nominal-input').forEach(function(el) {
        el.addEventListener('input', function() {
            let val = el.value.replace(/[^0-9]/g, '');
            el.value = val ? parseInt(val, 10).toLocaleString('id-ID') : '';
            recalcTotal();
        });
    });

    recalcTotal();
});
</script>
@endpush
