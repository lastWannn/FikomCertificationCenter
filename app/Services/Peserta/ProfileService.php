<?php
namespace App\Services\Peserta;

use App\Models\Peserta;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function update(Peserta $peserta, array $data): array
    {
        $payload = collect($data)->only(['nama', 'no_hp', 'alamat', 'instansi'])->toArray();

        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            if (!empty($peserta->foto) && \Illuminate\Support\Facades\Storage::disk('public')->exists($peserta->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($peserta->foto);
            }
            $payload['foto'] = \App\Helpers\ImageHelper::compressToWebp($data['foto'], 'foto-peserta', 80, 800);
        }
        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $emailChanged = false;
        $newEmail = strtolower(trim($data['email'] ?? ''));

        if (!empty($newEmail) && $newEmail !== strtolower($peserta->email)) {
            $payload['pending_email'] = $newEmail;
            $emailChanged = true;
        }

        $peserta->update($payload);

        return [
            'peserta'      => $peserta->fresh(),
            'emailChanged' => $emailChanged,
            'newEmail'     => $newEmail,
        ];
    }
}
