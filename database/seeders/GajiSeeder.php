<?php

namespace Database\Seeders;

use App\Models\Gaji;
use Illuminate\Database\Seeder;

class GajiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gajis = [
            [
                'nama' => 'Ahmad Dahlan, S.Pd',
                'jumlah_jam' => 24,
                'bisyaroh' => 2400000,
                'tunjangan_kamad_wk' => 1000000,
                'tunjangan_piket' => 300000,
            ],
            [
                'nama' => 'Siti Aisyah, S.Pd.I',
                'jumlah_jam' => 20,
                'bisyaroh' => 2000000,
                'tunjangan_kamad_wk' => 500000,
                'tunjangan_piket' => 200000,
            ],
            [
                'nama' => 'Muhammad Ridwan, S.Kom',
                'jumlah_jam' => 18,
                'bisyaroh' => 1800000,
                'tunjangan_kamad_wk' => 0,
                'tunjangan_piket' => 200000,
            ],
            [
                'nama' => 'Fatimah Zahra, S.Pd',
                'jumlah_jam' => 22,
                'bisyaroh' => 2200000,
                'tunjangan_kamad_wk' => 500000,
                'tunjangan_piket' => 250000,
            ],
            [
                'nama' => 'Ali Imron, S.Pd',
                'jumlah_jam' => 16,
                'bisyaroh' => 1600000,
                'tunjangan_kamad_wk' => 0,
                'tunjangan_piket' => 150000,
            ],
            [
                'nama' => 'Khadijah, S.Pd.I',
                'jumlah_jam' => 20,
                'bisyaroh' => 2000000,
                'tunjangan_kamad_wk' => 0,
                'tunjangan_piket' => 200000,
            ],
            [
                'nama' => 'Umar Faruq, S.S',
                'jumlah_jam' => 12,
                'bisyaroh' => 1200000,
                'tunjangan_kamad_wk' => 0,
                'tunjangan_piket' => 100000,
            ],
        ];

        foreach ($gajis as $gaji) {
            Gaji::updateOrCreate(
                ['nama' => $gaji['nama']],
                $gaji
            );
        }
    }
}
