<?php

namespace App\Jobs;

use App\Mail\OtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendOtpEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $otp,
        public string $type = 'register',
    ) {}

    public function handle(): void
    {
        try {
            Mail::to($this->email)->send(new OtpMail($this->otp, $this->type));
            Log::info("Email OTP berhasil dikirim ke [{$this->email}]");
        } catch (\Throwable $e) {
            Log::error("Gagal mengirim email OTP ke [{$this->email}]: " . $e->getMessage());
        }
    }
}
