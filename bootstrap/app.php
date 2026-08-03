<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Pengecualian CSRF untuk rute Autentikasi Publik (mencegah error CSRF mismatch / 419)
        $middleware->validateCsrfTokens(except: [
            'daftar',
            'masuk',
            'lupa-password',
            'daftar/*',
            'lupa-password/*',
        ]);

        // Alias middleware
        $middleware->alias([
            'auth.admin'      => \App\Http\Middleware\AuthAdmin::class,
            'auth.peserta'    => \App\Http\Middleware\AuthPeserta::class,
            'auth.instruktur' => \App\Http\Middleware\AuthInstruktur::class,
            'guest.fcc'       => \App\Http\Middleware\GuestFcc::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // JSON untuk API dan AJAX
        $exceptions->shouldRenderJsonWhen(fn (Request $request) => $request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->is('api/*'));

        // Redirect ke halaman login FCC jika belum auth
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return redirect()->route('auth.login')
                             ->with('error', 'Silakan masuk terlebih dahulu.');
        });
    })->create();
