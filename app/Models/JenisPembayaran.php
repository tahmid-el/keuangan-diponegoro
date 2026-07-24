<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $table = 'jenis_pembayarans';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }
}