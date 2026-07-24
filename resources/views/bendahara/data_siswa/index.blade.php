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
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
            <div>
                <div>
                    <button class="btn btn-primary dropdown-toggle"
                            type="button">
                        Tambah
                    </button>

                    <ul>
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
    <div>
        <div class="card border-0 shadow-sm rounded-3 mx-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center" style="font-size:12px;">
                        <thead style="background:#F8F8F8;">
                            <tr>
                                <th width="40"><input type="checkbox" id="checkAll"></th>
                                <th>No.</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Orang Tua</th>
                                <th>Telepon</th>
                                <th>Jenis Tagihan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $index => $s)
                            <tr>
                                <td><input type="checkbox" class="check-item" name="siswa_ids[]" value="{{ $s->id }}"></td>
                                <td>{{ $siswa->firstItem() + $index }}</td>
                                <td>{{ $s->nis }}</td>
                                <td class="text-start">{{ $s->nama_siswa }}</td>
                                <td>{{ $s->kelas?->nama_kelas ?? '-' }}</td>
                                <td>{{ $s->jenis_kelamin ?? '-'}}</td>
                                <td class="text-start">{{ $s->orang_tua ?? '-' }}</td>
                                <td>{{ $s->telepon ?? '-' }}</td>
                                <td>{{ $s->jenisTagihan?->nama_tagihan ?? '-' }}</td>
                                <td>

                                @if($s->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>

                                @elseif($s->status == 'lulus')
                                    <span class="badge bg-primary">Lulus</span>

                                @elseif($s->status == 'pindah')
                                    <span class="badge bg-warning text-dark">Pindah</span>

                                @elseif($s->status == 'nonaktif')
                                    <span class="badge bg-danger">Non Aktif</span>

                                @else
                                    <span class="badge bg-secondary">
                                        {{ $s->status }}
                                    </span>
                                @endif

                                </td>
                                <td>

                                    {{-- Edit --}}
                                    <a href="{{ route('bendahara.siswa.edit', $s) }}"
                                        class="btn btn-warning btn-sm mb-1">
                                         <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Arsipkan --}}
                                    <button type="button"
                                            class="btn btn-secondary btn-sm mb-1"
                                            onclick="arsipSiswa({{ $s->id }}, '{{ $s->nama_siswa }}')">
                                        <i class="bi bi-archive"></i>
                                    </button>

                                    {{-- Form Arsip --}}
                                    <form id="arsip-{{ $s->id }}"
                                        action="{{ route('bendahara.siswa.arsip', $s->id) }}"
                                        method="POST"
                                        style="display:none">
                                        @csrf
                                        @method('PATCH')
                                    </form>

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

                    <div class="card shadow"
                        style="
                            display:none;
                            position:fixed;
                            right:25px;
                            bottom:25px;
                            width:320px;
                            z-index:999;
                        ">

                        {{-- Modal Arsipkan --}}
<div class="modal fade" id="modalArsip" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="floatingNaikKelas" class="card shadow position-fixed p-3" style="display:none;bottom:20px;right:20px;z-index:1055;min-width:320px;">
                <form id="formNaikKelas" action="{{ route('bendahara.siswa.naik-kelas') }}" method="POST">
                @csrf
                    <div class="fw-bold mb-2" id="jumlahDipilih">0 siswa dipilih</div>
                        <div class="mb-2">
                            <label class="form-label">Kelas Tujuan</label>
                            <select name="kelas_tujuan" class="form-select">
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->tingkat.' '.$k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                        <button class="btn btn-success" type="submit">Naikkan Kelas</button>
                        <button class="btn btn-secondary" type="button" onclick="document.getElementById('floatingNaikKelas').style.display='none'">Batal</button>
                    </div>
                </form>
            </div>

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
                        <option value="nonaktif">Non Aktif</option>
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


<script>
function arsipSiswa(id, nama)
{
    document.getElementById('namaArsip').innerText = nama;

    document.getElementById('formArsip').action =
        '/bendahara/siswa/' + id + '/arsip'; 

    new bootstrap.Modal(document.getElementById('modalArsip')).show();
}


</script>

    @push('scripts')
    <script>

    const checkAll = document.getElementById('checkAll');
    const checkItems = document.querySelectorAll('.check-item');

    const floating = document.getElementById('floatingNaikKelas');
    const jumlahDipilih = document.getElementById('jumlahDipilih');

    function updateFloatingPanel() {

        const checked = document.querySelectorAll('.check-item:checked');

        if (checked.length > 0) {

            floating.style.display = 'block';
            jumlahDipilih.innerText = checked.length + ' siswa dipilih';

        } else {

            floating.style.display = 'none';

        }

    }

    checkAll.addEventListener('change', function () {

        checkItems.forEach(function(item){

            item.checked = checkAll.checked;

        });

        updateFloatingPanel();

    });

    checkItems.forEach(function(item){

        item.addEventListener('change', function(){

            checkAll.checked =
                document.querySelectorAll('.check-item:checked').length
                === checkItems.length;

            updateFloatingPanel();

        });

    });

    </script>
    @endpush
@endsection