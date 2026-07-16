<?php
namespace App\Services\Peserta;

use App\Models\Peserta;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function update(Peserta $peserta, array $data): Peserta
    {
        $payload = collect($data)->only(['nama','email','no_hp','alamat','instansi'])->toArray();

        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            $payload['foto'] = $data['foto']->store('foto-peserta', 'public');
        }
        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }
        $peserta->update($payload);
        return $peserta->fresh();
    }
}
