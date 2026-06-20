<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if(!Schema::hasColumn('siswa', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])
                      ->default('Laki-laki')
                      ->after('telepon');
    
                $table->string('nama_ortu')->nullable()->after('jenis_kelamin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'nama_ortu']);
        });
    }
};