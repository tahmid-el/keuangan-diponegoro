<?php

namespace App\Observers;

use App\Models\Tabungan;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class TabunganObserver
{
    /**
     * Handle the Tabungan "created" event.
     */
    public function created(Tabungan $tabungan): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'CREATE',
            'transaksi'     => 'Tabungan',
            'keterangan'    => 'Menambahkan data tabungan.',
            'data_sebelum'  => null,
            'data_sesudah'  => $tabungan->toArray(),
        ]);
    }

    /**
     * Handle the Tabungan "updated" event.
     */
    public function updated(Tabungan $tabungan): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'UPDATE',
            'transaksi'     => 'Tabungan',
            'keterangan'    => 'Mengubah data tabungan.',
            'data_sebelum'  => $tabungan->getOriginal(),
            'data_sesudah'  => $tabungan->toArray(),
        ]);
    }

    /**
     * Handle the Tabungan "deleted" event.
     */
    public function deleted(Tabungan $tabungan): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'DELETE',
            'transaksi'     => 'Tabungan',
            'keterangan'    => 'Menghapus data tabungan.',
            'data_sebelum'  => $tabungan->toArray(),
            'data_sesudah'  => null,
        ]);
    }
}