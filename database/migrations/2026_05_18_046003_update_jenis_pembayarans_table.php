<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_pembayarans', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->text('deskripsi')->nullable()->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_pembayarans', function (Blueprint $table) {
            $table->dropColumn(['nama', 'deskripsi']);
        });
    }
};
