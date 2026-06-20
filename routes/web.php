<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PengeluaranController;

// ─────────────────────────────────────────────
// HALAMAN UTAMA → redirect ke login
// ─────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
});

// ─────────────────────────────────────────────
// AUTH (Login & Logout)
// ─────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─────────────────────────────────────────────
// DASHBOARD UMUM
// ─────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

// ─────────────────────────────────────────────
// BENDAHARA
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {

    // Histori (Log Aktivitas)
    Route::get('/histori', [\App\Http\Controllers\HistoryController::class, 'index'])->name('histori.index');
    // Data Siswa
    Route::get('/siswa',                      [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/tambah-baru',          [SiswaController::class, 'tambahBaru'])->name('siswa.tambah-baru');
    Route::post('/siswa/tambah-baru',         [SiswaController::class, 'simpanBaru'])->name('siswa.simpan-baru');
    Route::get('/siswa/tambah-lama',          [SiswaController::class, 'tambahLama'])->name('siswa.tambah-lama');
    Route::post('/siswa/tambah-lama',         [SiswaController::class, 'simpanLama'])->name('siswa.simpan-lama');
    Route::get('/siswa/{siswa}/edit',         [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{siswa}',              [SiswaController::class, 'update'])->name('siswa.update');
    Route::patch('/siswa/{siswa}/arsip',      [SiswaController::class, 'arsip'])->name('siswa.arsip');
    Route::delete('/siswa/{siswa}',           [SiswaController::class, 'hapus'])->name('siswa.hapus');

    // Tagihan
    Route::get('/tagihan',                [BendaharaController::class, 'tagihanDaftar'])->name('tagihan.index');
    Route::get('/tagihan/tambah',         [BendaharaController::class, 'tagihanTambah'])->name('tagihan.tambah');
    Route::post('/tagihan',               [BendaharaController::class, 'tagihanSimpan'])->name('tagihan.simpan');
    Route::delete('/tagihan/{tagihan}',   [BendaharaController::class, 'tagihanHapus'])->name('tagihan.hapus');

    // Pembayaran
    Route::get('/pembayaran',             [BendaharaController::class, 'pembayaranDaftar'])->name('pembayaran.index');
    Route::get('/pembayaran/tambah',      [BendaharaController::class, 'pembayaranTambah'])->name('pembayaran.tambah');
    Route::post('/pembayaran',            [BendaharaController::class, 'pembayaranSimpan'])->name('pembayaran.simpan');
    Route::get('/pembayaran/{id}/edit',   [BendaharaController::class, 'pembayaranEdit'])->name('pembayaran.edit');
    Route::put('/pembayaran/{id}',        [BendaharaController::class, 'pembayaranUpdate'])->name('pembayaran.update');
    Route::delete('/pembayaran/{id}',     [BendaharaController::class, 'pembayaranHapus'])->name('pembayaran.hapus');
    
    // Tabungan
    Route::get('/tabungan',               [BendaharaController::class, 'tabunganDaftar'])->name('tabungan.index');
    Route::get('/tabungan/setor',         [BendaharaController::class, 'tabunganSetor'])->name('tabungan.setor');
    Route::post('/tabungan/setor',        [BendaharaController::class, 'tabunganSimpanSetor'])->name('tabungan.simpan-setor');
    Route::get('/tabungan/tarik',         [BendaharaController::class, 'tabunganTarik'])->name('tabungan.tarik');
    Route::post('/tabungan/tarik',        [BendaharaController::class, 'tabunganSimpanTarik'])->name('tabungan.simpan-tarik');
    Route::get('/tabungan/{siswa}',       [BendaharaController::class, 'tabunganDetail'])->name('tabungan.detail');

    // Pengeluaran
    Route::get('/pengeluaran', [\App\Http\Controllers\PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/tambah', [\App\Http\Controllers\PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran', [\App\Http\Controllers\PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{id}/edit', [\App\Http\Controllers\PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
    Route::put('/pengeluaran/{id}', [\App\Http\Controllers\PengeluaranController::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{id}', [\App\Http\Controllers\PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    // Pemasukan
    Route::get('/pemasukan', [\App\Http\Controllers\PemasukanController::class, 'index'])->name('pemasukan.index');
    Route::get('/pemasukan/tambah', [\App\Http\Controllers\PemasukanController::class, 'create'])->name('pemasukan.create');
    Route::post('/pemasukan', [\App\Http\Controllers\PemasukanController::class, 'store'])->name('pemasukan.store');
    Route::get('/pemasukan/{id}/edit', [\App\Http\Controllers\PemasukanController::class, 'edit'])->name('pemasukan.edit');
    Route::put('/pemasukan/{id}', [\App\Http\Controllers\PemasukanController::class, 'update'])->name('pemasukan.update');
    Route::delete('/pemasukan/{id}', [\App\Http\Controllers\PemasukanController::class, 'destroy'])->name('pemasukan.destroy');

    // Laporan
    Route::get('/laporan',                [BendaharaController::class, 'laporan'])->name('laporan');
});

// ─────────────────────────────────────────────
// KEPALA SEKOLAH (hanya bisa lihat laporan)
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/laporan',   [KepsekController::class, 'laporan'])->name('laporan');
});

// ─────────────────────────────────────────────
// SISWA (hanya bisa lihat tagihan & tabungan sendiri)
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/tagihan',   [SiswaController::class, 'tagihan'])->name('tagihan');
    Route::get('/tabungan',  [SiswaController::class, 'tabungan'])->name('tabungan');
});
