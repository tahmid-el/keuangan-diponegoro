<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Kategori;
use Carbon\Carbon;

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
    public function laporan(Request $request) 
    { 
        $bulan = $request->input('bulan', Carbon::now()->format('m'));
        $tahun = $request->input('tahun', Carbon::now()->format('Y'));
        $jenisLaporan = $request->input('jenis_laporan', 'Semua');
        $kategoriId = $request->input('kategori_id');

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->format('Y-m-d');

        $kategoris = match($jenisLaporan) {
            'Pemasukan' => Kategori::pemasukan()->orderBy('nama')->get(),
            'Pengeluaran' => Kategori::pengeluaran()->orderBy('nama')->get(),
            default => Kategori::orderBy('nama')->get(),
        };

        $laporan = collect();

        if ($jenisLaporan == 'Semua' || $jenisLaporan == 'Pemasukan') {
            $query = Pemasukan::with('kategori')->whereBetween('tanggal', [$startDate, $endDate]);
            if ($kategoriId) {
                $query->where('kategori_id', $kategoriId);
            }
            $pemasukan = $query->get()->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'tipe' => 'Pemasukan',
                    'pemasukan' => $item->nominal,
                    'pengeluaran' => 0
                ];
            });
            $laporan = $laporan->merge($pemasukan);
        }

        if ($jenisLaporan == 'Semua' || $jenisLaporan == 'Pengeluaran') {
            $query = Pengeluaran::with('kategori')->whereBetween('tanggal', [$startDate, $endDate]);
            if ($kategoriId) {
                $query->where('kategori_id', $kategoriId);
            }
            $pengeluaran = $query->get()->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'tipe' => 'Pengeluaran',
                    'pemasukan' => 0,
                    'pengeluaran' => $item->nominal
                ];
            });
            $laporan = $laporan->merge($pengeluaran);
        }

        $laporan = $laporan->sortBy(function($item) {
            return $item['tanggal'] . ' ' . $item['created_at'];
        })->values();

        $totalPemasukan = $laporan->sum('pemasukan');
        $totalPengeluaran = $laporan->sum('pengeluaran');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('laporan', compact('laporan', 'bulan', 'tahun', 'startDate', 'endDate', 'jenisLaporan', 'kategoriId', 'kategoris', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir'));
    }

    public function printLaporan(Request $request) 
    { 
        $bulan = $request->input('bulan', Carbon::now()->format('m'));
        $tahun = $request->input('tahun', Carbon::now()->format('Y'));
        $jenisLaporan = $request->input('jenis_laporan', 'Semua');
        $kategoriId = $request->input('kategori_id');

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->format('Y-m-d');

        $kategoris = match($jenisLaporan) {
            'Pemasukan' => Kategori::pemasukan()->orderBy('nama')->get(),
            'Pengeluaran' => Kategori::pengeluaran()->orderBy('nama')->get(),
            default => Kategori::orderBy('nama')->get(),
        };

        $laporan = collect();

        if ($jenisLaporan == 'Semua' || $jenisLaporan == 'Pemasukan') {
            $query = Pemasukan::with('kategori')->whereBetween('tanggal', [$startDate, $endDate]);
            if ($kategoriId) {
                $query->where('kategori_id', $kategoriId);
            }
            $pemasukan = $query->get()->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'tipe' => 'Pemasukan',
                    'pemasukan' => $item->nominal,
                    'pengeluaran' => 0
                ];
            });
            $laporan = $laporan->merge($pemasukan);
        }

        if ($jenisLaporan == 'Semua' || $jenisLaporan == 'Pengeluaran') {
            $query = Pengeluaran::with('kategori')->whereBetween('tanggal', [$startDate, $endDate]);
            if ($kategoriId) {
                $query->where('kategori_id', $kategoriId);
            }
            $pengeluaran = $query->get()->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'tipe' => 'Pengeluaran',
                    'pemasukan' => 0,
                    'pengeluaran' => $item->nominal
                ];
            });
            $laporan = $laporan->merge($pengeluaran);
        }

        $laporan = $laporan->sortBy(function($item) {
            return $item['tanggal'] . ' ' . $item['created_at'];
        })->values();

        $totalPemasukan = $laporan->sum('pemasukan');
        $totalPengeluaran = $laporan->sum('pengeluaran');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('laporan_print', compact('laporan', 'bulan', 'tahun', 'startDate', 'endDate', 'jenisLaporan', 'kategoriId', 'kategoris', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir'));
    }
}
