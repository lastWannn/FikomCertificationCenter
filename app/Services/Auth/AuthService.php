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
            $status = $peserta->status_akun ?? 'aktif';

            if ($status === 'nonaktif') {
                Auth::guard('peserta')->logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda telah dinonaktifkan oleh admin. Silakan hubungi admin FCC.',
                ]);
            }

            if ($status === 'ditangguhkan') {
                Auth::guard('peserta')->logout();
                throw ValidationException::withMessages([
                    'email' => 'Akun Anda telah ditangguhkan. Hubungi admin FCC.',
                ]);
            }

            // Wajibkan verifikasi OTP email untuk peserta
            if (is_null($peserta->email_verified_at)) {
                Auth::guard('peserta')->logout();
                
                // Kirim ulang kode OTP 4 digit
                try {
                    app(\App\Services\Auth\OtpService::class)->generateAndSend($peserta->email, 'register');
                } catch (\Throwable $t) {}

                throw ValidationException::withMessages([
                    'email' => ['Akun Anda belum memverifikasi kode OTP 4-digit. Kode OTP baru telah dikirimkan ke ' . $peserta->email . '. Silakan periksa email Anda.'],
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
