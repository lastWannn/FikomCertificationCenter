<?php

namespace App\Http\Requests\Admin\Sertifikasi;

use Illuminate\Foundation\Http\FormRequest;

class StoreSertifikasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:50|unique:sertifikasi,kode',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image|max:2048',
            
            // Materi Awal (Opsional)
            'judul_materi' => 'nullable|string|max:255',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,zip,rar,ppt,pptx|max:10240',
            'link_materi' => 'nullable|url|max:500',
            
            // Jadwal Awal (Opsional)
            'jadwal_nama_kegiatan' => 'nullable|string|max:255',
            'nama_jenis_biaya' => 'nullable|array',
            'nama_jenis_biaya.*' => 'nullable|string|max:100',
            'nominal_biaya' => 'nullable|array',
            'nominal_biaya.*' => 'nullable|numeric|min:0|max:999999999',
            'kuota_peserta' => 'nullable|integer|min:1|max:500',
            'untuk_peserta' => 'nullable|in:L,P,LP',
            'tgl_batas_daftar' => 'nullable|date',
            'tgl_pelaksanaan' => 'nullable|date',
            'jam_mulai' => 'nullable|string',
            'jam_selesai' => 'nullable|string',
            'langsung_aktifkan' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode sertifikasi wajib diisi.',
            'kode.unique' => 'Kode sertifikasi sudah digunakan.',
            'judul.required' => 'Judul sertifikasi wajib diisi.',
            'isi.required' => 'Deskripsi sertifikasi wajib diisi.',
            'kategori_id.required' => 'Kategori sertifikasi wajib dipilih.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'file_materi.max' => 'Ukuran file materi maksimal 10MB.',
            'file_materi.mimes' => 'Format file materi tidak didukung.',
            'nominal_biaya.*.numeric' => 'Nominal biaya harus berupa angka.',
            'nominal_biaya.*.min' => 'Nominal biaya tidak boleh minus.',
            'nominal_biaya.*.max' => 'Nominal biaya tidak boleh melebihi Rp 999.999.999.',
        ];
    }
}
