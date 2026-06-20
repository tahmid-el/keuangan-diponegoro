<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = ['tanggal', 'keterangan', 'nominal', 'jenis_pengeluaran', 'bukti', 'deskripsi', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
