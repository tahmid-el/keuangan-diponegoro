<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'bendahara@diponegoro.sch.id'],
            [
                'name' => 'Bendahara',
                'password' => Hash::make('bendahara123'),
                'role' => 'bendahara',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kepsek@diponegoro.sch.id'],
            [
                'name' => 'Kepala Sekolah',
                'password' => Hash::make('kepsek123'),
                'role' => 'kepala_sekolah',
            ]
        );
    }
}
