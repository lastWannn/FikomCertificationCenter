<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
class AuthInstruktur {
    public function handle(Request $request, Closure $next) {
        if (!Auth::guard('instruktur')->check()) return redirect()->route('auth.login')->with('error','Silakan masuk sebagai Instruktur.');
        return $next($request);
    }
}
