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

        $docs = [];
        if (isset($data['dokumentasi']) && is_array($data['dokumentasi'])) {
            foreach ($data['dokumentasi'] as $file) {
                if ($file instanceof UploadedFile) {
                    $docs[] = \App\Helpers\ImageHelper::compressToWebp($file, 'arsip-dokumentasi');
                }
            }
        }
        $data['dokumentasi'] = $docs;

        unset($data['_token'], $data['_method']);
        return ArsipKegiatan::create($data);
    }

    public function update(ArsipKegiatan $arsip, array $data): ArsipKegiatan
    {
        if (isset($data['berita_acara']) && $data['berita_acara'] instanceof UploadedFile) {
            $data['berita_acara'] = $data['berita_acara']->store('arsip', 'public');
        }

        $existingDocs = $arsip->dokumentasi ?? [];
        
        // Hapus foto yang dipilih untuk dihapus
        if (isset($data['delete_dokumentasi']) && is_array($data['delete_dokumentasi'])) {
            $existingDocs = array_values(array_filter($existingDocs, fn($img) => !in_array($img, $data['delete_dokumentasi'])));
        }

        // Tambah foto dokumentasi baru
        if (isset($data['dokumentasi']) && is_array($data['dokumentasi'])) {
            foreach ($data['dokumentasi'] as $file) {
                if ($file instanceof UploadedFile) {
                    $existingDocs[] = \App\Helpers\ImageHelper::compressToWebp($file, 'arsip-dokumentasi');
                }
            }
        }
        $data['dokumentasi'] = array_values($existingDocs);

        unset($data['_token'], $data['_method'], $data['delete_dokumentasi']);
        $arsip->update($data);
        return $arsip->fresh();
    }

    public function delete(ArsipKegiatan $arsip): void
    {
        $arsip->delete();
    }

    public function autoArchiveCompleted(): void
    {
        $kegiatans = \App\Models\Kegiatan::passed()->doesntHave('arsip')->get();
        foreach ($kegiatans as $k) {
            ArsipKegiatan::create([
                'kegiatan_id' => $k->id,
                'judul'       => $k->judul,
                'ringkasan'   => 'Kegiatan ' . $k->judul . ' telah selesai dilaksanakan.',
            ]);
        }
    }
}
