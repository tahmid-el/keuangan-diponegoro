<?php

namespace Database\Seeders;

use App\Models\Pemasukan;
use Illuminate\Database\Seeder;

class PemasukanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Juli 2025
            ['tanggal' => '2025-07-14', 'nominal' => 45000000, 'keterangan' => 'SPP Bulan Juli', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2025-07-14', 'nominal' => 5000000, 'keterangan' => 'Assessment Awal Tahun', 'kategori_id' => 2, 'user_id' => 1],
            ['tanggal' => '2025-07-20', 'nominal' => 3500000, 'keterangan' => 'Donasi dari Komite Sekolah', 'kategori_id' => 4, 'user_id' => 1],
            ['tanggal' => '2025-07-25', 'nominal' => 25000000, 'keterangan' => 'Dana BOS Tahap 1', 'kategori_id' => 3, 'user_id' => 1],

            // Agustus 2025
            ['tanggal' => '2025-08-12', 'nominal' => 45000000, 'keterangan' => 'SPP Bulan Agustus', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2025-08-18', 'nominal' => 1500000, 'keterangan' => 'Jasa Giro', 'kategori_id' => 5, 'user_id' => 1],

            // September 2025
            ['tanggal' => '2025-09-10', 'nominal' => 43000000, 'keterangan' => 'SPP Bulan September', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2025-09-15', 'nominal' => 2000000, 'keterangan' => 'Donasi Orang Tua Siswa', 'kategori_id' => 4, 'user_id' => 1],

            // Oktober 2025
            ['tanggal' => '2025-10-13', 'nominal' => 45000000, 'keterangan' => 'SPP Bulan Oktober', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2025-10-20', 'nominal' => 3000000, 'keterangan' => 'Assessment Tengah Semester', 'kategori_id' => 2, 'user_id' => 1],

            // November 2025
            ['tanggal' => '2025-11-12', 'nominal' => 44000000, 'keterangan' => 'SPP Bulan November', 'kategori_id' => 1, 'user_id' => 1],

            // Desember 2025
            ['tanggal' => '2025-12-10', 'nominal' => 45000000, 'keterangan' => 'SPP Bulan Desember', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2025-12-18', 'nominal' => 25000000, 'keterangan' => 'Dana BOS Tahap 2', 'kategori_id' => 3, 'user_id' => 1],

            // Januari 2026
            ['tanggal' => '2026-01-14', 'nominal' => 45000000, 'keterangan' => 'SPP Bulan Januari', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2026-01-25', 'nominal' => 1000000, 'keterangan' => 'Bunga Bank', 'kategori_id' => 5, 'user_id' => 1],

            // Februari 2026
            ['tanggal' => '2026-02-11', 'nominal' => 43000000, 'keterangan' => 'SPP Bulan Februari', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2026-02-20', 'nominal' => 3000000, 'keterangan' => 'Assessment Semester Genap', 'kategori_id' => 2, 'user_id' => 1],

            // Maret 2026
            ['tanggal' => '2026-03-11', 'nominal' => 45000000, 'keterangan' => 'SPP Bulan Maret', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2026-03-15', 'nominal' => 5000000, 'keterangan' => 'Donasi Umum', 'kategori_id' => 4, 'user_id' => 1],

            // April 2026
            ['tanggal' => '2026-04-15', 'nominal' => 44000000, 'keterangan' => 'SPP Bulan April', 'kategori_id' => 1, 'user_id' => 1],

            // Mei 2026
            ['tanggal' => '2026-05-13', 'nominal' => 45000000, 'keterangan' => 'SPP Bulan Mei', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2026-05-25', 'nominal' => 25000000, 'keterangan' => 'Dana BOS Tahap 3', 'kategori_id' => 3, 'user_id' => 1],

            // Juni 2026
            ['tanggal' => '2026-06-10', 'nominal' => 45000000, 'keterangan' => 'SPP Bulan Juni', 'kategori_id' => 1, 'user_id' => 1],
            ['tanggal' => '2026-06-18', 'nominal' => 2000000, 'keterangan' => 'Assessment Akhir Tahun', 'kategori_id' => 2, 'user_id' => 1],
        ];

        foreach ($data as $row) {
            Pemasukan::create($row);
        }
    }
}
