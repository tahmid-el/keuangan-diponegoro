<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TahunAjaranController;

use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\DashboardController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ─────────────────────────────────────────────
// BENDAHARA
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {

    // Histori (Log Aktivitas)
    Route::get('/histori', [HistoryController::class, 'index'])->name('histori.index');
    
    // Tahun Ajaran
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun_ajaran.index');
    Route::get('/tahun-ajaran/tambah', [TahunAjaranController::class, 'create'])->name('tahun_ajaran.create');
    Route::post('/tahun-ajaran/store', [TahunAjaranController::class, 'store'])->name('tahun_ajaran.store');
    Route::get('/tahun-ajaran/{tahunAjaran}/edit', [TahunAjaranController::class, 'edit'])->name('tahun_ajaran.edit');
    Route::put('/tahun-ajaran/{tahunAjaran}', [TahunAjaranController::class, 'update'])->name('tahun_ajaran.update');
    Route::delete('/tahun-ajaran/{tahunAjaran}', [TahunAjaranController::class, 'destroy'])->name('tahun_ajaran.destroy');
    Route::patch('/tahun-ajaran/{tahunAjaran}/aktifkan', [TahunAjaranController::class, 'aktifkan'])->name('tahun_ajaran.aktifkan');

    // Data Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/tambah-baru', [SiswaController::class, 'tambahBaru'])->name('siswa.tambah-baru');
    Route::post('/siswa/tambah-baru', [SiswaController::class, 'simpanBaru'])->name('siswa.simpan-baru');
    Route::get('/siswa/tambah-lama', [SiswaController::class, 'tambahLama'])->name('siswa.tambah-lama');
    Route::post('/siswa/tambah-lama', [SiswaController::class, 'simpanLama'])->name('siswa.simpan-lama');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::patch('/siswa/{siswa}/arsip', [SiswaController::class, 'arsip'])->name('siswa.arsip');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'hapus'])->name('siswa.hapus');
    Route::post('/siswa/naik-kelas',[SiswaController::class, 'naikKelas'])->name('siswa.naik-kelas');

    // Tagihan
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
    Route::get('/tagihan/tambah', [TagihanController::class, 'create'])->name('tagihan.create');
    Route::post('/tagihan/store', [TagihanController::class, 'store'])->name('tagihan.store');
    Route::get('/tagihan/{tagihan}/edit', [TagihanController::class, 'edit'])->name('tagihan.edit');
    Route::put('/tagihan/{tagihan}', [TagihanController::class, 'update'])->name('tagihan.update');
    Route::patch('/tagihan/{tagihan}/arsip', [TagihanController::class, 'arsip'])->name('tagihan.arsip');

    // Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/tambah', [PembayaranController::class, 'create'])->name('pembayaran.tambah');
    Route::post('/pembayaran/cari-siswa', [PembayaranController::class, 'cariSiswa'])->name('pembayaran.cariSiswa');
    Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.simpan');
    Route::get('/pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
    Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.hapus');
    
    // Tabungan
    Route::get('/tabungan',  [TabunganController::class, 'index'])->name('tabungan.index');
    Route::get('/tabungan/tambah',  [TabunganController::class, 'create'])->name('tabungan.create');
    Route::post('/tabungan/tambah',  [TabunganController::class, 'store'])->name('tabungan.store');
    Route::get('/tabungan/setor',  [TabunganController::class, 'setor'])->name('tabungan.setor');
    Route::post('/tabungan/setor',   [TabunganController::class, 'storeSetor'])->name('tabungan.storeSetor');
    Route::get('/tabungan/tarik',  [TabunganController::class, 'tarik'])->name('tabungan.tarik');
    Route::post('/tabungan/tarik',  [TabunganController::class, 'storeTarik'])->name('tabungan.storeTarik');
    Route::get('/tabungan/{id}',  [TabunganController::class, 'show'])->name('tabungan.show');

    // Pengeluaran
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/tambah', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
    Route::put('/pengeluaran/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');

    // Pemasukan
    Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
    Route::get('/pemasukan/tambah', [PemasukanController::class, 'create'])->name('pemasukan.create');
    Route::post('/pemasukan', [PemasukanController::class, 'store'])->name('pemasukan.store');
    Route::get('/pemasukan/{id}/edit', [PemasukanController::class, 'edit'])->name('pemasukan.edit');
    Route::put('/pemasukan/{id}', [PemasukanController::class, 'update'])->name('pemasukan.update');
    Route::delete('/pemasukan/{id}', [PemasukanController::class, 'destroy'])->name('pemasukan.destroy');

    // Laporan
    Route::get('/laporan',                [BendaharaController::class, 'laporan'])->name('laporan');
});

// ─────────────────────────────────────────────
// KEPALA SEKOLAH (hanya bisa lihat laporan)
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/laporan',   [KepsekController::class, 'laporan'])->name('laporan');
    Route::get('/histori',   [HistoryController::class, 'index'])->name('histori.index');
});

// ─────────────────────────────────────────────
// SISWA (hanya bisa lihat tagihan & tabungan sendiri)
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/tagihan',   [SiswaController::class, 'tagihan'])->name('tagihan');
    Route::get('/tabungan',  [SiswaController::class, 'tabungan'])->name('tabungan');
});
