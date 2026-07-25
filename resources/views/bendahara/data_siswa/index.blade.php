@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div class="w-full mb-4 d-flex flex-wrap align-items-center justify-between">
        <div>
            <h2 class="fw-bold text-dark mb-0">Data Siswa</h2>
            <p class="text-muted mb-0">Kelola data siswa, tahun ajaran, dan status</p>
        </div>
       <div class="dropdown ms-2" id="tambahSiswaDropdown"
            style="position: relative; display: inline-block;">

            <button class="btn btn-custom-primary dropdown-toggle shadow-sm text-nowrap"
                    type="button"
                    onclick="toggleDropdown()"
                    style="padding: 0.5rem 1.25rem;">
                <i class="bi bi-plus-circle me-1"></i> Tambah
            </button>

            <ul id="tambahMenu"
                class="dropdown-menu border-0 shadow-sm rounded-3"
                style="
                    display:none;
                    position:absolute;
                    top:calc(100% + 2px);
                    right:0;
                    min-width:100%;
                    z-index:1000;
                ">
                <li><a class="dropdown-item py-2" href="{{ route('bendahara.siswa.tambah-baru') }}">
                    <i class="bi bi-person-plus me-2 text-primary"></i>Angkatan Baru
                </a></li>
                <li><a class="dropdown-item py-2" href="{{ route('bendahara.siswa.tambah-lama') }}">
                    <i class="bi bi-people me-2 text-success"></i>Angkatan Lama (Naik Kelas)
                </a></li>
            </ul>
        </div>
        <script>
        function toggleDropdown() {
            var menu = document.getElementById('tambahMenu');
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        }
        document.addEventListener('click', function(e) {
            var container = document.getElementById('tambahSiswaDropdown');
            if (!container.contains(e.target)) {
                document.getElementById('tambahMenu').style.display = 'none';
            }
        });
        </script>
    </div>
    
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <form method="GET" action="{{ route('bendahara.siswa.index') }}" class="d-flex flex-wrap align-items-center gap-2">
            <div class="d-flex align-items-center gap-2 bg-white rounded-4 shadow-sm px-2 py-1" style="border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(10px);">
                <select name="tahun_ajaran_id" class="form-select border-0 bg-transparent py-1 ps-2 pe-4" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunAjarans as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id', $tahunAktif?->id) == $ta->id ? 'selected' : '' }}>{{ $ta->nama }}</option>
                    @endforeach
                </select>
                <div class="vr mx-1"></div>
                <select name="kelas_id" class="form-select border-0 bg-transparent py-1 ps-2 pe-4" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="vr mx-1"></div>
                <select name="status" class="form-select border-0 bg-transparent py-1 ps-2 pe-4" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <div class="vr mx-1"></div>
                <input type="text" name="cari" class="form-control border-0 bg-transparent p-1" placeholder="Cari nama / NIS..." style="max-width: 150px;" value="{{ request('cari') }}">
            </div>
            
            <button type="submit" class="btn btn-primary text-white fw-medium rounded-pill shadow-sm px-3 d-flex align-items-center gap-2" style="height: 40px; border: 1px solid rgba(255,255,255,0.4);">
                <i class="bi bi-search"></i>
            </button>
            @if(request('cari') || request('kelas_id') || request('status') || request('tahun_ajaran_id'))
                <a href="{{ route('bendahara.siswa.index') }}" class="btn btn-danger text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center transition" style="width:40px; height:40px; border: 1px solid rgba(255,255,255,0.4);" title="Reset Filter">
                    <i class="bi bi-x-lg" style="font-size: 14px; font-weight: bold;"></i>
                </a>
            @endif
        </form>
    </div>
</div>

<div class="mb-3">
    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 rounded-pill">Total: {{ $siswa->total() }} siswa</span>
</div>

    {{-- Tabel --}}
    <div class="glass-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start" width="40"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                        <th class="border-0">No.</th>
                        <th class="border-0">NIS</th>
                        <th class="border-0 text-start">Nama Siswa</th>
                        <th class="border-0">Kelas</th>
                        <th class="border-0">Jenis Kelamin</th>
                        <th class="border-0">Telepon</th>
                        <th class="border-0">Status</th>
                        <th class="border-0 rounded-end">Aksi</th>
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
                                <td>{{ $s->telepon ?? '-' }}</td>
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
    </div> <!-- /glass-card -->

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