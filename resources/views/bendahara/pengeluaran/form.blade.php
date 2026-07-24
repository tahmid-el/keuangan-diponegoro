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
                        <div class="form-floating mb-3 position-relative">
                            <input type="text" class="form-control" id="kategori_input" placeholder="Ketik nama kategori..."
                                value="{{ old('kategori_input', isset($pengeluaran) && $pengeluaran->kategori ? $pengeluaran->kategori->nama : '') }}"
                                autocomplete="off" required>
                            <label for="kategori_input">Kategori Pengeluaran</label>
                            <input type="hidden" name="kategori_id" id="kategori_id" value="{{ old('kategori_id', $pengeluaran->kategori_id ?? '') }}">
                            <input type="hidden" name="kategori_baru" id="kategori_baru" value="">
                            <div id="kategori_suggestions" class="list-group position-absolute w-100" style="z-index: 1000; display: none; max-height: 200px; overflow-y: auto; border-radius: 0 0 12px 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1);"></div>
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

const kategoriInput = document.getElementById('kategori_input');
const kategoriId = document.getElementById('kategori_id');
const kategoriBaru = document.getElementById('kategori_baru');
const suggestions = document.getElementById('kategori_suggestions');
let debounceTimer;

kategoriInput.addEventListener('input', function() {
    clearTimeout(debounceTimer);
    kategoriId.value = '';
    kategoriBaru.value = this.value.trim();

    debounceTimer = setTimeout(() => {
        const query = this.value.trim();
        if (query.length < 1) {
            suggestions.style.display = 'none';
            return;
        }

        fetch(`{{ route('bendahara.api.kategoris.search') }}?tipe=pengeluaran&q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestions.innerHTML = '';
                if (data.length === 0) {
                    suggestions.innerHTML = `<div class="list-group-item text-muted">Kategori baru: ${query}</div>`;
                } else {
                    data.forEach(kategori => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = kategori.nama;
                        item.onclick = () => {
                            kategoriInput.value = kategori.nama;
                            kategoriId.value = kategori.id;
                            kategoriBaru.value = '';
                            suggestions.style.display = 'none';
                        };
                        suggestions.appendChild(item);
                    });
                }
                suggestions.style.display = 'block';
            });
    }, 200);
});

document.addEventListener('click', function(e) {
    if (!kategoriInput.contains(e.target) && !suggestions.contains(e.target)) {
        suggestions.style.display = 'none';
    }
});
</script>
@endpush
