<?php
namespace App\Http\Requests\Auth;

use App\Rules\ValidEmailAddress;
use App\Rules\UniqueEmailAcrossRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'nama'     => 'required|string|max:150',
            'email'    => ['required', 'string', new ValidEmailAddress(), new UniqueEmailAcrossRoles()],
            'no_hp'    => ['required', 'string', 'max:20', 'regex:/^[0-9\+\-\(\)\/\s]+$/'],
            'kelamin'  => 'required|in:L,P',
            'instansi' => 'nullable|string|max:200',
            'password' => ['required', 'confirmed', Password::min(8)],
            'agree'    => 'accepted'
        ];
    }
    public function messages(): array {
        return [
            'no_hp.regex'        => 'Nomor HP hanya boleh berisi angka dan simbol (+, -, (), spasi).',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'agree.accepted'     => 'Anda harus menyetujui syarat & ketentuan.'
        ];
    }
}
