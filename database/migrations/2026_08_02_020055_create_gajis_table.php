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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedInteger('jumlah_jam')->default(0);
            $table->decimal('bisyaroh', 15, 2)->default(0);
            $table->decimal('tunjangan_kamad_wk', 15, 2)->default(0);
            $table->decimal('tunjangan_piket', 15, 2)->default(0);
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
