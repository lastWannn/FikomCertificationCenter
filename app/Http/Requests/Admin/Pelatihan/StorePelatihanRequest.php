<?php
namespace App\Http\Requests\Admin\Pelatihan;
use Illuminate\Foundation\Http\FormRequest;

class StorePelatihanRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['kode'=>'required|string|max:20|unique:pelatihan,kode','judul'=>'required|string|max:255',
                'isi'=>'required|string','kategori_id'=>'required|exists:kategori,id',
                'instruktur_id'=>'required|exists:instruktur,id','gambar'=>'nullable|image|max:2048'];
    }
    public function messages(): array {
        return ['kode.unique'=>'Kode pelatihan sudah digunakan.','gambar.image'=>'File harus berupa gambar.','gambar.max'=>'Maks 2MB.'];
    }
}
