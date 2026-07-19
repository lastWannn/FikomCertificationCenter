<?php

namespace App\Http\Requests\Admin\Informasi;

use Illuminate\Foundation\Http\FormRequest;

class StoreInformasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'          => 'required|string|max:255',
            'isi'            => 'required_if:jenis,faq|nullable|string',
            'jenis'          => 'required|in:info,faq',
            'tayang_mulai'   => 'nullable|date',
            'tayang_selesai' => 'nullable|date|after_or_equal:tayang_mulai',
        ];
    }
}
