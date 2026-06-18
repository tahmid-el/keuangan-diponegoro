@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color: #F5F2DD; min-height:100vh;">

    <!-- Top Action -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

        <div class="d-flex align-items-center gap-3">
            <h6 class="fw-bold mb-0">
                Tambah Data Siswa Lama-2025
            </h6>

            <a href="/data_siswa" class="btn btn-light btn-sm border px-4">
                Simpan
            </a>

            <a href="/data_siswa" class="btn btn-light btn-sm border px-4">
                Batal
            </a>
        </div>

    </div>


    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0 text-center align-middle">

                    <thead class="table-light">
                        <tr style="font-size:11px;">
                            <th>No.</th>
                            <th>No Induk</th>
                            <th>Nama Siswa</th>
                            <th>Orang Tua</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody style="font-size:11px;">
                        @for ($i = 1; $i <= 8; $i++)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>4981</td>
                            <td>ZAKI NAUFAL ABDILLAH</td>
                            <td>TEGUH NURCAHYONO</td>
                            <td>L</td>
                            <td>DUSUN KRAJAN 1, RT 011 RW 002</td>
                            <td>
                                <button class="btn btn-secondary btn-sm">
                                    Edit
                                </button>

                                <button class="btn btn-light btn-sm border">
                                    Lihat
                                </button>
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