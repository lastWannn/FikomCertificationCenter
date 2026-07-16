<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
class AuthPeserta {
    public function handle(Request $request, Closure $next) {
        if (!Auth::guard('peserta')->check()) return redirect()->route('auth.login')->with('error','Silakan masuk atau daftar terlebih dahulu.');
        return $next($request);
    }
}