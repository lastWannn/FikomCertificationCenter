<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('auth.login')
                ->withErrors(['email' => 'Integrasi Google OAuth belum dikonfigurasi. Harap isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di file .env terlebih dahulu.']);
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // Jika pengguna membatalkan login di halaman Google
        if (request()->has('error') || ! request()->has('code')) {
            return redirect()->route('auth.login')
                ->withErrors(['email' => 'Proses masuk dengan akun Google telah dibatalkan.']);
        }

        try {
            try {
                $googleUser = Socialite::driver('google')->stateless()->user();
            } catch (\Exception $statelessEx) {
                $googleUser = Socialite::driver('google')->user();
            }
            
            // Cari peserta berdasarkan email (termasuk akun soft deleted)
            $peserta = Peserta::withTrashed()->where('email', $googleUser->getEmail())->first();
            $isNewAccount = false;

            if (! $peserta) {
                // Jika belum ada sama sekali, buat peserta baru
                $peserta = Peserta::create([
                    'nama'              => $googleUser->getName() ?? 'Peserta Google',
                    'email'             => $googleUser->getEmail(),
                    'no_hp'             => '',
                    'kelamin'           => 'L',
                    'password'          => Hash::make(Str::random(16)),
                    'status_akun'       => 'aktif',
                    'email_verified_at' => now(),
                ]);
                $isNewAccount = true;
            } else {
                // Jika akun sebelumnya di-hapus (Soft Delete), pulihkan (restore) dan perlakukan sebagai pendaftaran baru
                if ($peserta->trashed()) {
                    $peserta->restore();
                    $peserta->update([
                        'nama'              => $googleUser->getName() ?? $peserta->nama,
                        'email_verified_at' => now(),
                    ]);
                    $isNewAccount = true;
                } else if (is_null($peserta->email_verified_at)) {
                    $peserta->update(['email_verified_at' => now()]);
                }
            }

            Auth::guard('peserta')->login($peserta, true);
            request()->session()->regenerate();

            // Jika akun baru DARI GOOGLE / dipulihkan atau nama masih berisi default
            if ($isNewAccount || Str::contains(strtolower($peserta->nama), ['peserta', 'google', 'user'])) {
                return redirect()->route('peserta.profile')
                    ->with('info', 'Selamat datang! Akun Google Anda berhasil terhubung. Harap periksa dan lengkapi Nama Lengkap Resmi Anda untuk keperluan cetak sertifikat.');
            }

            return redirect()->route('peserta.dashboard')
                ->with('success', 'Selamat datang kembali, ' . $peserta->nama . '!');

        } catch (\Exception $e) {
            return redirect()->route('auth.login')
                ->withErrors(['email' => 'Gagal masuk dengan Google: ' . $e->getMessage()]);
        }
    }
}
