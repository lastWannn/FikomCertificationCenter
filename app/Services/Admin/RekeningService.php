<?php

namespace App\Services\Admin;

use App\Models\Rekening;

class RekeningService
{
    public function create(array $data): Rekening
    {
        unset($data['_token'], $data['_method']);
        return Rekening::create($data);
    }

    public function update(Rekening $rekening, array $data): Rekening
    {
        unset($data['_token'], $data['_method']);
        $rekening->update($data);
        return $rekening->fresh();
    }

    public function delete(Rekening $rekening): void
    {
        $rekening->delete();
    }

    public function aktifkan(Rekening $rekening): void
    {
        $rekening->aktifkan();
    }
}
