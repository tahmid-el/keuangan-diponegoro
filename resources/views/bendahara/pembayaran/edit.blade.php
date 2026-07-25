@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <h5 class="fw-bold mb-0">Edit Pembayaran</h5>
    <a href="{{ route('bendahara.pembayaran.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    <form action="{{ route('bendahara.pembayaran.update', $pembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">No Induk</label>
                <input type="text" class="form-control" value="{{ $pembayaran->nis }}" readonly>
            </div>

            <div class="col-md-8">
                <label class="form-label fw-semibold">No Kwitansi</label>
                <input type="text" name="no_kwitansi" class="form-control @error('no_kwitansi') is-invalid @enderror"
                    value="{{ old('no_kwitansi', $pembayaran->no_kwitansi) }}" required>
                @error('no_kwitansi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12">
                <label class="form-label fw-semibold">Nama Siswa</label>
                <input type="text" class="form-control" value="{{ $pembayaran->nama_siswa }}" readonly>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" class="form-control @error('tanggal_bayar') is-invalid @enderror"
                    value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar) }}" required>
                @error('tanggal_bayar')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Periode Pembayaran</label>
                <select name="periode" class="form-select @error('periode') is-invalid @enderror" required>
                    @foreach($tahunAjaran as $tahun)
                        <option value="{{ $tahun->nama }}" {{ old('periode', $pembayaran->periode) == $tahun->nama ? 'selected' : '' }}>
                            {{ $tahun->nama }} - {{ $tahun->semester }}
                        </option>
                    @endforeach
                </select>
                @error('periode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Jenis Pembayaran</label>
                <select name="jenis_pembayaran_id" class="form-select" disabled>
                    @foreach($jenisPembayaran as $jenis)
                        <option value="{{ $jenis->id }}" {{ $pembayaran->jenis_pembayaran_id == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nominal</label>
                <input type="number" name="nominal" class="form-control @error('nominal') is-invalid @enderror"
                    value="{{ old('nominal', $pembayaran->nominal) }}" required>
                @error('nominal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Keterangan</label>
                <input type="text" name="keterangan" class="form-control"
                    value="{{ old('keterangan', $pembayaran->keterangan) }}" placeholder="Opsional">
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-warning text-white px-4">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
            <a href="{{ route('bendahara.pembayaran.index') }}" class="btn btn-secondary px-4">Batal</a>
        </div>
    </form>
</div>
@endsection
