<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriPemasukan = [
            'Pembayaran Siswa',
            'Assessment',
            'Dana BOS',
            'Donasi',
            'Lainnya',
        ];

        foreach ($kategoriPemasukan as $nama) {
            Kategori::create([
                'nama' => $nama,
                'tipe' => 'pemasukan',
            ]);
        }

        $kategoriPengeluaran = [
            'Operasional',
            'Gaji & Honor',
            'Pemeliharaan',
            'Konsumsi',
            'Lainnya',
        ];

        foreach ($kategoriPengeluaran as $nama) {
            Kategori::create([
                'nama' => $nama,
                'tipe' => 'pengeluaran',
            ]);
        }
    }
}
