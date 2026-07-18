<?php

namespace App\Services\Admin;

use App\Models\MateriSertifikasi;
use App\Models\Sertifikasi;
use Illuminate\Http\UploadedFile;

class MateriSertifikasiService
{
    public function create(Sertifikasi $sertifikasi, array $data): MateriSertifikasi
    {
        $data['sertifikasi_id'] = $sertifikasi->id;
        $data['urutan']         = $sertifikasi->materi()->max('urutan') + 1;

        if (isset($data['file_materi']) && $data['file_materi'] instanceof UploadedFile) {
            $data['file_materi'] = $data['file_materi']->store('materi/sertifikasi', 'public');
        } elseif (!empty($data['link_materi'])) {
            $data['file_materi'] = $data['link_materi'];
        }

        unset($data['_token'], $data['_method'], $data['link_materi']);
        return MateriSertifikasi::create($data);
    }

    public function update(MateriSertifikasi $materi, array $data): MateriSertifikasi
    {
        if (isset($data['file_materi']) && $data['file_materi'] instanceof UploadedFile) {
            $data['file_materi'] = $data['file_materi']->store('materi/sertifikasi', 'public');
        } elseif (!empty($data['link_materi'])) {
            $data['file_materi'] = $data['link_materi'];
        }

        unset($data['_token'], $data['_method'], $data['link_materi']);
        $materi->update($data);
        return $materi->fresh();
    }

    public function delete(MateriSertifikasi $materi): void
    {
        $materi->delete();
    }
}
