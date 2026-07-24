<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    // ── Laporan ─────────────────────────────
    public function laporan() { return view('laporan'); }
}
