<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->foreignId('siswa_id')->after('id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('jenis_pembayaran_id')->after('siswa_id')->constrained('jenis_pembayarans')->cascadeOnDelete();
            $table->enum('kategori', [
                'normal','subsidi_kurang_mampu','subsidi_saudara',
                'subsidi_yatim','subsidi_keluarga_guru','subsidi_prestasi',
            ])->default('normal')->after('jenis_pembayaran_id');
            $table->unsignedBigInteger('nominal_subsidi')->default(0)->after('kategori');
            $table->enum('status', ['belum_lunas','cicilan','lunas'])->default('belum_lunas')->after('nominal_subsidi');
            $table->year('periode')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropForeign(['jenis_pembayaran_id']);
            $table->dropColumn(['siswa_id','jenis_pembayaran_id','kategori','nominal_subsidi','status','periode']);
        });
    }
};
