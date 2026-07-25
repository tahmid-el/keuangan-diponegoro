<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tagihan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('jenis_tagihan');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
