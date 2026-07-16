<?php
namespace App\Http\Requests\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['nama'=>'required|string|max:150','email'=>'required|email|unique:peserta,email',
                'no_hp'=>'required|string|max:20','kelamin'=>'required|in:L,P',
                'instansi'=>'nullable|string|max:200','password'=>['required','confirmed',Password::min(8)],
                'agree'=>'accepted'];
    }
    public function messages(): array {
        return ['email.unique'=>'Email sudah terdaftar.','password.confirmed'=>'Konfirmasi password tidak cocok.',
                'agree.accepted'=>'Anda harus menyetujui syarat & ketentuan.'];
    }
}
