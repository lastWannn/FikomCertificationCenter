<?php
namespace App\Http\Requests\Admin\Jadwal;
use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalPelatihanRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['nama_kegiatan'=>'nullable|string|max:255',
                'nama_jenis_biaya'=>'nullable|string|max:100',
                'nominal_biaya'=>'nullable|numeric|min:0',
                'kuota_peserta'=>'required|integer|min:1|max:500','untuk_peserta'=>'required|in:L,P,LP',
                'tgl_batas_daftar'=>'required|date|before_or_equal:tgl_pelaksanaan',
                'tgl_pelaksanaan'=>'required|date|after_or_equal:today',
                'jam_mulai'=>'required','jam_selesai'=>'required|after:jam_mulai'];
    }
    public function messages(): array {
        return ['tgl_batas_daftar.before_or_equal'=>'Batas daftar harus sebelum tanggal pelaksanaan.',
                'tgl_pelaksanaan.after_or_equal'=>'Tanggal pelaksanaan tidak boleh di masa lalu.',
                'jam_selesai.after'=>'Jam selesai harus setelah jam mulai.'];
    }
}
