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
        $bulan = $request->input('bulan', '');
        $tahun = $request->input('tahun', Carbon::now()->format('Y'));
        $jenisLaporan = $request->input('jenis_laporan', 'pendapatan');

        if ($bulan) {
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->format('Y-m-d');
        } else {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfYear()->format('Y-m-d');
            $endDate = Carbon::createFromDate($tahun, 12, 1)->endOfYear()->format('Y-m-d');
        }

        $laporan = collect();

        if ($jenisLaporan == 'pendapatan' || $jenisLaporan == 'penghasilan_komprehensif' || $jenisLaporan == 'posisi_keuangan' || $jenisLaporan == 'arus_kas') {
            $query = Pemasukan::with('kategori')->whereBetween('tanggal', [$startDate, $endDate]);
            $pemasukan = $query->get()->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'kelompok_isak35' => $item->kategori->kelompok_isak35 ?? '-',
                    'tipe' => 'Pemasukan',
                    'pemasukan' => $item->nominal,
                    'pengeluaran' => 0
                ];
            });
            $laporan = $laporan->merge($pemasukan);
        }

        if ($jenisLaporan == 'beban' || $jenisLaporan == 'penghasilan_komprehensif' || $jenisLaporan == 'posisi_keuangan' || $jenisLaporan == 'arus_kas') {
            $query = Pengeluaran::with('kategori')->whereBetween('tanggal', [$startDate, $endDate]);
            $pengeluaran = $query->get()->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'kelompok_isak35' => $item->kategori->kelompok_isak35 ?? '-',
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

        return view('laporan', compact('laporan', 'bulan', 'tahun', 'startDate', 'endDate', 'jenisLaporan', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir'));
    }

    public function printLaporan(Request $request) 
    { 
        $bulan = $request->input('bulan', '');
        $tahun = $request->input('tahun', Carbon::now()->format('Y'));
        $jenisLaporan = $request->input('jenis_laporan', 'pendapatan');

        if ($bulan) {
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth()->format('Y-m-d');
        } else {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfYear()->format('Y-m-d');
            $endDate = Carbon::createFromDate($tahun, 12, 1)->endOfYear()->format('Y-m-d');
        }

        $laporan = collect();

        if ($jenisLaporan == 'pendapatan' || $jenisLaporan == 'penghasilan_komprehensif' || $jenisLaporan == 'arus_kas') {
            $query = Pemasukan::with('kategori')->whereBetween('tanggal', [$startDate, $endDate]);
            $pemasukan = $query->get()->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'kelompok_isak35' => $item->kategori->kelompok_isak35 ?? '-',
                    'status_pembatasan' => $item->kategori->status_pembatasan_dana ?? 'Tanpa Pembatasan',
                    'tipe' => 'Pemasukan',
                    'pemasukan' => $item->nominal,
                    'pengeluaran' => 0
                ];
            });
            $laporan = $laporan->merge($pemasukan);
        }

        if ($jenisLaporan == 'beban' || $jenisLaporan == 'penghasilan_komprehensif' || $jenisLaporan == 'arus_kas') {
            $query = Pengeluaran::with('kategori')->whereBetween('tanggal', [$startDate, $endDate]);
            $pengeluaran = $query->get()->map(function($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                    'keterangan' => $item->keterangan,
                    'kategori' => $item->kategori->nama ?? '-',
                    'kelompok_isak35' => $item->kategori->kelompok_isak35 ?? '-',
                    'status_pembatasan' => $item->kategori->status_pembatasan_dana ?? 'Tanpa Pembatasan',
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

        $kas = Pemasukan::sum('nominal') - Pengeluaran::sum('nominal');
        $asetNetoTanpa = Pemasukan::whereHas('kategori', fn($q) => $q->where(function($q2) {
            $q2->where('status_pembatasan_dana', 'Tanpa Pembatasan')->orWhereNull('status_pembatasan_dana');
        }))->sum('nominal') - Pengeluaran::sum('nominal');
        $asetNetoDengan = Pemasukan::whereHas('kategori', fn($q) => $q->where('status_pembatasan_dana', 'Dengan Pembatasan'))->sum('nominal');
        $totalAset = $kas;
        $totalAsetNeto = $asetNetoTanpa + $asetNetoDengan;
        $totalLiabilitas = 0;
        $totalLiabilitasDanAsetNeto = $totalLiabilitas + $totalAsetNeto;

        $view = match($jenisLaporan) {
            'pendapatan' => 'laporan.print-pendapatan',
            'beban' => 'laporan.print-beban',
            'penghasilan_komprehensif' => 'laporan.print-penghasilan-komprehensif',
            'posisi_keuangan' => 'laporan.print-posisi-keuangan',
            'arus_kas' => 'laporan.print-arus-kas',
            default => 'laporan.print-pendapatan',
        };

        return view($view, compact(
            'laporan', 'bulan', 'tahun', 'jenisLaporan',
            'totalPemasukan', 'totalPengeluaran', 'saldoAkhir',
            'kas', 'totalAset', 'asetNetoTanpa', 'asetNetoDengan',
            'totalAsetNeto', 'totalLiabilitas', 'totalLiabilitasDanAsetNeto'
        ));
    }
}
