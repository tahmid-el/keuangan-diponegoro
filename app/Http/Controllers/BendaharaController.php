<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Kategori;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Tabungan;
use App\Models\TahunAjaran;
use App\Models\Kelas;

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
}
