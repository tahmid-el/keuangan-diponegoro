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
        Schema::create('tagihans', function (Blueprint $table) {

            $table->id();

            // Nama tagihan
            $table->string('nama_tagihan');

            // Umum / Khusus
            $table->enum('jenis', [
                'Umum',
                'Khusus'
            ]);

            // Nominal tagihan
            $table->bigInteger('nominal');

            // Semester
            $table->enum('semester', [
                'Ganjil',
                'Genap'
            ]);

            // Tahun ajaran
            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajarans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Jenis subsidi (khusus)
            $table->string('kategori_subsidi')->nullable();

            // Status arsip
            $table->boolean('is_arsip')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
