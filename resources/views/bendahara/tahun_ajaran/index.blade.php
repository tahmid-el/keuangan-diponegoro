@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

        <!-- Judul + Search -->
        <div class="d-flex align-items-center gap-3 flex-wrap">

            <h6 class="fw-bold mb-0">TAHUN AJARAN</h6>

            <div class="position-relative">
                <input type="text"
                    class="form-control form-control-sm rounded-pill ps-3 pe-5"
                    placeholder="Cari Tahun Ajaran..."
                    style="width:230px;">
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted">
                    🔍
                </span>
            </div>

            <a href="{{ route('bendahara.tahun_ajaran.create') }}"
                class="btn btn-primary">
                Tambah
            </a>

        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered text-center mb-0 align-middle">

                    <thead style="background:#F8F8F8;">
                        <tr style="font-size:12px;">
                            <th>No.</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th width="220">Aksi</th>
                        </tr>
                    </thead>

                    <tbody style="font-size:12px;">

                    @forelse($tahunAjarans as $index => $tahun)

                        <tr>

                            <td>{{ $index + 1 }}</td>

                            <td>{{ $tahun->nama }}</td>

                            <td>{{ $tahun->semester }}</td>

                            <td>{{ \Carbon\Carbon::parse($tahun->tanggal_mulai)->format('d-m-Y') }}</td>

                            <td>{{ \Carbon\Carbon::parse($tahun->tanggal_selesai)->format('d-m-Y') }}</td>

                            <td>

                                @if($tahun->is_aktif)

                                    <span class="badge bg-success">
                                        Aktif
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if(!$tahun->is_aktif)

                                <form
                                    action="{{ route('bendahara.tahun_ajaran.aktifkan',$tahun->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        class="btn btn-success btn-sm rounded-3">
                                        Aktifkan
                                    </button>

                                </form>

                                @endif

                                <a href="{{ route('bendahara.tahun_ajaran.edit',$tahun->id) }}"
                                    class="btn btn-warning btn-sm rounded-3">

                                    Edit

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-4">

                                Belum ada data Tahun Ajaran.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
@endsection