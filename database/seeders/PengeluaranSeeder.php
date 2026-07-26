<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Juli 2025
            ['tanggal' => '2025-07-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan Juli', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2025-07-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air Juli', 'kategori_id' => 6, 'user_id' => 1],
            ['tanggal' => '2025-07-30', 'nominal' => 1500000, 'keterangan' => 'Konsumsi Rapat Awal Tahun', 'kategori_id' => 9, 'user_id' => 1],

            // Agustus 2025
            ['tanggal' => '2025-08-10', 'nominal' => 2000000, 'keterangan' => 'Pembersihan Ruang Kelas', 'kategori_id' => 8, 'user_id' => 1],
            ['tanggal' => '2025-08-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan Agustus', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2025-08-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air Agustus', 'kategori_id' => 6, 'user_id' => 1],
            ['tanggal' => '2025-08-30', 'nominal' => 800000, 'keterangan' => 'Konsumsi Rapat', 'kategori_id' => 9, 'user_id' => 1],

            // September 2025
            ['tanggal' => '2025-09-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan September', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2025-09-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air September', 'kategori_id' => 6, 'user_id' => 1],
            ['tanggal' => '2025-09-30', 'nominal' => 500000, 'keterangan' => 'ATK Kantor', 'kategori_id' => 10, 'user_id' => 1],

            // Oktober 2025
            ['tanggal' => '2025-10-15', 'nominal' => 3500000, 'keterangan' => 'Perbaikan Meja & Kursi', 'kategori_id' => 8, 'user_id' => 1],
            ['tanggal' => '2025-10-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan Oktober', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2025-10-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air Oktober', 'kategori_id' => 6, 'user_id' => 1],

            // November 2025
            ['tanggal' => '2025-11-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan November', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2025-11-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air November', 'kategori_id' => 6, 'user_id' => 1],
            ['tanggal' => '2025-11-30', 'nominal' => 1200000, 'keterangan' => 'Konsumsi Kegiatan', 'kategori_id' => 9, 'user_id' => 1],

            // Desember 2025
            ['tanggal' => '2025-12-05', 'nominal' => 4000000, 'keterangan' => 'Pengecatan Gedung', 'kategori_id' => 8, 'user_id' => 1],
            ['tanggal' => '2025-12-20', 'nominal' => 18000000, 'keterangan' => 'Gaji Guru & Karyawan Desember + THR', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2025-12-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air Desember', 'kategori_id' => 6, 'user_id' => 1],
            ['tanggal' => '2025-12-30', 'nominal' => 2000000, 'keterangan' => 'Acara Perpisahan Semester', 'kategori_id' => 9, 'user_id' => 1],

            // Januari 2026
            ['tanggal' => '2026-01-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan Januari', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2026-01-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air Januari', 'kategori_id' => 6, 'user_id' => 1],
            ['tanggal' => '2026-01-30', 'nominal' => 700000, 'keterangan' => 'Konsumsi Rapat Awal Semester', 'kategori_id' => 9, 'user_id' => 1],

            // Februari 2026
            ['tanggal' => '2026-02-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan Februari', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2026-02-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air Februari', 'kategori_id' => 6, 'user_id' => 1],

            // Maret 2026
            ['tanggal' => '2026-03-10', 'nominal' => 2500000, 'keterangan' => 'Servis AC Ruang Guru', 'kategori_id' => 8, 'user_id' => 1],
            ['tanggal' => '2026-03-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan Maret', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2026-03-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air Maret', 'kategori_id' => 6, 'user_id' => 1],

            // April 2026
            ['tanggal' => '2026-04-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan April', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2026-04-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air April', 'kategori_id' => 6, 'user_id' => 1],
            ['tanggal' => '2026-04-30', 'nominal' => 1000000, 'keterangan' => 'Konsumsi Kegiatan', 'kategori_id' => 9, 'user_id' => 1],

            // Mei 2026
            ['tanggal' => '2026-05-15', 'nominal' => 3000000, 'keterangan' => 'Perbaikan Perlengkapan Lab', 'kategori_id' => 8, 'user_id' => 1],
            ['tanggal' => '2026-05-25', 'nominal' => 15000000, 'keterangan' => 'Gaji Guru & Karyawan Mei', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2026-05-28', 'nominal' => 3000000, 'keterangan' => 'Listrik & Air Mei', 'kategori_id' => 6, 'user_id' => 1],

            // Juni 2026
            ['tanggal' => '2026-06-20', 'nominal' => 17000000, 'keterangan' => 'Gaji Guru & Karyawan Juni', 'kategori_id' => 7, 'user_id' => 1],
            ['tanggal' => '2026-06-25', 'nominal' => 3500000, 'keterangan' => 'Listrik & Air Juni', 'kategori_id' => 6, 'user_id' => 1],
            ['tanggal' => '2026-06-28', 'nominal' => 2000000, 'keterangan' => 'Konsumsi Rapat Akhir Tahun', 'kategori_id' => 9, 'user_id' => 1],
            ['tanggal' => '2026-06-30', 'nominal' => 1000000, 'keterangan' => 'ATK & Perlengkapan', 'kategori_id' => 10, 'user_id' => 1],
        ];

        foreach ($data as $row) {
            Pengeluaran::create($row);
        }
    }
}
