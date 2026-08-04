<?php
namespace App\Http\Requests\Admin\Jadwal;
use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalPelatihanRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['nama_kegiatan'=>'nullable|string|max:255',
                'nama_jenis_biaya'=>'nullable|array',
                'nama_jenis_biaya.*'=>'nullable|string|max:100',
                'nominal_biaya'=>'nullable|array',
                'nominal_biaya.*'=>'nullable|numeric|min:0',
                'kuota_peserta'=>'required|integer|min:1|max:500','untuk_peserta'=>'required|in:L,P,LP',
                'tgl_batas_daftar'=>'required|date|before_or_equal:tgl_pelaksanaan',
                'tgl_pelaksanaan'=>'required|date|after_or_equal:today',
                'jam_mulai'=>'required','jam_selesai'=>'required|after:jam_mulai'];
    }
    public function messages(): array {
        return [
            'tgl_batas_daftar.required'        => 'Tanggal batas pendaftaran wajib diisi.',
            'tgl_batas_daftar.date'            => 'Tanggal batas pendaftaran harus berupa tanggal yang valid.',
            'tgl_batas_daftar.before_or_equal' => 'Tanggal batas pendaftaran harus sebelum atau sama dengan tanggal pelaksanaan.',
            'tgl_pelaksanaan.required'         => 'Tanggal pelaksanaan wajib diisi.',
            'tgl_pelaksanaan.date'             => 'Tanggal pelaksanaan harus berupa tanggal yang valid.',
            'tgl_pelaksanaan.after_or_equal'   => 'Tanggal pelaksanaan tidak boleh sebelum hari ini.',
            'kuota_peserta.required'           => 'Kuota peserta wajib diisi.',
            'kuota_peserta.integer'            => 'Kuota peserta harus berupa angka.',
            'kuota_peserta.min'                => 'Kuota peserta minimal 1 orang.',
            'kuota_peserta.max'                => 'Kuota peserta maksimal 500 orang.',
            'jam_mulai.required'               => 'Jam mulai wajib diisi.',
            'jam_selesai.required'             => 'Jam selesai wajib diisi.',
            'jam_selesai.after'                => 'Jam selesai harus setelah jam mulai.',
        ];
    }

    public function attributes(): array {
        return [
            'tgl_batas_daftar' => 'tanggal batas pendaftaran',
            'tgl_pelaksanaan'  => 'tanggal pelaksanaan',
            'kuota_peserta'    => 'kuota peserta',
            'jam_mulai'        => 'jam mulai',
            'jam_selesai'      => 'jam selesai',
        ];
    }
}
