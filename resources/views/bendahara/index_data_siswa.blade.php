@extends('layouts.app')

@section('content')
<div class="container-fluid py-3" style="background-color:#F5F2DD; min-height:100vh;">

    {{-- Notifikasi sukses/error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter & Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 px-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <h6 class="fw-bold mb-0">Data Siswa</h6>

            {{-- Form Filter --}}
            <form method="GET" action="{{ route('bendahara.siswa.index') }}" class="d-flex align-items-center gap-2 flex-wrap">

                {{-- Filter Tahun Ajaran --}}
                <select name="tahun_ajaran_id" class="form-select form-select-sm" style="width:120px;" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunAjarans as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id', $tahunAktif?->id) == $ta->id ? 'selected' : '' }}>
                            {{ $ta->nama }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Kelas --}}
                <select name="kelas_id" class="form-select form-select-sm" style="width:110px;" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Status --}}
                <select name="status" class="form-select form-select-sm" style="width:110px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="lulus"    {{ request('status') == 'lulus'    ? 'selected' : '' }}>Lulus</option>
                    <option value="pindah"   {{ request('status') == 'pindah'   ? 'selected' : '' }}>Pindah</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                </select>

                {{-- Pencarian --}}
                <input type="text" name="cari" class="form-control form-control-sm"
                       placeholder="Cari nama / NIS..." style="width:180px;"
                       value="{{ request('cari') }}">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search"></i>
                </button>
                <a href="{{ route('bendahara.siswa.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </form>

            {{-- Tombol Tambah --}}
            <div class="dropdown">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                        Tambah
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                            href="{{ route('bendahara.siswa.tambah-baru') }}">
                                <i class="bi bi-person-plus me-2"></i>
                                Angkatan Baru
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                            href="{{ route('bendahara.siswa.tambah-lama') }}">
                                <i class="bi bi-people me-2"></i>
                                Angkatan Lama (Naik Kelas)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Info jumlah --}}
        <small class="text-muted">Total: {{ $siswa->total() }} siswa</small>
    </div>

    {{-- Tabel --}}
    <div id="btn btn-primary" onclick="showFormTambah()">
        <div class="card border-0 shadow-sm rounded-3 mx-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center" style="font-size:12px;">
                        <thead style="background:#F8F8F8;">
                            <tr>
                                <th>No.</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Orang Tua</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $index => $s)
                            <tr>
                                <td>{{ $siswa->firstItem() + $index }}</td>
                                <td>{{ $s->nis }}</td>
                                <td class="text-start">{{ $s->nama_siswa }}</td>
                                <td>{{ $s->kelas?->nama_kelas ?? '-' }}</td>
                                <td>{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td class="text-start">{{ $s->nama_ortu ?? '-' }}</td>
                                <td>{{ $s->telepon ?? '-' }}</td>
                                <td>{!! $s->status_badge !!}</td>
                                <td>
                                    {{-- Edit --}}
                                    <a href="{{ route('bendahara.siswa.edit', $s) }}"
                                    class="btn btn-warning btn-sm mb-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Arsipkan --}}
                                    <button class="btn btn-secondary btn-sm mb-1"
                                            onclick="arsipSiswa({{ $s->id }}, '{{ $s->nama_siswa }}')">
                                        <i class="bi bi-archive"></i>
                                    </button>

                                    {{-- Hapus --}}
                                    <button class="btn btn-danger btn-sm mb-1"
                                            onclick="hapusSiswa({{ $s->id }}, '{{ $s->nama_siswa }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-muted py-4">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    Belum ada data siswa
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($siswa->hasPages())
                <div class="p-3">
                    {{ $siswa->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
    
</div>

{{-- Modal Arsipkan --}}
<div class="modal fade" id="modalArsip" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Arsipkan Siswa</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formArsip" method="POST">
                @csrf @method('PATCH')
                <div class="modal-body">
                    <p>Ubah status <strong id="namaArsip"></strong> menjadi:</p>
                    <select name="status" class="form-select">
                        <option value="lulus">Lulus</option>
                        <option value="pindah">Pindah</option>
                        <option value="nonaktif">Non-aktif</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-danger">Hapus Siswa</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus data <strong id="namaHapus"></strong>?</p>
                <p class="text-danger small"><i class="bi bi-exclamation-triangle me-1"></i>Data yang dihapus tidak bisa dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <form id="formHapus" method="POST">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function arsipSiswa(id, nama) {
    document.getElementById('namaArsip').textContent = nama;
    document.getElementById('formArsip').action = '/bendahara/siswa/' + id + '/arsip';
    new bootstrap.Modal(document.getElementById('modalArsip')).show();
}

function hapusSiswa(id, nama) {
    document.getElementById('namaHapus').textContent = nama;
    document.getElementById('formHapus').action = '/bendahara/siswa/' + id;
    new bootstrap.Modal(document.getElementById('modalHapus')).show();
}
</script>
@endsection