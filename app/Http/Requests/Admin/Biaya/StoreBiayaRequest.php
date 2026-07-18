<?php

namespace App\Http\Requests\Admin\Biaya;

use Illuminate\Foundation\Http\FormRequest;

class StoreBiayaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'nama_jenis'  => 'required|string|max:255',
            'nominal'     => 'required|numeric|min:0',
        ];
    }
}
