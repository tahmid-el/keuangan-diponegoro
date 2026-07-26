<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama', 'tipe', 'kelompok_isak35',
        'status_pembatasan_dana', 'is_aktif',
    ];

    public function pemasukans()
    {
        return $this->hasMany(Pemasukan::class, 'kategori_id');
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'kategori_id');
    }

    public function scopePemasukan($query)
    {
        return $query->where('tipe', 'pemasukan');
    }

    public function scopePengeluaran($query)
    {
        return $query->where('tipe', 'pengeluaran');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeDenganPembatasan($query)
    {
        return $query->where('status_pembatasan_dana', 'Dengan Pembatasan');
    }

    public function scopeTanpaPembatasan($query)
    {
        return $query->where('status_pembatasan_dana', 'Tanpa Pembatasan');
    }

    public function getKelompokIsak35LabelAttribute(): string
    {
        return match ($this->kelompok_isak35) {
            'Pendapatan' => 'Pendapatan',
            'Beban'      => 'Beban',
            default      => '-',
        };
    }
}
