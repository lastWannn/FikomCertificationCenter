<?php
namespace App\Http\Requests\Peserta;
use App\Rules\UniqueEmailAcrossRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfilePesertaRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = Auth::guard('peserta')->id();
        return ['nama'=>'required|string|max:150','email'=>['required','email',new UniqueEmailAcrossRoles('peserta', $id)],
                'no_hp'=>'required|string|max:20','alamat'=>'nullable|string|max:500',
                'instansi'=>'nullable|string|max:200','foto'=>'nullable|image|max:2048',
                'password'=>'nullable|string|min:8|confirmed'];
    }
    public function messages(): array {
        return ['email.unique'=>'Email sudah digunakan akun lain.','password.confirmed'=>'Konfirmasi password tidak cocok.'];
    }
}
