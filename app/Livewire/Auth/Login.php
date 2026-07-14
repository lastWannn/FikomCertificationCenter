<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public function login()
    {
        $credentials = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            $this->addError('email', 'Email atau password salah.');

            return;
        }

        request()->session()->regenerate();

        return redirect()->route(match (Auth::user()->role) {
            'admin' => 'admin.dashboard',
            'instruktur' => 'instruktur.dashboard',
            'peserta' => 'peserta.dashboard',
        });
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
