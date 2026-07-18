<?php

namespace App\Http\Requests\Admin\Kegiatan;

use Illuminate\Foundation\Http\FormRequest;

class ToggleBiayaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'aksi' => 'required|in:hapus_semua',
        ];
    }
}
