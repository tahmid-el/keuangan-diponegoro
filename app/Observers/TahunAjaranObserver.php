<?php

namespace App\Observers;

use App\Models\TahunAjaran;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class TahunAjaranObserver
{
    /**
     * Handle the TahunAjaran "created" event.
     */
    public function created(TahunAjaran $tahunAjaran): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'CREATE',
            'transaksi'     => 'Tahun Ajaran',
            'keterangan'    => 'Menambahkan tahun ajaran: ' . $tahunAjaran->nama,
            'data_sebelum'  => null,
            'data_sesudah'  => $tahunAjaran->toArray(),
        ]);
    }

    /**
     * Handle the TahunAjaran "updated" event.
     */
    public function updated(TahunAjaran $tahunAjaran): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'UPDATE',
            'transaksi'     => 'Tahun Ajaran',
            'keterangan'    => 'Mengubah tahun ajaran: ' . $tahunAjaran->nama,
            'data_sebelum'  => $tahunAjaran->getOriginal(),
            'data_sesudah'  => $tahunAjaran->toArray(),
        ]);
    }

    /**
     * Handle the TahunAjaran "deleted" event.
     */
    public function deleted(TahunAjaran $tahunAjaran): void
    {
        History::create([
            'user_id'       => Auth::id() ?? 1,
            'aktivitas'     => 'DELETE',
            'transaksi'     => 'Tahun Ajaran',
            'keterangan'    => 'Menghapus tahun ajaran: ' . $tahunAjaran->nama,
            'data_sebelum'  => $tahunAjaran->toArray(),
            'data_sesudah'  => null,
        ]);
    }
}