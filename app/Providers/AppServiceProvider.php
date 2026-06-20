<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Observers\PemasukanObserver;
use App\Observers\PengeluaranObserver;

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
    }
}
