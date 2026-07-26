<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ==========================
            // PEMASUKAN
            // ==========================
            [
                'nama' => 'Pembayaran Siswa',
                'tipe' => 'pemasukan',
                'kelompok_isak35' => 'Pendapatan',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],
            [
                'nama' => 'Assessment',
                'tipe' => 'pemasukan',
                'kelompok_isak35' => 'Pendapatan',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],
            [
                'nama' => 'Dana BOS',
                'tipe' => 'pemasukan',
                'kelompok_isak35' => 'Pendapatan',
                'status_pembatasan_dana' => 'Dengan Pembatasan'
            ],
            [
                'nama' => 'Donasi',
                'tipe' => 'pemasukan',
                'kelompok_isak35' => 'Pendapatan',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],
            [
                'nama' => 'Lainnya',
                'tipe' => 'pemasukan',
                'kelompok_isak35' => 'Pendapatan',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],

            // ==========================
            // PENGELUARAN
            // ==========================
            [
                'nama' => 'Operasional',
                'tipe' => 'pengeluaran',
                'kelompok_isak35' => 'Beban Operasional',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],
            [
                'nama' => 'Gaji & Honor',
                'tipe' => 'pengeluaran',
                'kelompok_isak35' => 'Beban Pendidikan',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],
            [
                'nama' => 'Pemeliharaan',
                'tipe' => 'pengeluaran',
                'kelompok_isak35' => 'Beban Pemeliharaan',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],
            [
                'nama' => 'Konsumsi',
                'tipe' => 'pengeluaran',
                'kelompok_isak35' => 'Beban Operasional',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],
            [
                'nama' => 'Lainnya',
                'tipe' => 'pengeluaran',
                'kelompok_isak35' => 'Beban Lainnya',
                'status_pembatasan_dana' => 'Tanpa Pembatasan'
            ],
        ];

        foreach ($data as $row) {
            Kategori::updateOrCreate(
                [
                    'nama' => $row['nama'],
                    'tipe' => $row['tipe'],
                ],
                $row
            );
        }
    }
}