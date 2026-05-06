@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    <!-- Header halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        
        <!-- Judul -->
        <div>
            <h3 class="fw-bold text-dark mb-0">Data Siswa</h3>
        </div>

        <!-- Right Actions -->
        <div class="d-flex align-items-center gap-3">
            <!-- Dropdown Tahun Ajaran -->
            <select class="form-select" style="width: 180px;">
                <option>2025/2026</option>
                <option>2024/2025</option>
                <option>2023/2024</option>
            </select>

            <!-- Tombol tambah -->
            <button 
                class="btn btn-primary px-4"
                data-bs-toggle="modal"
                data-bs-target="#tambahSiswaModal"
            >
                + Tambah Siswa
            </button>
        </div>
    </div>

    <!-- Card utama -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nomor Induk</th>
                            <th>Nama Siswa</th>
                            <th>Orang Tua</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>4981</td>
                            <td>Zaki Naufal Abdillah</td>
                            <td>Teguh Nurcahyono</td>
                            <td>L</td>
                            <td>DUSUN KRAJAN 1, RT/RW 011/002 </td>
                            <td>
                                <button class="btn btn-warning btn-sm">
                                    Edit
                                </button>

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>4981</td>
                            <td>Zaki Naufal Abdillah</td>
                            <td>Teguh Nurcahyono</td>
                            <td>L</td>
                            <td>DUSUN KRAJAN 1, RT/RW 011/002 </td>
                            <td>
                                <button class="btn btn-warning btn-sm">
                                    Edit
                                </button>

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link">1</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link">2</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="tambahSiswaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 35px;">

            <div class="modal-body p-4" 
                 style="background-color: #AFC4E8; border-radius: 30px;">

                <form>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-semibold mb-2">
                                No Induk
                            </label>
                            <input 
                                type="text"
                                class="form-control rounded-3"
                                placeholder="Nomor Induk Siswa"
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold mb-2">
                                Nama Siswa
                            </label>
                            <input 
                                type="text"
                                class="form-control rounded-3"
                                placeholder="Nama Lengkap"
                            >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold mb-2">
                            Alamat
                        </label>
                        <input 
                            type="text"
                            class="form-control rounded-3"
                            placeholder="Alamat Sesuai Kartu Keluarga"
                        >
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-semibold mb-2">
                                Jenis Kelamin
                            </label>

                            <select class="form-select rounded-3">
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold mb-2">
                                Orang Tua
                            </label>
                            <input 
                                type="text"
                                class="form-control rounded-3"
                                placeholder="Nama Orang Tua"
                            >
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button class="btn btn-light px-4 rounded-3">
                            Simpan
                        </button>

                        <button 
                            type="button"
                            class="btn btn-light px-4 rounded-3"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
