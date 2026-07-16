<?php
namespace App\Http\Requests\Admin\Instruktur;
use Illuminate\Foundation\Http\FormRequest;

class StoreInstrukturRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['no_identitas'=>'required|string|max:50','nama'=>'required|string|max:150',
                'email'=>'required|email|unique:instruktur,email','no_hp'=>'required|string|max:20',
                'kelamin'=>'required|in:L,P','keahlian'=>'required|string|max:200',
                'password'=>'required|string|min:8','alamat'=>'nullable|string|max:500'];
    }
    public function messages(): array {
        return ['email.unique'=>'Email instruktur sudah terdaftar.'];
    }
}
