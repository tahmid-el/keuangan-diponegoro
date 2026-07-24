@extends('layouts.app')

@section('content')

<div class="container">

    <h4 class="mb-3">Tambah Data Siswa Lama</h4>

    <div class="alert alert-info mb-4">
        <h6 class="fw-bold mb-2">
            Informasi
        </h6>

        <ul class="mb-0 ps-3">
            <li>Halaman ini digunakan untuk menambahkan siswa yang masuk ke angkatan yang sudah berjalan (siswa pindahan).</li>
            <li>Pilih kelas sesuai kelas yang akan ditempati siswa saat ini.</li>
            <li>Tahun masuk akan mengikuti tahun ajaran yang sedang aktif.</li>
        </ul>
    </div>

    <form action="{{ route('bendahara.siswa.simpan-lama') }}" method="POST">
        @csrf

        <table class="table table-bordered">
            <thead>
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

                    <td>
                        <input type="text" name="siswa[{{ $i }}][nis]" class="form-control">
                    </td>

                    <td>
                        <input type="text" name="siswa[{{ $i }}][nama_siswa]" class="form-control">
                    </td>

                    <td>
                        <select
                            name="siswa[{{ $i }}][kelas_id]"
                            class="form-select">

                            <option value="">Pilih Kelas</option>

                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach

                        </select>
                    </td>

                    <td>
                        <select name="siswa[{{ $i }}][jenis_kelamin]" class="form-select">
                            <option value="Laki-laki">L</option>
                            <option value="Perempuan">P</option>
                        </select>
                    </td>

                    <td>
                        <input type="text" name="siswa[{{ $i }}][orang_tua]" class="form-control">
                    </td>

                    <td>
                        <input type="text" name="siswa[{{ $i }}][telepon]" class="form-control">
                    </td>

                    <td>
                        <input type="text" name="siswa[{{ $i }}][alamat]" class="form-control">
                    </td> 
                    
                    <td>
                        <select
                            name="siswa[{{ $i }}][jenis_tagihan_id]"
                            class="form-select">

                            <option value="">Pilih</option>

                            @foreach($jenisTagihan as $jt)
                                <option value="{{ $jt->id }}">
                                    {{ $jt->nama_tagihan }}
                                </option>
                            @endforeach

                        </select>
                    </td>

                    <td>
                        <select
                            name="siswa[{{ $i }}][status]"
                            class="form-select">

                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>

                        </select>
                    </td>

                </tr>
                @endfor

            </tbody>
        </table>

        <div class="d-flex gap-2">

            <button type="submit"
                    class="btn btn-success">
                Simpan
            </button>

            <a href="{{ route('bendahara.siswa.index') }}"
                class="btn btn-secondary"
                onclick="return confirm('Apakah anda yakin ingin membatalkan?')">

                Batal

            </a>

        </div>

    </form>

</div>

@endsection