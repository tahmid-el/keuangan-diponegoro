<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\JenisPembayaran;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ──────────────────────────────────────────
        // 1. TAHUN AJARAN
        // ──────────────────────────────────────────
        $tahunAjaran = TahunAjaran::create([
            'nama'            => '2025/2026',
            'tanggal_mulai'   => '2025-07-14',
            'tanggal_selesai' => '2026-06-30',
            'is_aktif'        => true,
        ]);

        TahunAjaran::create([
            'nama'            => '2024/2025',
            'tanggal_mulai'   => '2024-07-15',
            'tanggal_selesai' => '2025-06-30',
            'is_aktif'        => false,
        ]);

        // ──────────────────────────────────────────
        // 2. KELAS (VII, VIII, IX)
        // ──────────────────────────────────────────
        $kelasData = [
            ['nama_kelas' => 'VII A',  'tingkat' => 7],
            ['nama_kelas' => 'VII B',  'tingkat' => 7],
            ['nama_kelas' => 'VII C',  'tingkat' => 7],
            ['nama_kelas' => 'VIII A', 'tingkat' => 8],
            ['nama_kelas' => 'VIII B', 'tingkat' => 8],
            ['nama_kelas' => 'VIII C', 'tingkat' => 8],
            ['nama_kelas' => 'IX A',   'tingkat' => 9],
            ['nama_kelas' => 'IX B',   'tingkat' => 9],
            ['nama_kelas' => 'IX C',   'tingkat' => 9],
        ];

        foreach ($kelasData as $kelas) {
            Kelas::create($kelas);
        }

        // ──────────────────────────────────────────
        // 3. JENIS PEMBAYARAN
        // ──────────────────────────────────────────
        $jenisData = [
            ['nama' => 'Biaya Pendidikan',    'deskripsi' => 'Biaya pendidikan tahunan'],
            ['nama' => 'Mid Semester Ganjil', 'deskripsi' => 'Ujian tengah semester ganjil'],
            ['nama' => 'Semester Ganjil',     'deskripsi' => 'Ujian akhir semester ganjil'],
            ['nama' => 'Mid Semester Genap',  'deskripsi' => 'Ujian tengah semester genap'],
            ['nama' => 'Semester Genap',      'deskripsi' => 'Ujian akhir semester genap'],
        ];

        foreach ($jenisData as $jenis) {
            JenisPembayaran::create($jenis);
        }

        // ──────────────────────────────────────────
        // 4. USER: BENDAHARA
        // ──────────────────────────────────────────
        User::create([
            'name'     => 'Bendahara',
            'email'    => 'bendahara@diponegoro.sch.id',
            'password' => Hash::make('bendahara123'),
            'role'     => 'bendahara',
        ]);

        // ──────────────────────────────────────────
        // 5. USER: KEPALA SEKOLAH
        // ──────────────────────────────────────────
        User::create([
            'name'     => 'Kepala Sekolah',
            'email'    => 'kepsek@diponegoro.sch.id',
            'password' => Hash::make('kepsek123'),
            'role'     => 'kepala_sekolah',
        ]);
    }
}
