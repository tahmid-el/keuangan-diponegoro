<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis', 'nama_siswa', 'jenis_kelamin', 'orang_tua',
        'tahun_masuk', 'alamat', 'telepon', 'status',
        'kelas_id', 'tahun_ajaran_id',
    ];

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke tahun ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    // Relasi ke akun user
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // Relasi ke tagihan
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    // Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // Relasi ke tabungan
    public function tabungan()
    {
        return $this->hasOne(Tabungan::class);
    }

    // Helper: label jenis kelamin
    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // Helper: label status dengan warna badge
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'aktif'    => '<span class="badge bg-success">Aktif</span>',
            'lulus'    => '<span class="badge bg-primary">Lulus</span>',
            'pindah'   => '<span class="badge bg-warning text-dark">Pindah</span>',
            'nonaktif' => '<span class="badge bg-secondary">Non-aktif</span>',
            default    => '<span class="badge bg-light text-dark">' . $this->status . '</span>',
        };
    }
}