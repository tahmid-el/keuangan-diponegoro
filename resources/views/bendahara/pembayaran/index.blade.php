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
            <a href="{{ route('bendahara.pembayaran.tambah') }}"
                class="btn btn-primary">
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

                    @if($pembayarans->count())

                        @foreach($pembayarans as $index => $pembayaran)

                        <tr>

                            <td>{{ $index + 1 }}</td>

                            <td>{{ $pembayaran->nis }}</td>

                            <td>{{ $pembayaran->nama_siswa }}</td>

                            <td>{{ $pembayaran->no_kwitansi }}</td>

                            <td>
                                Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}
                            </td>

                            <td>{{ $pembayaran->nama_pembayaran }}</td>

                            <td>

                                <a href="{{ route('bendahara.pembayaran.edit', $pembayaran->id) }}"
                                    class="btn btn-light border px-4 rounded-4 shadow-sm">
                                    Edit
                                </a>

                            </td>

                        </tr>

                        @endforeach

                    @else

                    <tr>

                        <td colspan="7" class="text-center py-4">

                            Data pembayaran belum tersedia.

                        </td>

                    </tr>

                    @endif

                    </tbody>
    

                </table>
            </div>

        </div>
    </div>

</div>
@endsection