<?php
namespace App\Services\Peserta;

use App\Models\Peserta;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function update(Peserta $peserta, array $data): array
    {
        $payload = collect($data)->only(['nama', 'no_hp', 'alamat', 'instansi', 'pekerjaan'])->toArray();

        if (isset($data['foto']) && $data['foto'] instanceof UploadedFile) {
            try {
                $newFoto = \App\Helpers\ImageHelper::compressToWebp($data['foto'], 'foto-peserta', 80, 800);
                if ($newFoto) {
                    if (!empty($peserta->foto) && \Illuminate\Support\Facades\Storage::disk('public')->exists($peserta->foto)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($peserta->foto);
                    }
                    $payload['foto'] = $newFoto;
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Gagal mengolah foto profil peserta ID {$peserta->id}: " . $e->getMessage());
            }
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
