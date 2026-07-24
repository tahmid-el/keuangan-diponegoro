@extends('layouts.app')

@section('content')
    <div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">
        
        <!-- Filter Section -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

            <div class="d-flex align-items-center gap-2 flex-wrap">
                
                <!-- Judul -->
                <h6 class="fw-bold mb-0">Tabungan</h6>

                <!-- Tombol tambah -->
                <a href="{{ route('bendahara.tabungan.create') }}"
                    class="btn btn-light btn-sm border px-4">
                    Tambah
                </a>
            </div>

        </div>

        <!-- Table -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center">

                        <thead>
<tr>
                            <th>No</th>
                            <th>No. Induk</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Transaksi</th>
                            <th>Saldo</th>
                            <th>Total Saldo</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($tabungans as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->nis }}</td>

                            <td>{{ $item->nama_siswa }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                            </td>

                            <td>

                                @if($item->jenis=='setor')

                                    <span class="badge bg-success">
                                        Setor
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Tarik
                                    </span>

                                @endif

                            </td>

                            <td>
                                Rp {{ number_format($item->nominal,0,',','.') }}
                            </td>

                            <td>
                                Rp {{ number_format($item->saldo_akhir,0,',','.') }}
                            </td>

                            <td>

                                <a
                                    href="{{ route('bendahara.tabungan.show',$item->tabungan_id) }}"
                                    class="btn btn-info btn-sm">

                                    Detail

                                </a>

                            </td>

                        </tr>

                        @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4 d-flex gap-3">

            <a href="{{ route('bendahara.tabungan.setor') }}"class="btn btn-light border rounded-pill px-4 shadow-sm">
                Tambah Saldo
            </a>

            <a href="{{ route('bendahara.tabungan.tarik') }}"class="btn btn-light border rounded-pill px-4 shadow-sm">
                Tarik Saldo
            </a>

        </div>
        
    </div>
@endsection
