<?php

namespace App\Observers;

use App\Models\Pengeluaran;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class PengeluaranObserver
{
    public function created(Pengeluaran $pengeluaran): void
    {
        History::create([
            'user_id' => Auth::id() ?? 1,
            'aktivitas' => 'CREATE',
            'transaksi' => 'Pengeluaran',
            'keterangan' => 'Mencatat pengeluaran: ' . $pengeluaran->keterangan,
            'data_sebelum' => null,
            'data_sesudah' => $pengeluaran->toArray(),
        ]);
    }

    public function updated(Pengeluaran $pengeluaran): void
    {
        History::create([
            'user_id' => Auth::id() ?? 1,
            'aktivitas' => 'UPDATE',
            'transaksi' => 'Pengeluaran',
            'keterangan' => 'Mengubah pengeluaran: ' . $pengeluaran->keterangan,
            'data_sebelum' => $pengeluaran->getOriginal(),
            'data_sesudah' => $pengeluaran->toArray(),
        ]);
    }

    public function deleted(Pengeluaran $pengeluaran): void
    {
        History::create([
            'user_id' => Auth::id() ?? 1,
            'aktivitas' => 'DELETE',
            'transaksi' => 'Pengeluaran',
            'keterangan' => 'Menghapus pengeluaran: ' . $pengeluaran->keterangan,
            'data_sebelum' => $pengeluaran->toArray(),
            'data_sesudah' => null,
        ]);
    }
}
