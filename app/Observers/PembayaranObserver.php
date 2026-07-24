<?php

namespace App\Observers;

use App\Models\Pembayaran;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class PembayaranObserver
{
    /**
     * Handle the Pembayaran "created" event.
     */
    public function created(Pembayaran $pembayaran): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'CREATE',
            'transaksi'     => 'Pembayaran',
            'keterangan'    => 'Menambahkan pembayaran: ' . ($pembayaran->no_kwitansi ?? '-'),
            'data_sebelum'  => null,
            'data_sesudah'  => $pembayaran->toArray(),
        ]);
    }

    /**
     * Handle the Pembayaran "updated" event.
     */
    public function updated(Pembayaran $pembayaran): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'UPDATE',
            'transaksi'     => 'Pembayaran',
            'keterangan'    => 'Mengubah pembayaran: ' . ($pembayaran->no_kwitansi ?? '-'),
            'data_sebelum'  => $pembayaran->getOriginal(),
            'data_sesudah'  => $pembayaran->toArray(),
        ]);
    }

    /**
     * Handle the Pembayaran "deleted" event.
     */
    public function deleted(Pembayaran $pembayaran): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'DELETE',
            'transaksi'     => 'Pembayaran',
            'keterangan'    => 'Menghapus pembayaran: ' . ($pembayaran->no_kwitansi ?? '-'),
            'data_sebelum'  => $pembayaran->toArray(),
            'data_sesudah'  => null,
        ]);
    }
}