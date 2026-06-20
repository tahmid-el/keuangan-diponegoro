<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        // Kalau sudah login, langsung redirect sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login-bendahara');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            return $this->redirectByRole($role);
        }

        // Login gagal
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }

    // Helper: redirect sesuai role
    private function redirectByRole(string $role)
    {
        return match ($role) {
            // 'bendahara'      => redirect()->route('bendahara.dashboard'),
            // 'kepala_sekolah' => redirect()->route('kepsek.dashboard'),
            // 'siswa'          => redirect()->route('siswa.dashboard'),
            'bendahara'      => redirect()->route('dashboard'),
            'kepala_sekolah' => redirect()->route('dashboard'),
            'siswa'          => redirect()->route('dashboard'),
            default          => redirect()->route('login'),
        };
    }
}
