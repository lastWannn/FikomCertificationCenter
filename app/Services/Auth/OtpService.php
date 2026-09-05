<?php

namespace App\Services\Auth;

use App\Models\OtpCode;
use App\Jobs\SendOtpEmailJob;
use Illuminate\Validation\ValidationException;

class OtpService
{
    public function generateAndSend(string $email, string $type = 'register'): string
    {
        // Delete previous OTPs for this email and type
        OtpCode::where('email', $email)->where('type', $type)->delete();

        // Generate 4-digit OTP
        $otp = (string) random_int(1000, 9999);

        OtpCode::create([
            'email' => $email,
            'otp' => $otp,
            'type' => $type,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Log OTP untuk kemudahan pengujian lokal
        \Illuminate\Support\Facades\Log::info("Kode OTP untuk [{$email}] : {$otp}");

        // Dispatch email OTP ke background OS process (0 ms latency untuk pengguna)
        \App\Helpers\AsyncMail::dispatch('otp', $email, "{$otp}:{$type}");

        return $otp;
    }

    public function verify(string $email, string $otp, string $type = 'register'): bool
    {
        $code = OtpCode::where('email', $email)
            ->where('otp', $otp)
            ->where('type', $type)
            ->where('expires_at', '>', now())
            ->first();

        if (!$code) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        // OTP is valid, delete it so it can't be reused
        $code->delete();
        
        return true;
    }
}

