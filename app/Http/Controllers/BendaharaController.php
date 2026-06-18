<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BendaharaController extends Controller
{
    public function dashboard()
    {
        return view('bendahara.dashboard_bendahara');
    }
    public function histori()
    {
        return view('bendahara.histori.index');
    }

    // ── Data Siswa ──────────────────────────
    public function siswaDaftar()   { return view('data_siswa'); }
    public function siswaTambahBaru(){ return view('tambah_siswa_baru'); }
    public function siswaSimpanBaru(Request $r){ /* Tahap 3 */ }
    public function siswaTambahLama(){ return view('tambah_siswa_lama'); }
    public function siswaSimpanLama(Request $r){ /* Tahap 3 */ }
    public function siswaEdit($siswa){ return view('edit_data_siswa'); }
    public function siswaUpdate(Request $r, $siswa){ /* Tahap 3 */ }
    public function siswaHapus($siswa){ /* Tahap 3 */ }

    // ── Tagihan ─────────────────────────────
    public function tagihanDaftar()  { return view('tagihan'); }
    public function tagihanTambah()  { return view('tambah_tagihan'); }
    public function tagihanSimpan(Request $r){ /* Tahap 3 */ }
    public function tagihanHapus($tagihan){ /* Tahap 3 */ }

    // ── Pembayaran ──────────────────────────
    public function pembayaranDaftar() { return view('pembayaran'); }
    public function pembayaranTambah() { return view('tambah_pembayaran'); }
    public function pembayaranSimpan(Request $r){ /* Tahap 3 */ }
    public function pembayaranEdit($id){ return view('edit_pembayaran'); }
    public function pembayaranUpdate(Request $r, $id){ /* Tahap 3 */ }
    public function pembayaranHapus($id){ /* Tahap 3 */ }
    public function historiIndex() {return view('pembayaran'); }

    // ── Tabungan ────────────────────────────
    public function tabunganDaftar()  { return view('tabungan'); }
    public function tabunganSetor()   { return view('setor_tabungan'); }
    public function tabunganSimpanSetor(Request $r){ /* Tahap 3 */ }
    public function tabunganTarik()   { return view('tarik_tabungan'); }
    public function tabunganSimpanTarik(Request $r){ /* Tahap 3 */ }
    public function tabunganDetail($siswa){ return view('tabungan'); }

    // ── Laporan ─────────────────────────────
    public function laporan() { return view('laporan'); }
}
