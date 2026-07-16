<?php
namespace App\Http\Requests\Admin\Jadwal;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['kuota_peserta'=>'required|integer|min:1|max:500','untuk_peserta'=>'required|in:L,P,LP',
                'tgl_batas_daftar'=>'required|date','tgl_pelaksanaan'=>'required|date',
                'jam_mulai'=>'required','jam_selesai'=>'required|after:jam_mulai'];
    }
}
