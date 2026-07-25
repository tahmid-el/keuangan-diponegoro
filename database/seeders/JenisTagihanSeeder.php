<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisTagihan;

class JenisTagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisData = [
            ['nama_tagihan' => 'Normal'],
            ['nama_tagihan' => 'Subsidi Kurang Mampu'],
            ['nama_tagihan' => 'Subsidi Saudara Kelas Sama'],
            ['nama_tagihan' => 'Subsidi Saudara Beda Kelas'],
            ['nama_tagihan' => 'Subsidi Prestasi'],
            ['nama_tagihan' => 'Subsidi Keluarga Guru'],
            ['nama_tagihan' => 'Subsidi Yatim'],
            ['nama_tagihan' => 'Semua'],
        ];

        foreach ($jenisData as $jenis) {
            JenisTagihan::create($jenis);
        }
    }
}