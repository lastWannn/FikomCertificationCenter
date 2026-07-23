<?php
namespace App\Http\Requests\Admin\Pelatihan;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePelatihanRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('pelatihan')?->id;
        return [
            'kode'=>"required|string|max:20|unique:pelatihan,kode,{$id}",
            'judul'=>'required|string|max:255',
            'isi'=>'required|string',
            'kategori_id'=>'required|exists:kategori,id',
            'prasyarat_id'=>'nullable|exists:pelatihan,id',
            'link_materi'=>'nullable|string',
            'gambar'=>'nullable|image|max:2048',
            
            // Jadwal Terakhir (Opsional)
            'tgl_pelaksanaan' => 'nullable|date',
            'tgl_batas_daftar' => 'nullable|date',
            'jam_mulai' => 'nullable|string',
            'jam_selesai' => 'nullable|string',
            'kuota_peserta' => 'nullable|integer|min:1|max:500',
        ];
    }
}
