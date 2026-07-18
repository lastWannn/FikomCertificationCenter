<?php

namespace App\Http\Requests\Admin\Rekening;

use Illuminate\Foundation\Http\FormRequest;

class StoreRekeningRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_pemilik' => 'required|string|max:150',
            'bank'         => 'required|string|max:100',
            'no_rekening'  => 'required|string|max:50',
        ];
    }
}
