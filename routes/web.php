<?php

use App\Livewire\Admin\InstrukturManager;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\PesertaRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::livewire('/login', Login::class)->name('login');
    Route::livewire('/peserta/register', PesertaRegister::class)->name('peserta.register');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    Route::livewire('/instruktur', InstrukturManager::class)->name('instruktur');
});

// Peserta
Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', fn () => view('peserta.dashboard'))->name('dashboard');
});

// Instruktur
Route::middleware(['auth', 'role:instruktur'])->prefix('instruktur')->name('instruktur.')->group(function () {
    Route::get('/dashboard', fn () => view('instruktur.dashboard'))->name('dashboard');
});
