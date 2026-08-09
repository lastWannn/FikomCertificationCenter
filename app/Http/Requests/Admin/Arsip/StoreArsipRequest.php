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
            'kegiatan_id'   => [
                'required',
                'exists:kegiatan,id',
                function ($attribute, $value, $fail) {
                    $kegiatan = \App\Models\Kegiatan::find($value);
                    if ($kegiatan && !$kegiatan->isPassed()) {
                        $fail('Kegiatan belum selesai dilaksanakan dan tidak dapat dimasukkan ke dalam arsip.');
                    }
                },
            ],
            'judul'         => 'required|string|max:255',
            'ringkasan'     => 'nullable|string',
            'berita_acara'           => 'nullable|file|mimes:pdf,doc,docx,zip,jpeg,jpg,png|max:40960',
            'dokumentasi'            => 'nullable|array',
            'dokumentasi.*'          => 'nullable|file|mimes:jpeg,jpg,png,webp,heic,heif|max:40960',
            'uploaded_dokumentasi'   => 'nullable|array',
            'uploaded_dokumentasi.*' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'dokumentasi.*.max'   => 'Salah satu foto dokumentasi yang Anda pilih ukurannya melebihi batas 40MB. Silakan pilih foto dengan ukuran di bawah 40MB.',
            'dokumentasi.*.mimes' => 'Format file foto dokumentasi harus berupa gambar (JPG, JPEG, PNG, WEBP, atau HEIC).',
            'berita_acara.max'    => 'File berita acara melebihi batas ukuran 40MB.',
        ];
    }
}
