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
            'nominal'     => 'required|numeric|min:0|max:999999999',
        ];
    }

    public function messages(): array
    {
        return [
            'kegiatan_id.required' => 'Kegiatan wajib dipilih.',
            'kegiatan_id.exists'   => 'Kegiatan yang dipilih tidak valid.',
            'nama_jenis.required'  => 'Nama jenis biaya wajib diisi.',
            'nominal.required'     => 'Nominal biaya wajib diisi.',
            'nominal.numeric'      => 'Nominal biaya harus berupa angka.',
            'nominal.min'          => 'Nominal biaya tidak boleh minus.',
            'nominal.max'          => 'Nominal biaya tidak boleh melebihi Rp 999.999.999.',
        ];
    }
}
