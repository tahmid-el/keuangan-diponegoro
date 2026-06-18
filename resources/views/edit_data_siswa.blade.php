@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    <div class="d-flex align-items-center gap-3 mb-4 px-3">
        <h6 class="fw-bold mb-0">Edit Data Siswa</h6>
        <a href="{{ route('bendahara.siswa.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mx-3">
        <div class="card-body p-4">
            <form action="{{ route('bendahara.siswa.update', $siswa) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- NIS --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">NIS <span class="text-danger">*</span></label>
                        <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                               value="{{ old('nis', $siswa->nis) }}" required>
                        @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Nama Siswa --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror"
                               value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
                        @error('nama_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Orang Tua --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nama Orang Tua</label>
                        <input type="text" name="orang_tua" class="form-control @error('orang_tua') is-invalid @enderror"
                               value="{{ old('orang_tua', $siswa->orang_tua) }}">
                        @error('orang_tua') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Telepon</label>
                        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                               value="{{ old('telepon', $siswa->telepon) }}">
                        @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
                        <select name="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Tahun Ajaran --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select name="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror" required>
                            @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $siswa->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="aktif"    {{ old('status', $siswa->status) == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus"    {{ old('status', $siswa->status) == 'lulus'    ? 'selected' : '' }}>Lulus</option>
                            <option value="pindah"   {{ old('status', $siswa->status) == 'pindah'   ? 'selected' : '' }}>Pindah</option>
                            <option value="nonaktif" {{ old('status', $siswa->status) == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('bendahara.siswa.index') }}" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection