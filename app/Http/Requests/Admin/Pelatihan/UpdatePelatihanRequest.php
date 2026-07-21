<?php
namespace App\Http\Requests\Admin\Pelatihan;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePelatihanRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('pelatihan')?->id;
        return ['kode'=>"required|string|max:20|unique:pelatihan,kode,{$id}",'judul'=>'required|string|max:255',
                'isi'=>'required|string','kategori_id'=>'required|exists:kategori,id',
                'gambar'=>'nullable|image|max:2048'];
    }
}
