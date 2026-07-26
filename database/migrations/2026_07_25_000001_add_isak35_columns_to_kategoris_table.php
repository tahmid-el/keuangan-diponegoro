<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->string('kelompok_isak35')->nullable()->after('tipe');
            $table->enum('status_pembatasan_dana', ['Dengan Pembatasan', 'Tanpa Pembatasan'])
                ->default('Tanpa Pembatasan')
                ->after('kelompok_isak35');
            $table->boolean('is_aktif')->default(true)->after('status_pembatasan_dana');
        });
    }

    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropColumn(['kelompok_isak35', 'status_pembatasan_dana', 'is_aktif']);
        });
    }
};
