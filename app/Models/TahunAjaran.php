<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajarans';

    protected $fillable = [
        'nama', 'semester', 'tanggal_mulai', 'tanggal_selesai', 'is_aktif'
    ];

    protected $casts = [
        'is_aktif' => 'boolean'
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    // Relasi ke tagihan
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    // Helper: ambil tahun ajaran yang aktif
    public static function aktif()
    {
        return static::where('is_aktif', true)->first();
    }
}