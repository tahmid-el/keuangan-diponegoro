<?php

namespace Database\Seeders;

use App\Models\JenisPembayaran;
use Illuminate\Database\Seeder;

class JenisPembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $jenisData = [
            ['nama' => 'Biaya Pendidikan', 'deskripsi' => 'Biaya pendidikan tahunan'],
            ['nama' => 'Mid Semester Ganjil', 'deskripsi' => 'Ujian tengah semester ganjil'],
            ['nama' => 'Semester Ganjil', 'deskripsi' => 'Ujian akhir semester ganjil'],
            ['nama' => 'Mid Semester Genap', 'deskripsi' => 'Ujian tengah semester genap'],
            ['nama' => 'Semester Genap', 'deskripsi' => 'Ujian akhir semester genap'],
        ];

        foreach ($jenisData as $jenis) {
            JenisPembayaran::create($jenis);
        }
    }
}
