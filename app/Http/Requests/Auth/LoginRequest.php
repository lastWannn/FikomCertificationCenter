<?php
namespace App\Http\Requests\Auth;

use App\Rules\ValidEmailAddress;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'email'    => ['required', 'string', new ValidEmailAddress()],
            'password' => 'required|string|min:6'
        ];
    }
    public function messages(): array {
        return [
            'email.required'    => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.'
        ];
    }
}
