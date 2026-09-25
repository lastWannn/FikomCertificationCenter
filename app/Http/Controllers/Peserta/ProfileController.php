<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Peserta\UpdateProfilePesertaRequest;
use App\Services\Peserta\ProfileService;
use App\Services\Auth\OtpService;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $service,
        private OtpService $otpService
    ) {}

    public function edit() {
        $peserta = Auth::guard('peserta')->user();
        $otpHint = null;
        if (!empty($peserta->pending_email) && (config('app.debug') || config('app.env') === 'local')) {
            $otpRecord = OtpCode::where('email', $peserta->pending_email)->where('type', 'change_email')->latest()->first();
            $otpHint = $otpRecord?->otp;
        }
        return view('peserta.profile', compact('peserta', 'otpHint'));
    }

    public function update(UpdateProfilePesertaRequest $request) {
        $data = $request->validated();
        if ($request->hasFile('foto')) $data['foto'] = $request->file('foto');
        
        $result = $this->service->update(Auth::guard('peserta')->user(), $data);

        if ($result['emailChanged']) {
            $this->otpService->generateAndSend($result['newEmail'], 'change_email');

            $infoMsg = "Profil diperbarui! Kode OTP 4-digit telah dikirimkan ke email baru Anda ({$result['newEmail']}). Masukkan kode OTP untuk menyelesaikan pergantian email.";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'     => true,
                    'require_otp' => true,
                    'new_email'   => $result['newEmail'],
                    'message'     => $infoMsg
                ]);
            }

            return back()
                ->with('require_otp_change_email', true)
                ->with('pending_email', $result['newEmail'])
                ->with('info', $infoMsg);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'require_otp' => false,
                'message' => 'Profil berhasil diperbarui.'
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function verifyEmailOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:4']);

        $peserta = Auth::guard('peserta')->user();

        if (empty($peserta->pending_email)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada permintaan pergantian email yang pending.'], 422);
            }
            return back()->with('error', 'Tidak ada permintaan pergantian email yang pending.');
        }

        $newEmail = $peserta->pending_email;
        $this->otpService->verify($newEmail, $request->otp, 'change_email');

        $oldEmail = $peserta->email;
        $peserta->update([
            'email'             => $newEmail,
            'pending_email'     => null,
            'email_verified_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Alamat email Anda berhasil diperbarui dari {$oldEmail} menjadi {$newEmail}.",
                'redirect' => route('peserta.profile')
            ]);
        }

        return redirect()->route('peserta.profile')
            ->with('success', "Alamat email Anda berhasil diperbarui dari {$oldEmail} menjadi {$newEmail}.");
    }

    public function resendEmailOtp(Request $request)
    {
        $peserta = Auth::guard('peserta')->user();

        if (empty($peserta->pending_email)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada permintaan pergantian email.'], 422);
            }
            return back()->with('error', 'Tidak ada permintaan pergantian email.');
        }

        $latestOtp = OtpCode::where('email', $peserta->pending_email)
            ->where('type', 'change_email')
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

        $this->otpService->generateAndSend($peserta->pending_email, 'change_email');

        $msg = "Kode OTP baru telah dikirim ulang ke {$peserta->pending_email}.";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg
            ]);
        }

        return back()
            ->with('require_otp_change_email', true)
            ->with('pending_email', $peserta->pending_email)
            ->with('success', $msg);
    }

    public function cancelEmailChange(Request $request)
    {
        $peserta = Auth::guard('peserta')->user();
        $peserta->update(['pending_email' => null]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permintaan pergantian email telah dibatalkan.'
            ]);
        }

        return back()->with('info', 'Permintaan pergantian email telah dibatalkan.');
    }
}
