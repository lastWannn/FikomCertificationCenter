<?php

namespace App\Services\Admin;

use App\Models\MateriPelatihan;
use App\Models\Pelatihan;
use Illuminate\Http\UploadedFile;

class MateriPelatihanService
{
    public function create(Pelatihan $pelatihan, array $data): MateriPelatihan
    {
        $data['pelatihan_id'] = $pelatihan->id;
        $data['urutan']       = $pelatihan->materi()->max('urutan') + 1;

        if (isset($data['file_materi']) && $data['file_materi'] instanceof UploadedFile) {
            $data['file_materi'] = $data['file_materi']->store('materi/pelatihan', 'public');
        } elseif (!empty($data['link_materi'])) {
            $data['file_materi'] = $data['link_materi'];
        }

        unset($data['_token'], $data['_method'], $data['link_materi']);
        return MateriPelatihan::create($data);
    }

    public function update(MateriPelatihan $materi, array $data): MateriPelatihan
    {
        if (isset($data['file_materi']) && $data['file_materi'] instanceof UploadedFile) {
            $data['file_materi'] = $data['file_materi']->store('materi/pelatihan', 'public');
        } elseif (!empty($data['link_materi'])) {
            $data['file_materi'] = $data['link_materi'];
        }

        unset($data['_token'], $data['_method'], $data['link_materi']);
        $materi->update($data);
        return $materi->fresh();
    }

    public function delete(Pelatihan $pelatihan, MateriPelatihan $materi): void
    {
        $materi->delete();

        // Re-ordering logic
        $pelatihan->materi()
            ->orderBy('urutan')
            ->get()
            ->each(function ($m, $i) {
                $m->update(['urutan' => $i + 1]);
            });
    }

    public function reorder(array $order): void
    {
        foreach ($order as $i => $id) {
            MateriPelatihan::where('id', $id)->update(['urutan' => $i + 1]);
        }
    }
}
