@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#9DB2D8; min-height:100vh;">

    <div class="mx-auto" style="max-width:750px;">

        <form action="{{ url('/pembayaran/store') }}" method="POST">
            @csrf

            <div class="row g-4">

                <!-- No Induk -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">No Induk</label>
                    <input type="text"
                        name="no_induk"
                        class="form-control rounded-4"
                        value="4981">
                </div>

                <!-- No Kwitansi -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">No Kwitansi</label>
                    <input type="text"
                        name="no_kwitansi"
                        class="form-control rounded-4"
                        value="Isi manual">
                </div>

                <!-- Nama -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text"
                        name="nama"
                        class="form-control rounded-4"
                        value="ZAKI NAUFAL ABDILAH">
                </div>

                <!-- Tanggal Bayar -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Bayar</label>
                    <input type="date"
                        name="tanggal_bayar"
                        class="form-control rounded-4"
                        value="2025-03-05">
                </div>

                <!-- Periode Pembayaran -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Periode Pembayaran</label>
                    <select name="periode" class="form-select rounded-4">
                        <option>2025/2026</option>
                        <option>2026/2027</option>
                    </select>
                </div>

                <!-- Nominal -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nominal</label>
                    <input type="text"
                        name="nominal"
                        class="form-control rounded-4"
                        value="Isi manual">
                </div>

                <!-- Jenis Pembayaran -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" class="form-select rounded-4">
                        <option>Biaya Pendidikan</option>
                        <option>Mid Semester Ganjil</option>
                        <option>Semester Ganjil</option>
                        <option>Mid Semester Genap</option>
                        <option>Semester Genap</option>
                    </select>
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-5 d-flex gap-3">

                <a href="{{ url('/pembayaran') }}"
                    class="btn btn-light border px-5 rounded-4 shadow-sm">
                    Simpan
                </a>

                <a href="{{ url('/pembayaran') }}"
                    class="btn btn-light border px-5 rounded-4 shadow-sm">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
@endsection