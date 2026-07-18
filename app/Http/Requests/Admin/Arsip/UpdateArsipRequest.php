<?php

namespace App\Http\Requests\Admin\Arsip;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArsipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'         => 'required|string|max:255',
            'ringkasan'     => 'nullable|string',
            'berita_acara'  => 'nullable|file|mimes:pdf,doc,docx,zip,jpeg,jpg,png|max:5120',
        ];
    }
}
