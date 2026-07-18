<?php
namespace App\Http\Requests\Admin\Nilai;
use Illuminate\Foundation\Http\FormRequest;

class StoreNilaiRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['nilai'=>'required|array|min:1','nilai.*'=>'required|numeric|min:0|max:100'];
    }
    public function messages(): array {
        return ['nilai.required'=>'Minimal satu nilai harus diisi.',
                'nilai.*.numeric'=>'Nilai harus berupa angka.','nilai.*.max'=>'Nilai maksimal 100.'];
    }
}
