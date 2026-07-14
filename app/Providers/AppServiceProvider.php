<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::anonymousComponentPath(resource_path('views/layouts'), 'layouts');

        Authenticate::redirectUsing(fn () => route('login'));

        RedirectIfAuthenticated::redirectUsing(function (Request $request) {
            return route(match ($request->user()?->role) {
                'instruktur' => 'instruktur.dashboard',
                'peserta' => 'peserta.dashboard',
                default => 'admin.dashboard',
            });
        });
    }
}
