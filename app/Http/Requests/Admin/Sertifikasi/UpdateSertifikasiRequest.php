<?php

namespace App\Http\Requests\Admin\Sertifikasi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSertifikasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sertifikasi = $this->route('sertifikasi');
        $id = $sertifikasi ? $sertifikasi->id : '';

        return [
            'kode' => 'required|string|max:50|unique:sertifikasi,kode,' . $id,
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'fasilitas_input' => 'nullable|string',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.unique' => 'Kode sertifikasi sudah digunakan.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
