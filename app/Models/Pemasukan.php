<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    protected $fillable = ['tanggal', 'nominal', 'keterangan', 'sumber_dana', 'bukti', 'deskripsi', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
