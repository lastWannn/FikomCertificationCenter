<?php
namespace App\Services\Auth;

use App\Models\{Admin, Peserta};
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Multi-guard login. Returns ['guard' => ..., 'user' => ...]
     * Throws ValidationException jika gagal.
     */
    public function login(array $credentials, bool $remember = false): array
    {
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            return ['guard' => 'admin', 'user' => Auth::guard('admin')->user()];
        }

        if (Auth::guard('peserta')->attempt($credentials, $remember)) {
            $peserta = Auth::guard('peserta')->user();
            if (($peserta->status_akun ?? 'aktif') === 'ditangguhkan') {
                Auth::guard('peserta')->logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda telah ditangguhkan. Hubungi admin FCC.',
                ]);
            }
            return ['guard' => 'peserta', 'user' => $peserta];
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah. Silakan periksa kembali.',
        ]);
    }

    public function logout(): void
    {
        Auth::guard('admin')->logout();
        Auth::guard('peserta')->logout();
    }
}
