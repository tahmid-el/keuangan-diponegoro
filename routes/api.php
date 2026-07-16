<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;

Route::middleware(['web', 'auth', 'role:bendahara'])
    ->prefix('bendahara')
    ->name('bendahara.')
    ->group(function () {
        Route::get('/kategoris/search', [KategoriController::class, 'search'])
            ->name('api.kategoris.search');
    });
