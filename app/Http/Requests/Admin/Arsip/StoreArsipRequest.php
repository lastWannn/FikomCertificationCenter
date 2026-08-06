<?php

namespace App\Http\Requests\Admin\Arsip;

use Illuminate\Foundation\Http\FormRequest;

class StoreArsipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kegiatan_id'   => 'required|exists:kegiatan,id',
            'judul'         => 'required|string|max:255',
            'ringkasan'     => 'nullable|string',
            'berita_acara'  => 'nullable|file|mimes:pdf,doc,docx,zip,jpeg,jpg,png|max:5120',
            'dokumentasi'   => 'nullable|array',
            'dokumentasi.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ];
    }
}
