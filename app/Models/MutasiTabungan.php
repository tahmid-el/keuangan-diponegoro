<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiTabungan extends Model
{
    protected $fillable = [
        'tabungan_id',
        'user_id',
        'jenis',
        'nominal',
        'saldo_akhir',
        'tanggal',
        'keterangan',
    ];
    protected $casts = [
        'nominal'=>'integer',
        'saldo_akhir'=>'integer',
        'tanggal'=>'date',
    ];

    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
