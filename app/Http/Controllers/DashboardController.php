<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        
        // Setup Rentang Tanggal (Default: Awal bulan ini sampai hari ini)
        $startDate = $request->input('startdate', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('enddate', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Jika user memaksa input URL secara manual terbalik (start > end), swap otomatis
        if ($startDate > $endDate) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }

        // Saldo Kas = Semua Pemasukan (All Time) - Semua Pengeluaran (All Time)
        $totalPemasukanAll = Pemasukan::sum('nominal');
        $totalPengeluaranAll = Pengeluaran::sum('nominal');
        $saldoKas = $totalPemasukanAll - $totalPengeluaranAll;

        // Ambil Data Berdasarkan Filter Tanggal
        $pemasukans = Pemasukan::whereBetween('tanggal', [$startDate, $endDate])->get();
        $pengeluarans = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])->get();

        // Total Nominal pada Rentang Tanggal Tersebut
        $pemasukan = $pemasukans->sum('nominal');
        $pengeluaran = $pengeluarans->sum('nominal');

        // Total Transaksi (Count / Jumlah Baris)
        $totalTransaksi = $pemasukans->count() + $pengeluarans->count();

        // Kelompokkan data per tanggal (untuk grafik)
        $pemasukanHarian = $pemasukans->groupBy(function($item) {
            return Carbon::parse($item->tanggal)->format('Y-m-d');
        })->map(function($row) {
            return $row->sum('nominal');
        });

        $pengeluaranHarian = $pengeluarans->groupBy(function($item) {
            return Carbon::parse($item->tanggal)->format('Y-m-d');
        })->map(function($row) {
            return $row->sum('nominal');
        });

        // Menyiapkan Array untuk ApexCharts
        $dates = [];
        $pemasukanChart = [];
        $pengeluaranChart = [];
        
        $currentDate = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Jika jarak terlalu jauh (> 31 hari), kita tetap menampilkan per hari (bisa disesuaikan nanti)
        while ($currentDate->lte($end)) {
            $dateString = $currentDate->format('Y-m-d');
            $dates[] = $currentDate->format('d M'); // Format misal: "12 Aug"
            
            $pemasukanChart[] = $pemasukanHarian->has($dateString) ? $pemasukanHarian[$dateString] : 0;
            $pengeluaranChart[] = $pengeluaranHarian->has($dateString) ? $pengeluaranHarian[$dateString] : 0;
            
            $currentDate->addDay();
        }

        return view('dashboard', compact(
            'role', 
            'saldoKas', 
            'pemasukan', 
            'pengeluaran', 
            'totalTransaksi',
            'startDate',
            'endDate',
            'dates',
            'pemasukanChart',
            'pengeluaranChart'
        ));
    }
}
