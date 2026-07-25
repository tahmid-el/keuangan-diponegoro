<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->foreignId('jenis_tagihan_id')
                ->after('status')
                ->nullable()
                ->constrained('jenis_tagihan')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['jenis_tagihan_id']);
            $table->dropColumn('jenis_tagihan_id');
        });
    }
};
