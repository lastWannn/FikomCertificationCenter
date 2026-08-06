<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Livewire Login Component
 *
 * Adaptasi dari project teman (riz), disesuaikan dengan sistem
 * multi-guard FCC: admin / peserta / instruktur.
 *
 * - Tidak menggunakan guard tunggal 'web' + kolom role
 * - Mencoba setiap guard secara berurutan
 * - Status akun peserta (ditangguhkan) tetap dicek
 */
#[Layout('layouts.auth')]
#[Title('Masuk — FCC UMI')]
class Login extends Component
{
    public string $email    = '';
    public string $password = '';
    public bool   $remember = false;
    public bool   $showPassword = false;

    public function login(): void
    {
        $this->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = ['email' => $this->email, 'password' => $this->password];

        // ── Guard 1: Admin ──────────────────────────────────────
        if (Auth::guard('admin')->attempt($credentials, $this->remember)) {
            request()->session()->regenerate();
            $this->redirect(route('admin.dashboard'), navigate: true);
            return;
        }

        // ── Guard 2: Peserta ────────────────────────────────────
        if (Auth::guard('peserta')->attempt($credentials, $this->remember)) {
            $peserta = Auth::guard('peserta')->user();
            $status = $peserta->status_akun ?? 'aktif';

            if ($status === 'nonaktif') {
                Auth::guard('peserta')->logout();
                $this->addError('email', 'Akun Anda telah dinonaktifkan oleh admin. Silakan hubungi Admin FCC.');
                return;
            }

            if ($status === 'ditangguhkan') {
                Auth::guard('peserta')->logout();
                $this->addError('email', 'Akun Anda telah ditangguhkan. Hubungi Admin FCC.');
                return;
            }

            request()->session()->regenerate();
            $this->redirect(route('peserta.dashboard'), navigate: true);
            return;
        }

        // Semua guard gagal
        $this->addError('email', 'Email atau password salah. Silakan periksa kembali.');
    }

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
