@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#9DB2D8; min-height:100vh;">

    <div class="card shadow border-0 rounded-4">

        {{-- Header --}}
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">
                Detail Tabungan Siswa
            </h4>
        </div>

        {{-- Informasi Siswa --}}
        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">
                    <table class="table table-borderless mb-0">

                        <tr>
                            <th width="180">No. Induk</th>
                            <td>: {{ $tabungan->siswa->nis }}</td>
                        </tr>

                        <tr>
                            <th>Nama Siswa</th>
                            <td>: {{ $tabungan->siswa->nama_siswa }}</td>
                        </tr>

                        <tr>
                            <th>Total Saldo</th>
                            <td>
                                :
                                <strong class="text-success">
                                    Rp {{ number_format($tabungan->saldo,0,',','.') }}
                                </strong>
                            </td>
                        </tr>

                    </table>
                </div>

            </div>

            <hr>

            <h5 class="mb-3">
                Riwayat Transaksi
            </h5>

            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-primary">

                        <tr class="text-center">

                            <th width="60">No</th>
                            <th>Tanggal</th>
                            <th>Transaksi</th>
                            <th>Nominal</th>
                            <th>Saldo Akhir</th>
                            <th>Keterangan</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($mutasi as $item)

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>

                                <td class="text-center">

                                    @if($item->jenis == 'setor')

                                        <span class="badge bg-success">
                                            Setor
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Tarik
                                        </span>

                                    @endif

                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($item->nominal,0,',','.') }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($item->saldo_akhir,0,',','.') }}
                                </td>

                                <td>
                                    {{ $item->keterangan ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center text-muted">

                                    Belum ada transaksi.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                <a href="{{ route('bendahara.tabungan.index') }}"
                   class="btn btn-secondary">

                    ← Kembali

                </a>

            </div>

        </div>

    </div>

</div>
@endsection