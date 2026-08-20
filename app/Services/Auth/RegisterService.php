<?php
namespace App\Services\Auth;

use App\Models\Peserta;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register(array $data): Peserta
    {
        $existing = Peserta::withTrashed()->where('email', $data['email'])->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            } else if ($existing->email_verified_at !== null) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => ['Email ini sudah terdaftar dan terverifikasi. Silakan masuk ke akun Anda.']
                ]);
            }

            $existing->update([
                'nama'              => $data['nama'],
                'no_hp'             => $data['no_hp'],
                'kelamin'           => $data['kelamin'],
                'instansi'          => $data['instansi'] ?? null,
                'password'          => Hash::make($data['password']),
                'email_verified_at' => null,
            ]);

            return $existing;
        }

        return Peserta::create([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'no_hp'    => $data['no_hp'],
            'kelamin'  => $data['kelamin'],
            'instansi' => $data['instansi'] ?? null,
            'password' => Hash::make($data['password']),
        ]);
    }
}
