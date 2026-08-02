@extends('layouts.app')

@section('title', isset($pengeluaran) ? 'Edit Pengeluaran' : 'Catat Pengeluaran Baru')

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
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .item-row {
        background: #fff5f5;
        border: 1px solid #fecaca !important;
        border-radius: 12px !important;
        padding: 12px 14px !important;
        transition: border-color 0.2s;
    }
    .item-row:hover { border-color: #f87171 !important; }
    .btn-add-row {
        background: transparent;
        border: 1.5px dashed #dc2626;
        color: #dc2626;
        border-radius: 10px;
        font-size: 0.85rem;
        padding: 7px 16px;
        transition: all 0.2s;
        width: 100%;
    }
    .btn-add-row:hover { background: #fff1f2; }
    .btn-custom-danger {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        padding: 0.65rem 1.5rem;
        transition: all 0.2s;
    }
    .btn-custom-danger:hover { opacity: 0.9; color: white; transform: translateY(-1px); }
    .slide-up { animation: slideUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .section-divider { border: none; border-top: 1px solid #e8edf3; margin: 14px 0 16px; }
    #kategori_suggestions .list-group-item { font-size: 0.88rem; padding: 7px 12px; cursor: pointer; }
    #kategori_suggestions .list-group-item:hover { background: #fff1f2; color: #dc2626; }
    .badge-new-cat { font-size: 0.72rem; background: #f1f5f9; color: #64748b; border-radius: 6px; padding: 2px 6px; }
</style>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('bendahara.pengeluaran.index') }}" class="btn btn-light rounded-circle me-3 shadow-sm" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold text-dark mb-0">{{ isset($pengeluaran) ? 'Edit Pengeluaran' : 'Catat Pengeluaran Baru' }}</h4>
                <p class="text-muted small mb-0">{{ isset($pengeluaran) ? 'Perbarui data transaksi pengeluaran' : 'Isi detail transaksi pengeluaran' }}</p>
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
            <form action="{{ isset($pengeluaran) ? route('bendahara.pengeluaran.update', $pengeluaran->id) : route('bendahara.pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($pengeluaran)) @method('PUT') @endif

                {{-- ── Header: Tanggal & Kategori ─── --}}
                <div class="row g-3 mb-2">
                    <div class="col-md-5">
                        <label class="form-label-sm">Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tanggal"
                               value="{{ old('tanggal', isset($pengeluaran) ? $pengeluaran->tanggal : date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label-sm">Kategori Pengeluaran</label>
                        <div class="position-relative">
                            <input type="text" class="form-control" id="kategori_input"
                                   placeholder="Pilih atau ketik kategori baru..."
                                   value="{{ old('kategori_input', isset($pengeluaran) && $pengeluaran->kategori ? $pengeluaran->kategori->nama : '') }}"
                                   autocomplete="off" required>
                            <input type="hidden" name="kategori_id" id="kategori_id" value="{{ old('kategori_id', $pengeluaran->kategori_id ?? '') }}">
                            <input type="hidden" name="kategori_baru" id="kategori_baru" value="">
                            <div id="kategori_suggestions" class="list-group position-absolute w-100"
                                 style="z-index: 1000; display: none; max-height: 220px; overflow-y: auto; border-radius: 0 0 10px 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); border: 1px solid #fecaca; border-top: none;"></div>
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                {{-- Dropdown Gaji (muncul jika kategori = Gaji) --}}
                <div class="row g-3 mb-3" id="gaji-section" style="display: none;">
                </div>

                <hr class="section-divider">

                @if(isset($pengeluaran))
                    {{-- ── Mode Edit (Single Row) ── --}}
                    <div class="row g-2 align-items-end mb-3" id="edit-manual-row">
                        <div class="col-md-6">
                            <label class="form-label-sm">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan"
                                   placeholder="Contoh: Beli ATK" value="{{ old('keterangan', $pengeluaran->keterangan) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-sm">Nominal (Rp)</label>
                            <input type="text" class="form-control nominal-input" name="nominal"
                                   placeholder="0" value="{{ old('nominal', number_format((float)$pengeluaran->nominal, 0, ',', '.')) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-sm">Bukti <span class="badge-new-cat">Opsional</span></label>
                            <input class="form-control" type="file" name="bukti" accept="image/*">
                            @if($pengeluaran->bukti)
                                <a href="{{ asset('storage/' . $pengeluaran->bukti) }}" target="_blank" class="small text-danger mt-1 d-block"><i class="bi bi-paperclip"></i> Lihat Bukti</a>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- ── Mode Create (Multiple Rows) ── --}}
                    <p class="text-muted small mb-2">Tambahkan satu atau lebih item pengeluaran di bawah ini:</p>
                    <div id="item-container">
                        <div class="item-row mb-2">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-5">
                                    <label class="form-label-sm">Keterangan</label>
                                    <input type="text" class="form-control keterangan-input" name="keterangan[]"
                                           placeholder="Contoh: Beli ATK" required>
                                    <select class="form-select keterangan-select" name="keterangan[]" style="display:none;" required>
                                        <option value="">-- Pilih Guru --</option>
                                        @isset($gajis)
                                            @foreach($gajis as $gaji)
                                                <option value="Gaji - {{ $gaji->nama }}" data-gaji-id="{{ $gaji->id }}" data-jumlah="{{ $gaji->jumlah }}">
                                                    {{ $gaji->nama }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    <input type="hidden" class="gaji-id-input" name="gaji_id[]" value="">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-sm">Nominal (Rp)</label>
                                    <input type="text" class="form-control nominal-input" name="nominal[]"
                                           placeholder="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-sm">Bukti <span class="badge-new-cat">Opsional</span></label>
                                    <input class="form-control" type="file" name="bukti[]" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-add-row mt-1 mb-2" id="btn-add-item">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baris
                    </button>
                    <div class="d-flex justify-content-end align-items-center mt-2 mb-3 px-1">
                        <span class="text-muted small me-2">Total Nominal:</span>
                        <span id="total-nominal-display" class="fw-bold fs-5 text-danger">Rp 0</span>
                    </div>
                @endif

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('bendahara.pengeluaran.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-custom-danger px-4">
                        <i class="bi bi-check2 me-1"></i> {{ isset($pengeluaran) ? 'Simpan Perubahan' : 'Simpan Semua' }}
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

    // ── Hitung total nominal ──
    function recalcTotal() {
        let total = 0;
        document.querySelectorAll('.nominal-input').forEach(function(el) {
            const raw = el.value.replace(/\./g, '').replace(/,/g, '');
            const num = parseInt(raw, 10);
            if (!isNaN(num)) total += num;
        });
        const display = document.getElementById('total-nominal-display');
        if (display) {
            display.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    // ── Format nominal (delegasi event agar berjalan di baris dinamis) ──
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('nominal-input')) {
            let val = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = val ? parseInt(val, 10).toLocaleString('id-ID') : '';
            recalcTotal();
        }
    });

    recalcTotal(); // inisialisasi

    // ── Tambah / Hapus baris dinamis (mode create) ──
    const btnAdd    = document.getElementById('btn-add-item');
    const container = document.getElementById('item-container');
    if (btnAdd && container) {
        btnAdd.addEventListener('click', function() {
            const isGaji = kategoriInput.value.toLowerCase().includes('gaji');
            const row = document.createElement('div');
            row.className = 'item-row mb-2 position-relative';
            
            const keterField = isGaji ? `
                <select class="form-select keterangan-select" name="keterangan[]" required>
                    <option value="">-- Pilih Guru --</option>
                    @isset($gajis)
                        @foreach($gajis as $gaji)
                            <option value="Gaji - {{ $gaji->nama }}" data-gaji-id="{{ $gaji->id }}" data-jumlah="{{ $gaji->jumlah }}">
                                {{ $gaji->nama }}
                            </option>
                        @endforeach
                    @endisset
                </select>
                <input type="hidden" class="gaji-id-input" name="gaji_id[]" value="">
            ` : `
                <input type="text" class="form-control keterangan-input" name="keterangan[]" placeholder="Contoh: Beli ATK" required>
            `;

            row.innerHTML = `
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-1 me-1 btn-remove-item" style="font-size:0.7rem;z-index:10;" aria-label="Hapus"></button>
                <div class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label-sm">Keterangan</label>
                        ${keterField}
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-sm">Nominal (Rp)</label>
                        <input type="text" class="form-control nominal-input" name="nominal[]" placeholder="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-sm">Bukti <span class="badge-new-cat">Opsional</span></label>
                        <input class="form-control" type="file" name="bukti[]" accept="image/*">
                    </div>
                </div>
            `;
            container.appendChild(row);
            recalcTotal();
        });
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove-item')) {
                e.target.closest('.item-row').remove();
                recalcTotal();
            }
        });
    }

    // ── Kategori autocomplete dengan tampil saat fokus ──
    const kategoriInput = document.getElementById('kategori_input');
    const kategoriId    = document.getElementById('kategori_id');
    const kategoriBaru  = document.getElementById('kategori_baru');
    const suggestions   = document.getElementById('kategori_suggestions');
    if (!kategoriInput) return;

    let debounceTimer;

    function loadSuggestions(query) {
        const url = `{{ route('bendahara.api.kategoris.search') }}?tipe=pengeluaran&q=${encodeURIComponent(query)}`;
        fetch(url)
            .then(r => r.json())
            .then(data => {
                suggestions.innerHTML = '';
                if (data.length === 0) {
                    if (query.length > 0) {
                        suggestions.innerHTML = `<div class="list-group-item text-muted fst-italic">Buat kategori baru: "${query}"</div>`;
                    }
                } else {
                    data.forEach(k => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = k.nama;
                        item.onclick = () => {
                            kategoriInput.value = k.nama;
                            kategoriId.value    = k.id;
                            kategoriBaru.value  = '';
                            suggestions.style.display = 'none';
                            toggleGajiSection();
                        };
                        suggestions.appendChild(item);
                    });
                }
                suggestions.style.display = suggestions.innerHTML ? 'block' : 'none';
            });
    }

    // Tampil semua saat fokus
    kategoriInput.addEventListener('focus', function() {
        loadSuggestions(this.value.trim());
    });

    kategoriInput.addEventListener('input', function() {
        kategoriId.value   = '';
        kategoriBaru.value = this.value.trim();
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => loadSuggestions(this.value.trim()), 200);
        toggleGajiSection();
    });

    function toggleGajiSection() {
        const kategoriValue = kategoriInput.value.toLowerCase();
        const gajiSection = document.getElementById('gaji-section');
        const isGaji = kategoriValue.includes('gaji');
        
        if (gajiSection) {
            gajiSection.style.display = isGaji ? 'block' : 'none';
        }

        document.querySelectorAll('.item-row').forEach(row => {
            const keterInput = row.querySelector('.keterangan-input');
            const keterSelect = row.querySelector('.keterangan-select');
            const gajiIdInput = row.querySelector('.gaji-id-input');
            
            if (isGaji) {
                if (keterInput) keterInput.style.display = 'none';
                if (keterSelect) keterSelect.style.display = 'block';
                if (gajiIdInput) gajiIdInput.removeAttribute('disabled');
            } else {
                if (keterInput) keterInput.style.display = 'block';
                if (keterSelect) keterSelect.style.display = 'none';
                if (keterSelect) keterSelect.value = '';
                if (gajiIdInput) {
                    gajiIdInput.value = '';
                    gajiIdInput.setAttribute('disabled', 'disabled');
                }
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('keterangan-select')) {
                const row = e.target.closest('.item-row');
                const gajiIdInput = row.querySelector('.gaji-id-input');
                const nominalInput = row.querySelector('.nominal-input');
                const selectedOption = e.target.options[e.target.selectedIndex];

                if (selectedOption && selectedOption.dataset.gajiId) {
                    gajiIdInput.value = selectedOption.dataset.gajiId;
                    if (nominalInput) {
                        nominalInput.value = parseInt(selectedOption.dataset.jumlah).toLocaleString('id-ID');
                        recalcTotal();
                    }
                }
            }
        });
    }

    document.addEventListener('click', function(e) {
        if (!kategoriInput.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.style.display = 'none';
        }
    });
});
</script>
@endpush
