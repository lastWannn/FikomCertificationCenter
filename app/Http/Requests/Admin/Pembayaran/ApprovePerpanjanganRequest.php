<?php
namespace App\Http\Requests\Admin\Pembayaran;

use Illuminate\Foundation\Http\FormRequest;

class ApprovePerpanjanganRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'jam_tambah' => 'required|integer|min:1|max:72',
            'catatan'    => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'jam_tambah.required' => 'Jumlah jam tambahan wajib diisi.',
            'jam_tambah.min'      => 'Minimal perpanjangan 1 jam.',
            'jam_tambah.max'      => 'Maksimal perpanjangan 72 jam.',
        ];
    }
}
