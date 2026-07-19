<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;

class RegisterController extends Controller
{
    public function __construct(private RegisterService $service) {}

    public function showRegister() { return view('auth.register'); }

    public function register(RegisterRequest $request)
    {
        $peserta = $this->service->register($request->validated());
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('peserta.dashboard'),
                'message' => 'Akun berhasil dibuat! Selamat datang, '.$peserta->nama.'.'
            ]);
        }
        return redirect()->route('peserta.dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, '.$peserta->nama.'.');
    }
}
