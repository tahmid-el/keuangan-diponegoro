<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::view('/data_siswa', 'data_siswa');
Route::view('/pembayaran', 'pembayaran');
Route::view('/tabungan', 'tabungan');
Route::view('/tagihan', 'tagihan');