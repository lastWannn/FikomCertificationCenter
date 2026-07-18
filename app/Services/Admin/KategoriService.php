<?php

namespace App\Services\Admin;

use App\Models\Kategori;

class KategoriService
{
    public function create(array $data)
    {
        return Kategori::create(['nama_kategori' => $data['nama_kategori']]);
    }

    public function update(string $hashid, array $data): void
    {
        $kat = Kategori::findByHashidOrFail($hashid);
        $kat->update(['nama_kategori' => $data['nama_kategori']]);
    }

    public function delete(string $hashid): void
    {
        $kat = Kategori::findByHashidOrFail($hashid);
        if ($kat->pelatihan()->count() > 0 || $kat->sertifikasi()->count() > 0) {
            throw new \RuntimeException('Kategori masih digunakan oleh program pelatihan atau sertifikasi.');
        }
        $kat->delete();
    }
}
