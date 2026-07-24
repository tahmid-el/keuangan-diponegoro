<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Kategori;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemasukans', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('keterangan')->constrained('kategoris')->cascadeOnDelete();
        });

        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('keterangan')->constrained('kategoris')->cascadeOnDelete();
        });

        $this->migrateExistingData();

        Schema::table('pemasukans', function (Blueprint $table) {
            $table->dropColumn('sumber_dana');
            $table->foreignId('kategori_id')->nullable(false)->change();
        });

        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->dropColumn('jenis_pengeluaran');
            $table->foreignId('kategori_id')->nullable(false)->change();
        });
    }

    private function migrateExistingData(): void
    {
        $pemasukans = Pemasukan::whereNotNull('sumber_dana')->get();
        foreach ($pemasukans as $pemasukan) {
            $kategori = Kategori::firstOrCreate(
                ['nama' => $pemasukan->sumber_dana, 'tipe' => 'pemasukan']
            );
            $pemasukan->update(['kategori_id' => $kategori->id]);
        }

        $pengeluarans = Pengeluaran::whereNotNull('jenis_pengeluaran')->get();
        foreach ($pengeluarans as $pengeluaran) {
            $kategori = Kategori::firstOrCreate(
                ['nama' => $pengeluaran->jenis_pengeluaran, 'tipe' => 'pengeluaran']
            );
            $pengeluaran->update(['kategori_id' => $kategori->id]);
        }
    }

    public function down(): void
    {
        Schema::table('pemasukans', function (Blueprint $table) {
            $table->string('sumber_dana')->nullable();
        });

        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->string('jenis_pengeluaran')->nullable();
        });

        $pemasukans = Pemasukan::with('kategori')->get();
        foreach ($pemasukans as $pemasukan) {
            if ($pemasukan->kategori) {
                $pemasukan->update(['sumber_dana' => $pemasukan->kategori->nama]);
            }
        }

        $pengeluarans = Pengeluaran::with('kategori')->get();
        foreach ($pengeluarans as $pengeluaran) {
            if ($pengeluaran->kategori) {
                $pengeluaran->update(['jenis_pengeluaran' => $pengeluaran->kategori->nama]);
            }
        }

        Schema::table('pemasukans', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });

        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
