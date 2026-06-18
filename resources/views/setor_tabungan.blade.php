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
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date"
                        name="tanggal_bayar"
                        class="form-control rounded-4"
                        value="2025-03-05">
                </div>

                <!-- Nominal -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nominal</label>
                    <input type="text"
                        name="nama"
                        class="form-control rounded-4"
                        value="Isi Manual">
                </div>
            </div>

            <!-- Tombol -->
            <div class="mt-5 d-flex gap-3">

                <a href="{{ url('/tabungan') }}"
                    class="btn btn-light border px-5 rounded-4 shadow-sm">
                    Simpan
                </a>

                <a href="{{ url('/tabungan') }}"
                    class="btn btn-light border px-5 rounded-4 shadow-sm">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
@endsection