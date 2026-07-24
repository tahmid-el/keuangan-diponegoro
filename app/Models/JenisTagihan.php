<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTagihan extends Model
{
    protected $table = 'jenis_tagihan';

    protected $fillable = [
        'nama_tagihan'
    ];

    public function siswa()
    {
        return $this->hasMany(
            Siswa::class,
            'jenis_tagihan_id'
        );
    }
}