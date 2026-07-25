@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <h5 class="fw-bold mb-0">Tambah Tabungan (Transaksi Pertama)</h5>
    <a href="{{ route('bendahara.tabungan.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bendahara.tabungan.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Siswa</label>
                <select name="siswa_id" class="form-select" required>
                    <option value="">-- Pilih Siswa --</option>
                    @forelse($siswas as $siswa)
                        <option value="{{ $siswa->id }}">
                            {{ $siswa->nis }} - {{ $siswa->nama_siswa }}
                        </option>
                    @empty
                        <option disabled>Semua siswa sudah memiliki tabungan</option>
                    @endforelse
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" class="form-control"
                    value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Setoran Awal</label>
                <input type="number" name="nominal" class="form-control"
                    min="1000" placeholder="Masukkan nominal" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan" rows="3" class="form-control"
                    placeholder="Opsional"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('bendahara.tabungan.index') }}" class="btn btn-secondary px-4">Batal</a>
            <button type="submit" class="btn btn-custom-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
