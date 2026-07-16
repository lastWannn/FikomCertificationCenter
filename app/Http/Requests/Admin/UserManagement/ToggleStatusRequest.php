<?php
namespace App\Http\Requests\Admin\UserManagement;
use Illuminate\Foundation\Http\FormRequest;

class ToggleStatusRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array { return ['status'=>'required|in:aktif,nonaktif,ditangguhkan']; }
    public function messages(): array { return ['status.in'=>'Status tidak valid.']; }
}
