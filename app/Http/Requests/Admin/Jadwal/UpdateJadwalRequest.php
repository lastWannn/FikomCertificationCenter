<?php
namespace App\Http\Requests\Admin\Jadwal;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['nama_kegiatan'=>'nullable|string|max:255',
                'nama_jenis_biaya'=>'nullable|array',
                'nama_jenis_biaya.*'=>'required_with:nama_jenis_biaya|string|max:100',
                'nominal_biaya'=>'nullable|array',
                'nominal_biaya.*'=>'required_with:nominal_biaya|numeric|min:0',
                'kuota_peserta'=>'required|integer|min:1|max:500','untuk_peserta'=>'required|in:L,P,LP',
                'tgl_batas_daftar'=>'required|date|before_or_equal:tgl_pelaksanaan',
                'tgl_pelaksanaan'=>'required|date',
                'jam_mulai'=>'required','jam_selesai'=>'required|after:jam_mulai'];
    }
}
