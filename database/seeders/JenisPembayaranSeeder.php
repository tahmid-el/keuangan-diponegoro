<?php

namespace Database\Seeders;

use App\Models\JenisPembayaran;
use Illuminate\Database\Seeder;

class JenisPembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $jenisData = [
            ['nama' => 'BP', 'deskripsi' => 'Biaya pendidikan tahunan'],
            ['nama' => 'MID GANJIL', 'deskripsi' => 'Ujian tengah semester ganjil'],
            ['nama' => 'TAB REKREASI 1', 'deskripsi' => 'Biaya untuk tabungan rekreasi tahap 1'],
            ['nama' => 'SEM GANJIL', 'deskripsi' => 'Ujian akhir semester ganjil'],
            ['nama' => 'TAB REKREASI 2', 'deskripsi' => 'Biaya untuk tabungan rekreasi tahap 2'],
            ['nama' => 'HUT MTSD', 'deskripsi' => 'Biaya untuk peringatan HUT MTSD'],
            ['nama' => 'MID GENAP', 'deskripsi' => 'Ujian tengah semester genap'],
            ['nama' => 'TAB REKREASI 3', 'deskripsi' => 'Biaya untuk tabungan rekreasi tahap 3'],
            ['nama' => 'KALENDER', 'deskripsi' => 'Biaya untuk pembelian kalender'],
            ['nama' => 'SEM GENAP', 'deskripsi' => 'Ujian akhir semester genap'],
            ['nama' => 'TAB REKREASI 4', 'deskripsi' => 'Biaya untuk tabungan rekreasi tahap 4'],
        ];

        foreach ($jenisData as $jenis) {
            JenisPembayaran::create($jenis);
        }
    }
}
