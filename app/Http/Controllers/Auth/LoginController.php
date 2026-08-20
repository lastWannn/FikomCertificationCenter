<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(private AuthService $service, private \App\Services\Auth\OtpService $otpService) {}

    public function showLogin()  { return view('auth.login'); }
    public function showForgot() { return view('auth.forgot'); }

    public function login(LoginRequest $request)
    {
        try {
            $result   = $this->service->login($request->only('email','password'), $request->boolean('remember'));
            $request->session()->regenerate();
            $redirect = match ($result['guard']) {
                'admin'      => 'admin.dashboard',
                default      => 'peserta.dashboard',
            };
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route($redirect),
                    'message' => 'Selamat datang, '.$result['user']->nama.'!'
                ]);
            }
            
            return redirect()->route($redirect)
                ->with('success', 'Selamat datang, '.$result['user']->nama.'!');
        } catch (ValidationException $e) {
            $peserta = \App\Models\Peserta::where('email', $request->email)->first();
            if ($peserta && is_null($peserta->email_verified_at)) {
                if ($request->ajax()) {
                    return response()->json([
                        'success'     => false,
                        'require_otp' => true,
                        'email'       => $peserta->email,
                        'message'     => 'Akun Anda belum memverifikasi OTP. Kode OTP 4-digit baru telah dikirimkan ke email Anda.'
                    ]);
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput($request->only('email'));
        }
    }

    public function sendReset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', new \App\Rules\ValidEmailAddress()]
        ], [
            'email.required' => 'Email wajib diisi.'
        ]);
        $exists = \App\Models\Peserta::where('email',$request->email)->exists()
               || \App\Models\Admin::where('email',$request->email)->exists();
        if (!$exists) {
            if ($request->ajax()) {
                return response()->json(['errors' => ['email' => ['Email tidak terdaftar.']]], 422);
            }
            return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.'])->withInput();
        }
        
        $this->otpService->generateAndSend($request->email, 'reset_password');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'require_otp' => true,
                'email' => $request->email,
                'message' => 'Kode OTP 4 digit telah dikirim ke email Anda.'
            ]);
        }
        return back()->with('success','Kode OTP telah dikirim. Periksa inbox Anda.');
    }

    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'string', new \App\Rules\ValidEmailAddress()],
            'otp'      => 'required|digits:4',
            'password' => 'required|min:8|confirmed'
        ]);

        $this->otpService->verify($request->email, $request->otp, 'reset_password');

        $peserta = \App\Models\Peserta::where('email', $request->email)->first();
        if ($peserta) {
            $peserta->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        } else {
            $admin = \App\Models\Admin::where('email', $request->email)->first();
            if ($admin) $admin->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('auth.login'),
                'message' => 'Password berhasil diubah. Silakan masuk menggunakan password baru.'
            ]);
        }
        return redirect()->route('auth.login')->with('success', 'Password berhasil diubah.');
    }

    public function logout(Request $request)
    {
        $this->service->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing.index')->with('success','Anda berhasil keluar.');
    }
}
