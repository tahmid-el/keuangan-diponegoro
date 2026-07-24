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
        Schema::table('pemasukans', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemasukans', function (Blueprint $table) {
            $table->string('deskripsi')->nullable();
        });

        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->string('deskripsi')->nullable();
        });
    }
};
