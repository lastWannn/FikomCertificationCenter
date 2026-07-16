<?php
namespace App\Http\Requests\Admin\Pembayaran;
use Illuminate\Foundation\Http\FormRequest;

class VerifikasiPembayaranRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array { return ['no_kwitansi'=>'nullable|string|max:50']; }
}
