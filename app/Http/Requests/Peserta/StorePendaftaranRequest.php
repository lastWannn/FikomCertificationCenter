<?php
namespace App\Http\Requests\Peserta;
use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['biaya_kegiatan_id'=>'nullable|exists:biaya_kegiatan,id'];
    }
}
