<?php
// ============================================================
// File: app/Http/Controllers/KepsekController.php
// ============================================================
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KepsekController extends Controller
{
    public function dashboard()
    {
        return view('kepsek.dashboard');
    }

    public function laporan()
    {
        return view('laporan');
    }
}


// ============================================================
// File: app/Http/Controllers/SiswaController.php
// ============================================================
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $siswa = Auth::user()->siswa;
        return view('siswa.dashboard', compact('siswa'));
    }

    public function tagihan()
    {
        $siswa = Auth::user()->siswa;
        return view('siswa.tagihan', compact('siswa'));
    }

    public function tabungan()
    {
        $siswa = Auth::user()->siswa;
        return view('siswa.tabungan', compact('siswa'));
    }
}
