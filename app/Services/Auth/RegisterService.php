<?php
namespace App\Services\Auth;

use App\Models\Peserta;
use Illuminate\Support\Facades\{Auth, Hash};

class RegisterService
{
    public function register(array $data): Peserta
    {
        $peserta = Peserta::create([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'no_hp'    => $data['no_hp'],
            'kelamin'  => $data['kelamin'],
            'instansi' => $data['instansi'] ?? null,
            'password' => Hash::make($data['password']),
        ]);
        Auth::guard('peserta')->login($peserta);
        return $peserta;
    }
}
