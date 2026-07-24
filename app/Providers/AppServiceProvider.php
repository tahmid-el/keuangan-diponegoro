<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Tabungan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Observers\PemasukanObserver;
use App\Observers\PengeluaranObserver;
use App\Observers\TagihanObserver;
use App\Observers\PembayaranObserver;
use App\Observers\TabunganObserver;
use App\Observers\SiswaObserver;
use App\Observers\TahunAjaranObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Pemasukan::observe(PemasukanObserver::class);
        Pengeluaran::observe(PengeluaranObserver::class);
        Tagihan::observe(TagihanObserver::class);
        Pembayaran::observe(PembayaranObserver::class);
        Tabungan::observe(TabunganObserver::class);
        Siswa::observe(SiswaObserver::class);
        TahunAjaran::observe(TahunAjaranObserver::class);
    }
}
