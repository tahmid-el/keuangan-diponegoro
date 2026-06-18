<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tabungans', function (Blueprint $table) {
            $table->foreignId('siswa_id')->after('id')->unique()->constrained('siswa')->cascadeOnDelete();
            $table->unsignedBigInteger('saldo')->default(0)->after('siswa_id');
        });
    }

    public function down(): void
    {
        Schema::table('tabungans', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['siswa_id', 'saldo']);
        });
    }
};
