@extends('layouts.app')

@section('content')
    <div class="container-fluid py-3" style="background-color: #F5F2DD; min-height:100vh;">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            
            <div class="fw-bold text-dark">
                ☰ Admin
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Search -->
                <div class="position-relative">
                    <input 
                        type="text" 
                        class="form-control form-control-sm pe-4"
                        placeholder="Cari di sini..."
                        style="width:220px;"
                    >
                </div>
            </div>
        </div>


        <!-- Top Action -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

            <div class="d-flex align-items-center gap-3">
                <h6 class="fw-bold mb-0">Tambah Data Siswa Baru</h6>

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
                                <th>Kategori Tagihan</th>
                                <th>Telepon</th>
                                <th>Jenis Kelamin</th>
                                <th>Orang Tua</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>

                        <tbody style="font-size:11px;">
                            <tr>
                                <td>1</td>
                                <td>220198</td>
                                <td>Ahmad Kholid</td>
                                <td>Normal</td>
                                <td>081000000000</td>
                                <td>L</td>
                                <td>Purnomo Wiranto</td>
                                <td>Dsn Krajan 2</td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>220198</td>
                                <td>Ahmad Hadi</td>
                                <td>Normal</td>
                                <td>081000000000</td>
                                <td>L</td>
                                <td>Purnomo Wiranto</td>
                                <td>Tegalkari 2</td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>220198</td>
                                <td>Busrol Lanang</td>
                                <td>Subsidi KR</td>
                                <td>081000000000</td>
                                <td>L</td>
                                <td>Purnomo Wiranto</td>
                                <td>Dsn Krajan 2</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>220198</td>
                                <td>Cintia Nadya</td>
                                <td>Subsidi Ser</td>
                                <td>081000000000</td>
                                <td>P</td>
                                <td>Purnomo Wiranto</td>
                                <td>Tegalkari 2</td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>220198</td>
                                <td>Didi Hafid</td>
                                <td>Normal</td>
                                <td>081000000000</td>
                                <td>L</td>
                                <td>Purnomo Wiranto</td>
                                <td>Dsn Krajan 2</td>
                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection