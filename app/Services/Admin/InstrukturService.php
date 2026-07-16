<?php
namespace App\Services\Admin;

use App\Models\Instruktur;
use Illuminate\Support\Facades\Hash;

class InstrukturService
{
    public function create(array $data): Instruktur
    {
        $data['password'] = Hash::make($data['password']);
        return Instruktur::create($data);
    }

    public function update(Instruktur $instruktur, array $data): Instruktur
    {
        $payload = collect($data)->only([
            'no_identitas','nama','email','no_hp','kelamin','alamat','keahlian'
        ])->toArray();

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }
        $instruktur->update($payload);
        return $instruktur->fresh();
    }

    public function delete(Instruktur $instruktur): void
    {
        if ($instruktur->pelatihan()->count()) {
            throw new \RuntimeException('Instruktur masih terkait dengan program pelatihan.');
        }
        $instruktur->delete();
    }
}
