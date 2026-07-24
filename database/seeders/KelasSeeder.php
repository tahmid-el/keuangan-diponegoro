<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelasData = [
            ['nama_kelas' => 'VII A', 'tingkat' => 7],
            ['nama_kelas' => 'VII B', 'tingkat' => 7],
            ['nama_kelas' => 'VII C', 'tingkat' => 7],
            ['nama_kelas' => 'VIII A', 'tingkat' => 8],
            ['nama_kelas' => 'VIII B', 'tingkat' => 8],
            ['nama_kelas' => 'VIII C', 'tingkat' => 8],
            ['nama_kelas' => 'IX A', 'tingkat' => 9],
            ['nama_kelas' => 'IX B', 'tingkat' => 9],
            ['nama_kelas' => 'IX C', 'tingkat' => 9],
        ];

        foreach ($kelasData as $kelas) {
            Kelas::create($kelas);
        }
    }
}
