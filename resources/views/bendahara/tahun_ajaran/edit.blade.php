@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <h5 class="fw-bold mb-0">Edit Tahun Ajaran</h5>
    <a href="{{ route('bendahara.tahun_ajaran.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    <form action="{{ route('bendahara.tahun_ajaran.update', $tahunAjaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tahun Ajaran</label>
                <input type="text" name="nama"
                    class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama', $tahunAjaran->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Semester</label>
                <select name="semester"
                    class="form-select @error('semester') is-invalid @enderror" required>
                    <option value="Ganjil"
                        {{ old('semester', $tahunAjaran->semester) == 'Ganjil' ? 'selected' : '' }}>
                        Ganjil
                    </option>
                    <option value="Genap"
                        {{ old('semester', $tahunAjaran->semester) == 'Genap' ? 'selected' : '' }}>
                        Genap
                    </option>
                </select>
                @error('semester')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai"
                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                    value="{{ old('tanggal_mulai', $tahunAjaran->tanggal_mulai) }}" required>
                @error('tanggal_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai"
                    class="form-control @error('tanggal_selesai') is-invalid @enderror"
                    value="{{ old('tanggal_selesai', $tahunAjaran->tanggal_selesai) }}" required>
                @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-warning text-white px-4">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
            <a href="{{ route('bendahara.tahun_ajaran.index') }}"
                class="btn btn-secondary px-4">Batal</a>
        </div>
    </form>
</div>
@endsection
