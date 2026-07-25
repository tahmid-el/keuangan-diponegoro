<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {

            if (!Schema::hasColumn('siswa', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'Perempuan'])
                    ->default('L')
                    ->after('telepon');
            }

            if (!Schema::hasColumn('siswa', 'orang_tua')) {
                $table->string('orang_tua')
                    ->nullable()
                    ->after('jenis_kelamin');
            }

        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {

            if (Schema::hasColumn('siswa', 'orang_tua')) {
                $table->dropColumn('orang_tua');
            }

            if (Schema::hasColumn('siswa', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }

        });
    }
};