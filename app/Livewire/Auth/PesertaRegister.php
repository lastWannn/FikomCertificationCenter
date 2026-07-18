<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PesertaRegister extends Component
{
    public string $nama = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $alamat = '';

    public string $jenis_kelamin = '';

    public string $instansi = '';

    public string $no_hp = '';

    public function register()
    {
        $data = $this->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'alamat' => ['nullable', 'string'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
        ]);

        unset($data['password_confirmation']);

        $peserta = DB::transaction(function () use ($data) {
            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'peserta',
            ]);

            $user->pesertaDetail()->create([
                'alamat' => $data['alamat'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'instansi' => $data['instansi'],
                'no_hp' => $data['no_hp'],
            ]);

            return $user;
        });

        Auth::login($peserta);

        request()->session()->regenerate();

        return redirect()->route('peserta.dashboard');
    }

    public function render()
    {
        return view('livewire.auth.peserta-register');
    }
}
