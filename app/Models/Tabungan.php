<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $fillable = [
        'siswa_id',
        'saldo',
    ];
     protected $casts = [
        'saldo' => 'integer',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mutasi()
    {
        return $this->hasMany(MutasiTabungan::class);
    }
}
