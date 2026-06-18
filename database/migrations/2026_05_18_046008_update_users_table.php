<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['bendahara', 'kepala_sekolah', 'siswa'])
                  ->default('siswa')
                  ->after('email');
            $table->foreignId('siswa_id')
                  ->nullable()
                  ->after('role')
                  ->constrained('siswa')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['role', 'siswa_id']);
        });
    }
};
