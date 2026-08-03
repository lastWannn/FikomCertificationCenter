<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestFcc
{
    public function handle(Request $request, Closure $next)
    {
        $redirect = null;

        if (Auth::guard('admin')->check()) {
            $redirect = route('admin.dashboard');
        } elseif (Auth::guard('peserta')->check()) {
            $redirect = route('peserta.dashboard');
        }

        if ($redirect) {
            // Untuk AJAX/fetch request, kembalikan JSON agar tidak merusak form modal
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $redirect,
                    'message' => 'Anda sudah login. Mengalihkan ke dashboard...'
                ]);
            }
            return redirect($redirect);
        }

        return $next($request);
    }
}
