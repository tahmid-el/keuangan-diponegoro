<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Cek apakah user punya role yang diizinkan
     * Contoh pemakaian di route: middleware('role:bendahara')
     *                         atau middleware('role:bendahara,kepala_sekolah')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login → ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        // Role tidak diizinkan → ke halaman 403
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
