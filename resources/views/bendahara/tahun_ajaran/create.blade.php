@extends('layouts.app')

@section('content')

<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">
                Tambah Tahun Ajaran
            </h5>
        </div>

        <div class="card-body">

            <form action="{{ route('bendahara.tahun_ajaran.store') }}" method="POST">

                @csrf

                <div class="row">

                    <!-- Nama Tahun Ajaran -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Tahun Ajaran
                        </label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control rounded-4 @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}"
                            placeholder="Contoh : 2026/2027"
                            required>

                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- Semester -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Semester
                        </label>

                        <select
                            name="semester"
                            class="form-select rounded-4 @error('semester') is-invalid @enderror"
                            required>

                            <option value="">-- Pilih Semester --</option>

                            <option value="Ganjil"
                                {{ old('semester')=='Ganjil' ? 'selected' : '' }}>
                                Ganjil
                            </option>

                            <option value="Genap"
                                {{ old('semester')=='Genap' ? 'selected' : '' }}>
                                Genap
                            </option>

                        </select>

                        @error('semester')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            class="form-control rounded-4 @error('tanggal_mulai') is-invalid @enderror"
                            value="{{ old('tanggal_mulai') }}"
                            required>

                        @error('tanggal_mulai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="tanggal_selesai"
                            class="form-control rounded-4 @error('tanggal_selesai') is-invalid @enderror"
                            value="{{ old('tanggal_selesai') }}"
                            required>

                        @error('tanggal_selesai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary rounded-4 px-4">

                        Simpan

                    </button>

                    <a
                        href="{{ route('bendahara.tahun_ajaran.index') }}"
                        class="btn btn-secondary rounded-4 px-4">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection