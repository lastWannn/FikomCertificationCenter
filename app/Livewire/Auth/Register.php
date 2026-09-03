<?php

namespace App\Livewire\Auth;

use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Livewire Register Component (Peserta)
 *
 * Adaptasi dari PesertaRegister teman, disesuaikan dengan:
 * - Model Peserta kita (tabel 'peserta', bukan 'users')
 * - Guard 'peserta' kita (bukan guard 'web')
 * - Kolom kelamin (L/P) vs jenis_kelamin (Laki-laki/Perempuan)
 * - Validasi yang sama dengan RegisterRequest kita
 */
#[Layout('layouts.auth')]
#[Title('Daftar — FCC UMI')]
class Register extends Component
{
    public string $nama                  = '';
    public string $email                 = '';
    public string $no_hp                 = '';
    public string $kelamin               = '';
    public string $instansi              = '';
    public string $password              = '';
    public string $password_confirmation = '';
    public bool   $agree                 = false;
    public bool   $showPassword          = false;

    public function register(): void
    {
        $this->validate([
            'nama'                  => ['required', 'string', 'max:150'],
            'email'                 => ['required', 'email', 'unique:peserta,email'],
            'no_hp'                 => ['required', 'string', 'max:20', 'regex:/^[0-9\+\-\(\)\/\s]+$/'],
            'kelamin'               => ['required', 'in:L,P'],
            'instansi'              => ['nullable', 'string', 'max:200'],
            'password'              => ['required', 'confirmed', Password::min(8)],
            'agree'                 => ['accepted'],
        ], [
            'no_hp.regex'        => 'Nomor HP hanya boleh berisi angka dan simbol (+, -, (), spasi).',
            'email.unique'       => 'Email sudah terdaftar. Coba login atau gunakan email lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'agree.accepted'     => 'Anda harus menyetujui syarat & ketentuan.',
            'kelamin.required'   => 'Pilih jenis kelamin.',
        ]);

        $peserta = Peserta::create([
            'nama'     => $this->nama,
            'email'    => $this->email,
            'no_hp'    => $this->no_hp,
            'kelamin'  => $this->kelamin,
            'instansi' => $this->instansi ?: null,
            'password' => Hash::make($this->password),
        ]);

        // Login menggunakan guard peserta (bukan guard web)
        Auth::guard('peserta')->login($peserta);
        request()->session()->regenerate();

        $this->redirect(route('peserta.dashboard'), navigate: true);
    }

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
