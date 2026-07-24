@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#9DB2D8; min-height:100vh;">

    <div class="mx-auto" style="max-width:750px;">

        <form action="{{ route('bendahara.pembayaran.simpan') }}" method="POST">
            @csrf

            <div class="row g-4">

                <!-- No Induk -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        No Induk
                    </label>

                    <select
                        name="siswa_id"
                        id="siswa_id"
                        class="form-select rounded-4"
                        required>

                        <option value="">
                            -- Pilih Siswa --
                        </option>

                        @foreach($siswa as $item)

                            <option value="{{ $item->id }}">
                                {{ $item->nis }} - {{ $item->nama_siswa }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- No Kwitansi -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        No Kwitansi
                    </label>

                    <input
                        type="text"
                        name="no_kwitansi"
                        class="form-control rounded-4"
                        placeholder="Masukkan nomor kwitansi"
                        required>

                </div>

                <!-- Nama -->
                <div class="col-md-12">

                    <label class="form-label fw-semibold">
                        Nama Siswa
                    </label>

                    <input
                        type="text"
                        id="nama_siswa"
                        class="form-control rounded-4"
                        readonly>

                </div>

                <!-- Tanggal Bayar -->
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Tanggal Bayar
                    </label>

                    <input
                        type="date"
                        name="tanggal_bayar"
                        class="form-control rounded-4"
                        value="{{ date('Y-m-d') }}"
                        required>

                </div>

                <!-- Periode -->
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Periode Pembayaran
                    </label>

                    <select
                        name="tahun_ajaran_id"
                        id="tahun_ajaran_id"
                        class="form-select rounded-4"
                        required>

                        <option value="">Pilih Periode</option>

                        @foreach($tahunAjaran as $tahun)

                            <option
                                value="{{ $tahun->id }}"
                                data-nama="{{ $tahun->nama }}">

                                {{ $tahun->nama }} - {{ $tahun->semester }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Jenis Pembayaran -->
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Jenis Pembayaran
                    </label>

                    <select
                        name="jenis_pembayaran_id"
                        id="jenis_pembayaran_id"
                        class="form-select rounded-4"
                        required>

                        <option value="">
                            Pilih Jenis Pembayaran
                        </option>

                        @foreach($jenisPembayaran as $jenis)

                            <option value="{{ $jenis->id }}">
                                {{ $jenis->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Nominal -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Nominal Pembayaran
                    </label>

                    <input
                        type="number"
                        name="nominal"
                        class="form-control rounded-4"
                        placeholder="Masukkan nominal pembayaran"
                        required>

                </div>

            </div>

            <div class="mt-5 d-flex gap-3">

                <button
                    type="submit"
                    class="btn btn-success px-5 rounded-4">

                    Simpan

                </button>

                <a
                    href="{{ route('bendahara.pembayaran.index') }}"
                    class="btn btn-secondary px-5 rounded-4">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>
@endsection

@push('scripts')

<script>

const siswa = @json($siswa);

document.getElementById('siswa_id').addEventListener('change', function(){

    let id = this.value;

    let data = siswa.find(item => item.id == id);

    document.getElementById('nama_siswa').value=
        data ? data.nama_siswa : '';

});


document.getElementById('tahun_ajaran_id').addEventListener('change',function(){

    let nama=this.options[this.selectedIndex].dataset.nama;

    document.getElementById('periode').value=nama;

});

</script>

@endpush