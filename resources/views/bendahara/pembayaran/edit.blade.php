@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#9DB2D8; min-height:100vh;">

    <div class="mx-auto" style="max-width:750px;">

        <form action="{{ route('bendahara.pembayaran.update', $pembayaran->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">

                <!-- No Induk -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">No Induk</label>
                    <input type="text"
                        name="no_induk"
                        class="form-control rounded-4"
                        value="{{ old('no_induk', $pembayaran->nis) }}">
                </div>

                <!-- No Kwitansi -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">No Kwitansi</label>
                    <input type="text"
                        name="no_kwitansi"
                        class="form-control rounded-4"
                        value="{{ old('no_kwitansi', $pembayaran->no_kwitansi) }}">
                </div>

                <!-- Nama -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text"
                        name="nama"
                        class="form-control rounded-4"
                        value="{{ old('nama', $pembayaran->nama_siswa) }}">
                </div>

                <!-- Tanggal Bayar -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Bayar</label>
                    <input type="date"
                        name="tanggal_bayar"
                        class="form-control rounded-4"
                        value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar) }}">
                </div>

                <!-- Periode Pembayaran -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Periode Pembayaran</label>
                    <select name="tahun_ajaran_id" class="form-select rounded-4">
                        <option value="{{ $pembayaran->tahun_ajaran_id }}">
                            {{ $pembayaran->nama_tahun }}
                        </option>
                    </select>
                </div>

                <!-- Nominal -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nominal</label>
                    <input type="text"
                        name="nominal"
                        class="form-control rounded-4"
                        value="{{ old('nominal', $pembayaran->nominal) }}">
                </div>

                <!-- Jenis Pembayaran -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran_id" class="form-select rounded-4">
                        <option value="{{ $pembayaran->jenis_pembayaran_id }}" selected>
                            {{ $pembayaran->nama_jenis }}
                        </option>
                    </select>
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-5 d-flex gap-3">

                <button type="submit"
                    class="btn btn-primary px-5 rounded-4 shadow-sm">
                    Simpan
                </button>

                <a href="{{ route('bendahara.pembayaran.index') }}"
                    class="btn btn-secondary px-5 rounded-4 shadow-sm">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
@endsection