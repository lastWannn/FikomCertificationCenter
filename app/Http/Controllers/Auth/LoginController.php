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
    public function __construct(private AuthService $service) {}

    public function showLogin()  { return view('auth.login'); }
    public function showForgot() { return view('auth.forgot'); }

    public function login(LoginRequest $request)
    {
        try {
            $result   = $this->service->login($request->only('email','password'), $request->boolean('remember'));
            $request->session()->regenerate();
            $redirect = match ($result['guard']) {
                'admin'      => 'admin.dashboard',
                'instruktur' => route_exists('instruktur.dashboard') ? 'instruktur.dashboard' : 'landing.index',
                default      => 'peserta.dashboard',
            };
            return redirect()->route($redirect)
                ->with('success', 'Selamat datang, '.$result['user']->nama.'!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput($request->only('email'));
        }
    }

    /** FIX: Method ini sebelumnya tidak ada → MethodNotFoundError */
    public function sendReset(Request $request)
    {
        $request->validate(['email' => 'required|email'],['email.required'=>'Email wajib diisi.','email.email'=>'Format email tidak valid.']);
        $exists = \App\Models\Peserta::where('email',$request->email)->exists()
               || \App\Models\Admin::where('email',$request->email)->exists()
               || \App\Models\Instruktur::where('email',$request->email)->exists();
        if (!$exists) {
            return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.'])->withInput();
        }
        return back()->with('success','Jika email terdaftar, instruksi reset password telah dikirim. Periksa inbox Anda.');
    }

    public function logout(Request $request)
    {
        $this->service->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing.index')->with('success','Anda berhasil keluar.');
    }
}
