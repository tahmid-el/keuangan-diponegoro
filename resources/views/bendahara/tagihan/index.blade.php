@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-3">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 px-3">
        <h5 class="fw-bold mb-0">Data Tagihan</h5>

        <a href="{{ route('bendahara.tagihan.create') }}"
           class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            Tambah Tagihan
        </a>
    </div>

    <div class="card shadow-sm border-0 mx-3">
        <div class="card-body table-responsive p-0">

            <table class="table table-bordered table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Kelas</th>
                        <th>Jenis Pembayaran</th>
                        <th>Jenis Tagihan</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Nominal</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($tagihan as $index => $item)

                    <tr>

                        <td>
                            {{ $tagihan->firstItem() + $index }}
                        </td>

                        <td>
                            {{ $item->kelas->nama_kelas ?? '-' }}
                        </td>

                        <td>
                            {{ $item->jenisPembayaran->nama ?? '-' }}
                        </td>

                        <td>
                            {{ ucfirst($item->jenisTagihan->nama_tagihan ?? '-') }}
                        </td>

                        <td>
                            {{ $item->tahunAjaran->nama ?? '-' }}
                        </td>

                        <td>
                            {{ ucfirst($item->tahunAjaran->semester ?? '-') }}
                        </td>

                        <td class="text-end">
                            Rp {{ number_format($item->nominal,0,',','.') }}
                        </td>

                        <td>

                            <a href="{{ route('bendahara.tagihan.edit',$item->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form
                                action="{{ route('bendahara.tagihan.arsip',$item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('PATCH')

                                <button
                                    onclick="return confirm('Arsipkan tagihan ini?')"
                                    class="btn btn-danger btn-sm">

                                    <i class="bi bi-archive"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8">
                            Belum ada data tagihan.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        @if($tagihan->hasPages())
            <div class="card-footer">
                {{ $tagihan->links() }}
            </div>
        @endif

    </div>

</div>
@endsection