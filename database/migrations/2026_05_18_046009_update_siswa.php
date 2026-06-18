<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table){
            $table->foreign('kelas_id')
            ->references('id')
            ->on('kelas')
            ->cascadeOnDelete();

            $table->foreign('tahun_ajaran_id')
            ->references('id')
            ->on('tahun_ajarans')
            ->cascadeOnDelete();
        });
    }

    public function down():void
    {
        Schema::table('siswa', function (Blueprint $table){
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['tahun_ajaran_id']);
        });
    }
};

