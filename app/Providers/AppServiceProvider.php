<?php

namespace App\Providers;

use App\Services\HashidService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // HashidService — singleton untuk performa (cache instance per-model)
        $this->app->singleton(HashidService::class, fn() => new HashidService());
        $this->app->alias(HashidService::class, 'hashids');
    }

    public function boot(): void
    {
        // Paksa HTTPS di production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Konsisten dengan APP_URL (penting untuk Hashid URL + Livewire request)
        // Hanya dipaksa di production — di lokal biarkan Laravel deteksi otomatis
        // dari request (mis. http://127.0.0.1:8000 saat pakai `php artisan serve`).
        if (app()->environment('production') && ($appUrl = config('app.url'))) {
            URL::forceRootUrl($appUrl);
        }

        /**
         * Livewire redirect: saat user belum login mencoba akses halaman auth-protected.
         * Route 'auth.login' adalah Livewire component kita.
         */
        Authenticate::redirectUsing(fn(Request $request) => route('auth.login'));

        /**
         * Livewire redirect: saat user sudah login mencoba akses halaman guest.
         * Cek setiap guard kita secara berurutan.
         */
        RedirectIfAuthenticated::redirectUsing(function (Request $request) {
            // Cek guard admin
            if (auth('admin')->check()) {
                return route('admin.dashboard');
            }

            // Cek guard peserta
            if (auth('peserta')->check()) {
                return route('peserta.dashboard');
            }

            // Cek guard instruktur (jika ada dashboardnya)
            if (auth('instruktur')->check()) {
                return route_exists('instruktur.dashboard')
                    ? route('instruktur.dashboard')
                    : route('landing.index');
            }

            return route('landing.index');
        });
    }
}
