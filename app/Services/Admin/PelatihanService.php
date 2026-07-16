<?php
namespace App\Services\Admin;

use App\Models\Pelatihan;
use Illuminate\Http\UploadedFile;

class PelatihanService
{
    public function create(array $data): Pelatihan
    {
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $data['gambar'] = $data['gambar']->store('pelatihan', 'public');
        }
        // Jangan kirim _token, _method ke Model
        unset($data['_token'], $data['_method']);
        return Pelatihan::create($data);
    }

    public function update(Pelatihan $pelatihan, array $data): Pelatihan
    {
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $data['gambar'] = $data['gambar']->store('pelatihan', 'public');
        }
        unset($data['_token'], $data['_method']);
        $pelatihan->update($data);
        return $pelatihan->fresh();
    }

    public function delete(Pelatihan $pelatihan): void
    {
        $pelatihan->delete();
    }
}
