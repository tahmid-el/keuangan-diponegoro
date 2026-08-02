<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $fillable = [
        'nama',
        'jumlah_jam',
        'bisyaroh',
        'tunjangan_kamad_wk',
        'tunjangan_piket',
        'jumlah',
    ];

    protected $casts = [
        'jumlah_jam' => 'integer',
        'bisyaroh' => 'float',
        'tunjangan_kamad_wk' => 'float',
        'tunjangan_piket' => 'float',
        'jumlah' => 'float',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->jumlah = $model->bisyaroh + $model->tunjangan_kamad_wk + $model->tunjangan_piket;
        });

        static::updating(function ($model) {
            $model->jumlah = $model->bisyaroh + $model->tunjangan_kamad_wk + $model->tunjangan_piket;
        });
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'gaji_id');
    }
}
