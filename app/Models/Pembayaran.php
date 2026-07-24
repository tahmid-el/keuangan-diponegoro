<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $fillable = [

        'siswa_id',

        'tagihan_id',

        'jenis_pembayaran_id',

        'user_id',

        'no_kwitansi',

        'tanggal_bayar',

        'nominal',

        'periode',

        'status',

        'keterangan'

    ];
    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
