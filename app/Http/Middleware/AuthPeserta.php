<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPeserta
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('peserta')->check()) {
            return redirect()->route('auth.login')->with('error', 'Silakan masuk atau daftar terlebih dahulu.');
        }

        $user = Auth::guard('peserta')->user();
        $status = $user->status_akun ?? 'aktif';

        if ($status !== 'aktif') {
            Auth::guard('peserta')->logout();
            $msg = $status === 'nonaktif'
                ? 'Akun Anda telah dinonaktifkan oleh admin. Silakan hubungi pihak FCC.'
                : 'Akun Anda sedang ditangguhkan. Silakan hubungi pihak FCC.';
            return redirect()->route('auth.login')->with('error', $msg);
        }

        return $next($request);
    }
}