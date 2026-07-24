@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Setor Tabungan</h3>

    <form action="{{ route('bendahara.tabungan.storeSetor') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Siswa</label>

            <select name="siswa_id" class="form-select" required>
                <option value="">-- Pilih Siswa --</option>

                @foreach($siswas as $siswa)
                    <option value="{{ $siswa->id }}">
                        {{ $siswa->nis }} - {{ $siswa->nama_siswa }}
                        (Saldo : Rp {{ number_format($siswa->tabungan->saldo,0,',','.') }})
                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>

            <input
                type="date"
                name="tanggal"
                class="form-control"
                value="{{ date('Y-m-d') }}"
                required>
        </div>

        <div class="mb-3">
            <label>Nominal Setor</label>

            <input
                type="number"
                name="nominal"
                class="form-control"
                min="1000"
                required>
        </div>

        <button class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('bendahara.tabungan.index') }}"
            class="btn btn-secondary">
            Batal
        </a>

    </form>

</div>
@endsection