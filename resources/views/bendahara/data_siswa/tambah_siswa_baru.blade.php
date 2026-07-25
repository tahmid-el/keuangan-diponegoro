@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <h5 class="fw-bold mb-0">Tambah Data Siswa Baru</h5>
    <a href="{{ route('bendahara.siswa.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    <form action="{{ route('bendahara.siswa.simpan-baru') }}" method="POST">
        @csrf

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>Orang Tua</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Jenis Tagihan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><input type="text" name="siswa[{{ $i }}][nis]" class="form-control"></td>
                        <td><input type="text" name="siswa[{{ $i }}][nama_siswa]" class="form-control"></td>
                        <td>
                            <select name="siswa[{{ $i }}][kelas_id]" class="form-select">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="siswa[{{ $i }}][jenis_kelamin]" class="form-select">
                                <option value="Laki-laki">L</option>
                                <option value="Perempuan">P</option>
                            </select>
                        </td>
                        <td><input type="text" name="siswa[{{ $i }}][orang_tua]" class="form-control"></td>
                        <td><input type="text" name="siswa[{{ $i }}][telepon]" class="form-control"></td>
                        <td><input type="text" name="siswa[{{ $i }}][alamat]" class="form-control"></td>
                        <td>
                            <select name="siswa[{{ $i }}][jenis_tagihan_id]" class="form-select">
                                <option value="">Pilih</option>
                                @foreach($jenisTagihan as $jt)
                                    <option value="{{ $jt->id }}">{{ $jt->nama_tagihan }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="siswa[{{ $i }}][status]" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-custom-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
            <a href="{{ route('bendahara.siswa.index') }}" class="btn btn-secondary px-4"
                onclick="return confirm('Apakah anda yakin ingin membatalkan?')">Batal</a>
        </div>
    </form>
</div>
@endsection
