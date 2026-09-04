<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;

class RegisterController extends Controller
{
    public function __construct(private RegisterService $service, private \App\Services\Auth\OtpService $otpService) {}

    public function showRegister() { return view('auth.register'); }

    public function register(RegisterRequest $request)
    {
        try {
            // Pendaftaran: buat akun (unverified) dan kirim OTP
            $peserta = $this->service->register($request->validated());
            
            $this->otpService->generateAndSend($peserta->email, 'register');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'     => true,
                    'require_otp' => true,
                    'email'       => $peserta->email,
                    'message'     => 'Kode OTP 4 digit telah dikirim ke email Anda.'
                ]);
            }

            return redirect()->route('auth.register')
                ->with('require_otp', true)
                ->with('email', $peserta->email)
                ->with('success', 'Kode OTP 4 digit telah dikirim ke email Anda.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors()
                ], 422);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Register Exception: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors'  => ['system' => ['Gagal pendaftaran: ' . $e->getMessage()]]
                ], 422);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['system' => 'Gagal pendaftaran: ' . $e->getMessage()]);
        }
    }

    public function verifyOtp(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', new \App\Rules\ValidEmailAddress()],
            'otp'   => 'required|digits:4'
        ]);
        
        // Verifikasi OTP
        $this->otpService->verify($request->email, $request->otp, 'register');
        
        // Update user status
        $peserta = \App\Models\Peserta::where('email', $request->email)->firstOrFail();
        $peserta->update(['email_verified_at' => now()]);
        
        // Auto-login
        \Illuminate\Support\Facades\Auth::guard('peserta')->login($peserta);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('peserta.dashboard'),
                'message' => 'Verifikasi berhasil! Selamat datang, '.$peserta->nama.'.'
            ]);
        }
        return redirect()->route('peserta.dashboard')
            ->with('success', 'Verifikasi berhasil! Selamat datang, '.$peserta->nama.'.');
    }

    public function resendOtp(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', new \App\Rules\ValidEmailAddress()],
        ]);

        $email = $request->email;
        $peserta = \App\Models\Peserta::where('email', $email)->first();

        if (!$peserta) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Email tidak terdaftar.'], 404);
            }
            return back()->with('error', 'Email tidak terdaftar.');
        }

        if (!is_null($peserta->email_verified_at)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Email Anda sudah terverifikasi. Silakan masuk.'], 422);
            }
            return back()->with('info', 'Email Anda sudah terverifikasi. Silakan masuk.');
        }

        $latestOtp = \App\Models\OtpCode::where('email', $email)
            ->where('type', 'register')
            ->latest()
            ->first();

        if ($latestOtp && $latestOtp->created_at->gt(now()->subSeconds(60))) {
            $secondsLeft = 60 - now()->diffInSeconds($latestOtp->created_at);
            $msg = "Harap tunggu {$secondsLeft} detik sebelum meminta kode OTP baru.";
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 429);
            }
            return back()->with('error', $msg);
        }

        $this->otpService->generateAndSend($email, 'register');

        $msg = "Kode OTP 4 digit baru telah dikirim ulang ke {$email}.";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg
            ]);
        }

        return back()
            ->with('require_otp', true)
            ->with('email', $email)
            ->with('success', $msg);
    }
}
