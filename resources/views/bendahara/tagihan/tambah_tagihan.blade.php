@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <h5 class="fw-bold mb-0">Tambah Tagihan</h5>
    <a href="{{ route('bendahara.tagihan.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    <div style="max-width:700px;">

        <form action="{{ route('bendahara.tagihan.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <!-- Kelas -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kategori Tagihan -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kategori Tagihan</label>
                    <select name="jenis_tagihan_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($jenisTagihan as $jt)
                            <option value="{{ $jt->id }}">{{ ucfirst($jt->nama_tagihan) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Pembayaran -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran_id" class="form-select" required>
                        <option value="">-- Pilih Jenis Pembayaran --</option>
                        @foreach($jenisPembayaran as $jp)
                            <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nominal -->
                <div class="col-12">
                    <label class="form-label small fw-semibold">Nominal Tagihan</label>
                    <input type="number" name="nominal" class="form-control" placeholder="Masukan Nominal">
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-4 d-flex gap-3">
                <button type="submit" class="btn btn-custom-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('bendahara.tagihan.index')}}" class="btn btn-secondary px-4">Batal</a>
            </div>

        </form>

    </div>
</div>
@endsection
