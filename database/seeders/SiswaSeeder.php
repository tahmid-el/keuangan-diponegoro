<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // VII A
            ['nis' => '2025001', 'nama_siswa' => 'Ahmad Fauzi', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Budi Fauzi', 'tahun_masuk' => 2025, 'alamat' => 'Jl. Merdeka No. 1', 'telepon' => '081234567890', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 1, 'tahun_ajaran_id' => 1],
            ['nis' => '2025002', 'nama_siswa' => 'Siti Nurhaliza', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Ahmad Nur', 'tahun_masuk' => 2025, 'alamat' => 'Jl. Sudirman No. 5', 'telepon' => '081234567891', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 1, 'tahun_ajaran_id' => 1],
            ['nis' => '2025003', 'nama_siswa' => 'Rudi Hartono', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Slamet Hartono', 'tahun_masuk' => 2025, 'alamat' => 'Jl. Diponegoro No. 10', 'telepon' => '081234567892', 'status' => 'aktif', 'jenis_tagihan_id' => 2, 'kelas_id' => 1, 'tahun_ajaran_id' => 1],

            // VII B
            ['nis' => '2025004', 'nama_siswa' => 'Dewi Sartika', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Raden Sartika', 'tahun_masuk' => 2025, 'alamat' => 'Jl. Gatot Subroto No. 15', 'telepon' => '081234567893', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 2, 'tahun_ajaran_id' => 1],
            ['nis' => '2025005', 'nama_siswa' => 'Bambang Supriyadi', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Supriyadi', 'tahun_masuk' => 2025, 'alamat' => 'Jl. Pahlawan No. 20', 'telepon' => '081234567894', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 2, 'tahun_ajaran_id' => 1],
            ['nis' => '2025006', 'nama_siswa' => 'Ani Rahmawati', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Rahmawan', 'tahun_masuk' => 2025, 'alamat' => 'Jl. Veteran No. 8', 'telepon' => '081234567895', 'status' => 'aktif', 'jenis_tagihan_id' => 3, 'kelas_id' => 2, 'tahun_ajaran_id' => 1],

            // VII C
            ['nis' => '2025007', 'nama_siswa' => 'Citra Lestari', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Agus Lestari', 'tahun_masuk' => 2025, 'alamat' => 'Jl. Ahmad Yani No. 12', 'telepon' => '081234567896', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 3, 'tahun_ajaran_id' => 1],
            ['nis' => '2025008', 'nama_siswa' => 'Deni Kurniawan', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Kurnia', 'tahun_masuk' => 2025, 'alamat' => 'Jl. Siliwangi No. 25', 'telepon' => '081234567897', 'status' => 'aktif', 'jenis_tagihan_id' => 5, 'kelas_id' => 3, 'tahun_ajaran_id' => 1],

            // VIII A
            ['nis' => '2024001', 'nama_siswa' => 'Eko Prasetyo', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Prasetyo', 'tahun_masuk' => 2024, 'alamat' => 'Jl. Mawar No. 3', 'telepon' => '081234567898', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 4, 'tahun_ajaran_id' => 1],
            ['nis' => '2024002', 'nama_siswa' => 'Fitri Handayani', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Handoyo', 'tahun_masuk' => 2024, 'alamat' => 'Jl. Melati No. 7', 'telepon' => '081234567899', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 4, 'tahun_ajaran_id' => 1],
            ['nis' => '2024003', 'nama_siswa' => 'Gilang Ramadhan', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Ramadhan', 'tahun_masuk' => 2024, 'alamat' => 'Jl. Kenanga No. 14', 'telepon' => '081234567900', 'status' => 'aktif', 'jenis_tagihan_id' => 4, 'kelas_id' => 4, 'tahun_ajaran_id' => 1],

            // VIII B
            ['nis' => '2024004', 'nama_siswa' => 'Heni Purwanti', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Purwanto', 'tahun_masuk' => 2024, 'alamat' => 'Jl. Anggrek No. 9', 'telepon' => '081234567901', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 5, 'tahun_ajaran_id' => 1],
            ['nis' => '2024005', 'nama_siswa' => 'Indra Setiawan', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Setiawan', 'tahun_masuk' => 2024, 'alamat' => 'Jl. Tulip No. 11', 'telepon' => '081234567902', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 5, 'tahun_ajaran_id' => 1],

            // VIII C
            ['nis' => '2024006', 'nama_siswa' => 'Joko Sutrisno', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Sutrisno', 'tahun_masuk' => 2024, 'alamat' => 'Jl. Dahlia No. 6', 'telepon' => '081234567903', 'status' => 'aktif', 'jenis_tagihan_id' => 7, 'kelas_id' => 6, 'tahun_ajaran_id' => 1],
            ['nis' => '2024007', 'nama_siswa' => 'Kartika Sari', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Sari', 'tahun_masuk' => 2024, 'alamat' => 'Jl. Flamboyan No. 4', 'telepon' => '081234567904', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 6, 'tahun_ajaran_id' => 1],

            // IX A
            ['nis' => '2023001', 'nama_siswa' => 'Lukman Hakim', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Hakim', 'tahun_masuk' => 2023, 'alamat' => 'Jl. Cempaka No. 2', 'telepon' => '081234567905', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 7, 'tahun_ajaran_id' => 1],
            ['nis' => '2023002', 'nama_siswa' => 'Maya Anggraini', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Anggraini', 'tahun_masuk' => 2023, 'alamat' => 'Jl. Sakura No. 18', 'telepon' => '081234567906', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 7, 'tahun_ajaran_id' => 1],
            ['nis' => '2023003', 'nama_siswa' => 'Nugroho Wibowo', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Wibowo', 'tahun_masuk' => 2023, 'alamat' => 'Jl. Kamboja No. 22', 'telepon' => '081234567907', 'status' => 'aktif', 'jenis_tagihan_id' => 6, 'kelas_id' => 7, 'tahun_ajaran_id' => 1],

            // IX B
            ['nis' => '2023004', 'nama_siswa' => 'Oktavia Dewi', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Dewanto', 'tahun_masuk' => 2023, 'alamat' => 'Jl. Bougenville No. 13', 'telepon' => '081234567908', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 8, 'tahun_ajaran_id' => 1],
            ['nis' => '2023005', 'nama_siswa' => 'Panggih Santoso', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Santoso', 'tahun_masuk' => 2023, 'alamat' => 'Jl. Teratai No. 17', 'telepon' => '081234567909', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 8, 'tahun_ajaran_id' => 1],

            // IX C
            ['nis' => '2023006', 'nama_siswa' => 'Ratna Kusuma', 'jenis_kelamin' => 'Perempuan', 'orang_tua' => 'Kusuma', 'tahun_masuk' => 2023, 'alamat' => 'Jl. Seruni No. 21', 'telepon' => '081234567910', 'status' => 'aktif', 'jenis_tagihan_id' => 1, 'kelas_id' => 9, 'tahun_ajaran_id' => 1],
            ['nis' => '2023007', 'nama_siswa' => 'Septian Adi', 'jenis_kelamin' => 'Laki-laki', 'orang_tua' => 'Adi', 'tahun_masuk' => 2023, 'alamat' => 'Jl. Wijaya No. 19', 'telepon' => '081234567911', 'status' => 'aktif', 'jenis_tagihan_id' => 2, 'kelas_id' => 9, 'tahun_ajaran_id' => 1],
        ];

        foreach ($data as $row) {
            Siswa::create($row);
        }
    }
}
