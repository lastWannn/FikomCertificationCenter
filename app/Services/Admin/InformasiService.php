<?php

namespace App\Services\Admin;

use App\Models\Informasi;
use Illuminate\Support\Facades\Auth;

class InformasiService
{
    public function create(array $data): Informasi
    {
        if (!isset($data['admin_id'])) {
            $data['admin_id'] = Auth::guard('admin')->id();
        }
        if ($data['jenis'] === 'info' && empty($data['isi'])) {
            $data['isi'] = '';
        }
        unset($data['_token'], $data['_method']);
        return Informasi::create($data);
    }

    public function update(Informasi $informasi, array $data): Informasi
    {
        if ($data['jenis'] === 'info' && empty($data['isi'])) {
            $data['isi'] = '';
        }
        unset($data['_token'], $data['_method']);
        $informasi->update($data);
        return $informasi->fresh();
    }

    public function delete(Informasi $informasi): void
    {
        $informasi->delete();
    }
}
