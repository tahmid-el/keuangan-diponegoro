<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@diponegoro.sch.id',
            'password' => Hash::make('bendahara123'),
            'role' => 'bendahara',
        ]);

        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@diponegoro.sch.id',
            'password' => Hash::make('kepsek123'),
            'role' => 'kepala_sekolah',
        ]);
    }
}
