@extends('layouts.app')

@section('content')
    <div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">
        
        <!-- Filter Section -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

            <div class="d-flex align-items-center gap-2 flex-wrap">
                
                <!-- Judul -->
                <h6 class="fw-bold mb-0">Tabungan</h6>

                <!-- Tombol tambah -->
                <a href="/tambah_saldo" class="btn btn-light btn-sm border px-4">
                    Tambah
                </a>
            </div>

        </div>

        <!-- Table -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center">

                        <thead style="background:#F8F8F8;">
                            <tr style="font-size:12px;">
                                <th>No.</th>
                                <th>No Induk</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal</th>
                                <th>Debit</th>
                                <th>Tanggal</th>
                                <th>Saldo</th>
                                <th>Total Saldo</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="8" class="text-muted">
                                    Data kosong
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4 d-flex gap-3">

            <a href="{{ url('/setor_tabungan') }}"class="btn btn-light border rounded-pill px-4 shadow-sm">
                Tambah Saldo
            </a>

            <a href="{{ url('/tarik_tabungan') }}"class="btn btn-light border rounded-pill px-4 shadow-sm">
                Tarik Saldo
            </a>

        </div>
        
    </div>
@endsection
