<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mutasi_tabungans', function (Blueprint $table) {
            $table->foreignId('tabungan_id')->after('id')->constrained('tabungans')->cascadeOnDelete();
            $table->foreignId('user_id')->after('tabungan_id')->constrained('users')->cascadeOnDelete();
            $table->enum('jenis', ['setor','tarik'])->after('user_id');
            $table->unsignedBigInteger('nominal')->after('jenis');
            $table->unsignedBigInteger('saldo_akhir')->after('nominal');
            $table->date('tanggal')->after('saldo_akhir');
            $table->text('keterangan')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('mutasi_tabungans', function (Blueprint $table) {
            $table->dropForeign(['tabungan_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['tabungan_id','user_id','jenis','nominal','saldo_akhir','tanggal','keterangan']);
        });
    }
};
