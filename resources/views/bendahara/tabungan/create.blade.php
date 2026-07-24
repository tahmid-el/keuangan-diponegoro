@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    <h5 class="fw-bold mb-4">Tambah Tabungan (Transaksi Pertama)</h5>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bendahara.tabungan.store') }}" method="POST">
                @csrf

                {{-- Nama Siswa --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Siswa
                    </label>

                    <select name="siswa_id" class="form-select" required>
                        <option value="">-- Pilih Siswa --</option>

                        @forelse($siswas as $siswa)
                            <option value="{{ $siswa->id }}">
                                {{ $siswa->nis }} - {{ $siswa->nama_siswa }}
                            </option>
                        @empty
                            <option disabled>
                                Semua siswa sudah memiliki tabungan
                            </option>
                        @endforelse
                    </select>
                </div>

                {{-- Tanggal --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ date('Y-m-d') }}"
                        required>
                </div>

                {{-- Nominal --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Setoran Awal
                    </label>

                    <input
                        type="number"
                        name="nominal"
                        class="form-control"
                        min="1000"
                        placeholder="Masukkan nominal"
                        required>
                </div>

                {{-- Keterangan --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Keterangan
                    </label>

                    <textarea
                        name="keterangan"
                        rows="3"
                        class="form-control"
                        placeholder="Opsional"></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('bendahara.tabungan.index') }}"
                       class="btn btn-secondary">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection