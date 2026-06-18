@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

        <!-- Judul + Search -->
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <h6 class="fw-bold mb-0">PEMBAYARAN</h6>

            <div class="position-relative">
                <input type="text"
                    class="form-control form-control-sm rounded-pill ps-3 pe-5"
                    placeholder="Nama / No Induk Siswa"
                    style="width:230px;">
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted">
                    🔍
                </span>
            </div>
            <a href="/tambah_pembayaran" class="btn btn-light btn-sm border px-4">
                Tambah
            </a>
        </div>

    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered text-center mb-0 align-middle">

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

                    <tbody style="font-size:12px;">

                        @for ($i = 1; $i <= 8; $i++)
                        <tr>
                            <td>{{ $i }}.</td>
                            <td>4981</td>
                            <td>ZAKI NAUFAL ABIDILAH</td>
                            <td>0000</td>
                            <td>1.500.000</td>
                            <td>Cicilan</td>
                            <td>
                                <a href="{{ url('/edit_pembayaran') }}"class="btn btn-light border px-5 rounded-4 shadow-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @endfor

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
@endsection