<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tahun_ajarans', function (Blueprint $table) {
            $table->string('nama', 20)->after('id');
            $table->date('tanggal_mulai')->after('nama');
            $table->date('tanggal_selesai')->after('tanggal_mulai');
            $table->boolean('is_aktif')->default(false)->after('tanggal_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('tahun_ajarans', function (Blueprint $table) {
            $table->dropColumn(['nama', 'tanggal_mulai', 'tanggal_selesai', 'is_aktif']);
        });
    }
};
