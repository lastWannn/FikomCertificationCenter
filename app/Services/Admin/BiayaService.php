<?php

namespace App\Services\Admin;

use App\Models\BiayaKegiatan;

class BiayaService
{
    public function create(array $data): BiayaKegiatan
    {
        unset($data['_token'], $data['_method']);
        return BiayaKegiatan::create($data);
    }

    public function update(BiayaKegiatan $biaya, array $data): BiayaKegiatan
    {
        unset($data['_token'], $data['_method']);
        $biaya->update($data);
        return $biaya->fresh();
    }

    public function delete(BiayaKegiatan $biaya): void
    {
        $biaya->delete();
    }
}
