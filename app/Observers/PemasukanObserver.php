<?php

namespace App\Observers;

use App\Models\Pemasukan;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class PemasukanObserver
{
    public function created(Pemasukan $pemasukan): void
    {
        History::create([
            'user_id' => Auth::id() ?? 1,
            'aktivitas' => 'CREATE',
            'transaksi' => 'Pemasukan',
            'keterangan' => 'Menambahkan pemasukan: ' . $pemasukan->keterangan,
            'data_sebelum' => null,
            'data_sesudah' => $pemasukan->toArray(),
        ]);
    }

    public function updated(Pemasukan $pemasukan): void
    {
        History::create([
            'user_id' => Auth::id() ?? 1,
            'aktivitas' => 'UPDATE',
            'transaksi' => 'Pemasukan',
            'keterangan' => 'Mengubah pemasukan: ' . $pemasukan->keterangan,
            'data_sebelum' => $pemasukan->getOriginal(),
            'data_sesudah' => $pemasukan->toArray(),
        ]);
    }

    public function deleted(Pemasukan $pemasukan): void
    {
        History::create([
            'user_id' => Auth::id() ?? 1,
            'aktivitas' => 'DELETE',
            'transaksi' => 'Pemasukan',
            'keterangan' => 'Menghapus pemasukan: ' . $pemasukan->keterangan,
            'data_sebelum' => $pemasukan->toArray(),
            'data_sesudah' => null,
        ]);
    }
}
