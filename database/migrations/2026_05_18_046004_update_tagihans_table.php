<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            if (!Schema::hasColumn('tagihans', 'kelas_id')) {
                $table->foreignId('kelas_id')
                    ->after('id')
                    ->constrained('kelas')
                    ->cascadeOnDelete();
            }
            if (!Schema::hasColumn('tagihans', 'jenis_tagihan_id')) {
                $table->foreignId('jenis_tagihan_id')
                    ->after('tahun_ajaran_id')
                    ->constrained('jenis_tagihan')
                    ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            if (Schema::hasColumn('tagihans', 'kelas_id')) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            }
            if (Schema::hasColumn('tagihans', 'jenis_tagihan_id')) {
                $table->dropForeign(['jenis_tagihan_id']);
                $table->dropColumn('jenis_tagihan_id');
            }
        });
    }
};
