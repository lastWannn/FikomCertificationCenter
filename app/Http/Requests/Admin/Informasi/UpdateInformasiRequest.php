<?php

namespace App\Http\Requests\Admin\Informasi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'isi'   => 'required|string',
            'jenis' => 'required|in:info,faq',
        ];
    }
}
