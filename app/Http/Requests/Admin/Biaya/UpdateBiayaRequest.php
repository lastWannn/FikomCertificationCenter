<?php

namespace App\Http\Requests\Admin\Biaya;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBiayaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_jenis'  => 'required|string|max:255',
            'nominal'     => 'required|numeric|min:0',
        ];
    }
}
