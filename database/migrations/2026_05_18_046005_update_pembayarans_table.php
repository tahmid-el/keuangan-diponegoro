<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreignId('siswa_id')->after('id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('tagihan_id')->after('siswa_id')->constrained('tagihans')->cascadeOnDelete();
            $table->foreignId('jenis_pembayaran_id')->after('tagihan_id')->constrained('jenis_pembayarans')->cascadeOnDelete();
            $table->foreignId('user_id')->after('jenis_pembayaran_id')->constrained('users')->cascadeOnDelete();
            $table->string('no_kwitansi', 30)->unique()->after('user_id');
            $table->date('tanggal_bayar')->after('no_kwitansi');
            $table->unsignedBigInteger('nominal')->after('tanggal_bayar');
            $table->string('periode', 20)->after('nominal');
            $table->enum('status', ['lunas','cicilan'])->default('lunas')->after('periode');
            $table->text('keterangan')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropForeign(['tagihan_id']);
            $table->dropForeign(['jenis_pembayaran_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['siswa_id','tagihan_id','jenis_pembayaran_id','user_id','no_kwitansi','tanggal_bayar','nominal','periode','status','keterangan']);
        });
    }
};
