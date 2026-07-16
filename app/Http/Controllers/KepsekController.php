<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Kategori;
use Carbon\Carbon;

class KepsekController extends Controller
{
    public function dashboard()
    {
        return view('kepsek.dashboard');
    }

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
