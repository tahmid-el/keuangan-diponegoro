@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    <!-- Header Atas -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div class="d-flex align-items-center gap-3">
            <h6 class="fw-bold mb-0">TAGIHAN</h6>

            <a href="#" class="btn btn-light border rounded-pill px-4 py-1 shadow-sm">
                Tambah
            </a>
        </div>

    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered text-center mb-0">

                    <thead style="background:#F8F8F8;">
                        <tr style="font-size:12px;">
                            <th>No.</th>
                            <th>No Induk</th>
                            <th>Nama Siswa</th>
                            <th>No Kwitansi</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="7" class="text-muted py-3">
                                DATA KOSONG
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- Form -->
    <div style="max-width:500px;">

        <form action="{{ url('/tagihan/store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <!-- Kelas -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kelas</label>
                    <select name="kelas" class="form-select form-select-sm rounded-pill">
                        <option>-- Pilih --</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                    </select>
                </div>

                <!-- Jenis Tagihan -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Jenis Tagihan</label>
                    <select name="jenis_tagihan" class="form-select form-select-sm rounded-pill">
                        <option>-- Pilih --</option>
                        <option>Biaya Pendidikan</option>
                        <option>Mid Semester Ganjil</option>
                        <option>Semester Ganjil</option>
                        <option>Mid Semester Genap</option>
                        <option>Semester Genap</option>
                    </select>
                </div>

                <!-- Periode -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Periode</label>
                    <select name="periode" class="form-select form-select-sm rounded-pill">
                        <option>2024</option>
                        <option>2025</option>
                        <option>2026</option>
                        <option>2027</option>
                    </select>
                </div>

                <!-- Kategori -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kategori Tagihan</label>
                    <select name="kategori" class="form-select form-select-sm rounded-pill">
                        <option>-- Pilih --</option>
                        <option>Normal</option>
                        <option>Subsidi Kurang Mampu</option>
                        <option>Subsidi Saudara</option>
                        <option>Subsidi Yatim</option>
                        <option>Subsidi Keluarga Guru</option>
                        <option>Subsidi Prestasi</option>
                    </select>
                </div>

                <!-- Nominal -->
                <div class="col-12">
                    <label class="form-label small fw-semibold">Nominal Tagihan</label>
                    <input type="number" name="nominal"
                        class="form-control form-control-sm rounded-pill"
                        placeholder="Masukan Nominal">
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-4 d-flex gap-3">

                 <a href="{{ url('/tagihan') }}"
                    class="btn btn-light border rounded-pill px-4 shadow-sm">
                    Simpan
                </a>

                <a href="{{ url('/tagihan') }}"
                    class="btn btn-light border rounded-pill px-4 shadow-sm">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
@endsection