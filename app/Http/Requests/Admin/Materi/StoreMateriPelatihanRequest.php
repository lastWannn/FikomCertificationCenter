<?php

namespace App\Http\Requests\Admin\Materi;

use Illuminate\Foundation\Http\FormRequest;

class StoreMateriPelatihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul_materi'  => 'required|string|max:255',
            'jam_pelajaran' => 'required|integer|min:1',
            'file_materi'   => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,zip|max:20480',
            'link_materi'   => 'nullable|url|max:500',
        ];
    }
}
