<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'user_id',
        'aktivitas',
        'transaksi',
        'keterangan',
        'data_sebelum',
        'data_sesudah'
    ];

    protected $casts = [
        'data_sebelum' => 'array',
        'data_sesudah' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
