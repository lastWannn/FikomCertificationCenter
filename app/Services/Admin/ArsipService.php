<?php

namespace App\Services\Admin;

use App\Models\ArsipKegiatan;
use Illuminate\Http\UploadedFile;

class ArsipService
{
    public function create(array $data): ArsipKegiatan
    {
        if (isset($data['berita_acara']) && $data['berita_acara'] instanceof UploadedFile) {
            $data['berita_acara'] = $data['berita_acara']->store('arsip', 'public');
        }
        unset($data['_token'], $data['_method']);
        return ArsipKegiatan::create($data);
    }

    public function update(ArsipKegiatan $arsip, array $data): ArsipKegiatan
    {
        if (isset($data['berita_acara']) && $data['berita_acara'] instanceof UploadedFile) {
            $data['berita_acara'] = $data['berita_acara']->store('arsip', 'public');
        }
        unset($data['_token'], $data['_method']);
        $arsip->update($data);
        return $arsip->fresh();
    }

    public function delete(ArsipKegiatan $arsip): void
    {
        $arsip->delete();
    }
}
