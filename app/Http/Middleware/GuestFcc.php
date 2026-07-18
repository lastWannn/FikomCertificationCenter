<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestFcc
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('peserta')->check()) {
            return redirect()->route('peserta.dashboard');
        }
        if (Auth::guard('instruktur')->check()) {
            return redirect()->route(route_exists('instruktur.dashboard') ? 'instruktur.dashboard' : 'landing.index');
        }
        return $next($request);
    }
}
