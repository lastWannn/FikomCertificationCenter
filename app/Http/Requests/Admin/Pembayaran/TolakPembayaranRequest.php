<?php
namespace App\Http\Requests\Admin\Pembayaran;
use Illuminate\Foundation\Http\FormRequest;

class TolakPembayaranRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array { return ['alasan'=>'nullable|string|max:500']; }
}
