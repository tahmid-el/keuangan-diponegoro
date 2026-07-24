<?php

namespace App\Observers;

use App\Models\Tagihan;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class TagihanObserver
{
    /**
     * Handle the Tagihan "created" event.
     */
    public function created(Tagihan $tagihan): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'CREATE',
            'transaksi'     => 'Tagihan',
            'keterangan'    => 'Menambahkan tagihan.',
            'data_sebelum'  => null,
            'data_sesudah'  => $tagihan->toArray(),
        ]);
    }

    /**
     * Handle the Tagihan "updated" event.
     */
    public function updated(Tagihan $tagihan): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'UPDATE',
            'transaksi'     => 'Tagihan',
            'keterangan'    => 'Mengubah tagihan.',
            'data_sebelum'  => $tagihan->getOriginal(),
            'data_sesudah'  => $tagihan->toArray(),
        ]);
    }

    /**
     * Handle the Tagihan "deleted" event.
     */
    public function deleted(Tagihan $tagihan): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'DELETE',
            'transaksi'     => 'Tagihan',
            'keterangan'    => 'Menghapus tagihan.',
            'data_sebelum'  => $tagihan->toArray(),
            'data_sesudah'  => null,
        ]);
    }
}