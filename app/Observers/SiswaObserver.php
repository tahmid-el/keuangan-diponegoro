<?php

namespace App\Observers;

use App\Models\Siswa;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class SiswaObserver
{
    /**
     * Handle the Siswa "created" event.
     */
    public function created(Siswa $siswa): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'CREATE',
            'transaksi'     => 'Data Siswa',
            'keterangan'    => 'Menambahkan data siswa: ' . $siswa->nama_siswa,
            'data_sebelum'  => null,
            'data_sesudah'  => $siswa->toArray(),
        ]);
    }

    /**
     * Handle the Siswa "updated" event.
     */
    public function updated(Siswa $siswa): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'UPDATE',
            'transaksi'     => 'Data Siswa',
            'keterangan'    => 'Mengubah data siswa: ' . $siswa->nama_siswa,
            'data_sebelum'  => $siswa->getOriginal(),
            'data_sesudah'  => $siswa->toArray(),
        ]);
    }

    /**
     * Handle the Siswa "deleted" event.
     */
    public function deleted(Siswa $siswa): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'DELETE',
            'transaksi'     => 'Data Siswa',
            'keterangan'    => 'Menghapus data siswa: ' . $siswa->nama_siswa,
            'data_sebelum'  => $siswa->toArray(),
            'data_sesudah'  => null,
        ]);
    }
}