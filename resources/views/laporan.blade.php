@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div class="d-flex align-items-center gap-3">
            <h6 class="fw-bold mb-0">LAPORAN</h6>

            <a href="#" class="btn btn-light border rounded-pill px-4 py-1 shadow-sm">
                Tambah
            </a>
        </div>

    </div>

    <!-- Card Kosong -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body py-4 text-center text-muted">
            Belum ada data laporan
        </div>
    </div>

    <!-- Form -->
    <div style="max-width:700px;">

        <form action="{{ url('/laporan/store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <!-- Jenis Laporan -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">
                        Jenis Laporan
                    </label>

                    <select name="jenis_laporan"
                        class="form-select form-select-sm rounded-pill">
                        <option>-- Pilih --</option>
                        <option>Semua</option>
                        <option>Pembayaran</option>
                        <option>Tagihan</option>
                        <option>Tabungan</option>
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">
                        Tahun Ajaran
                    </label>

                    <select name="tahun_ajaran"
                        class="form-select form-select-sm rounded-pill">
                        <option>-- Pilih --</option>
                        <option>2022</option>
                        <option>2023</option>
                        <option>2024</option>
                        <option>2025</option>
                        <option>2026</option>
                    </select>
                </div>

                <!-- Periode Awal -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">
                        Periode Awal
                    </label>

                    <select name="periode_awal"
                        class="form-select form-select-sm rounded-pill">
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                </div>

                <!-- Periode Akhir -->
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">
                        Periode Akhir
                    </label>

                    <select name="periode_akhir"
                        class="form-select form-select-sm rounded-pill">
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-4 mb-4 d-flex gap-3">

                <button type="submit"
                    class="btn btn-light border rounded-pill px-4 shadow-sm">
                    Tampilkan Data
                </button>

                <a href="{{ url('/laporan') }}"
                    class="btn btn-light border rounded-pill px-4 shadow-sm">
                    Batal
                </a>

            </div>

        </form>

    </div>

    <!-- Tabel -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered text-center mb-0">

                    <thead style="background:#F8F8F8;">
                        <tr style="font-size:12px;">
                            <th>No.</th>
                            <th>No Induk</th>
                            <th>Nama Siswa</th>
                            <th>Jenis</th>
                            <th>Periode</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="7" class="text-muted py-4">
                                DATA KOSONG
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
@endsection