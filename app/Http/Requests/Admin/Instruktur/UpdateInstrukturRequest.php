<?php
namespace App\Http\Requests\Admin\Instruktur;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInstrukturRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('instruktur')?->id;
        return ['nama'=>'required|string|max:150',"email"=>"required|email|unique:instruktur,email,{$id}",
                'no_hp'=>'required|string|max:20','keahlian'=>'required|string|max:200',
                'password'=>'nullable|string|min:8','alamat'=>'nullable|string|max:500'];
    }
}
