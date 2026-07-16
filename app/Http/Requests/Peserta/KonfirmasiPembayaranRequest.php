<?php
namespace App\Http\Requests\Peserta;

use Illuminate\Foundation\Http\FormRequest;

class KonfirmasiPembayaranRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'metode_pembayaran' => 'required|string|max:100',
            'nama_pengirim'     => 'required|string|max:150',
            'tgl_transfer'      => 'required|date|before_or_equal:today',
            'jam_transfer'      => 'required',
            // UPDATED: hanya gambar, tidak terima PDF
            'bukti_bayar'       => 'required|file|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'bukti_bayar.required' => 'Foto bukti transfer wajib diunggah.',
            'bukti_bayar.image'    => 'Bukti transfer harus berupa file gambar.',
            'bukti_bayar.mimes'    => 'Format gambar yang didukung: JPG, JPEG, PNG, WebP.',
            'bukti_bayar.max'      => 'Ukuran foto maksimal 5MB.',
            'tgl_transfer.before_or_equal' => 'Tanggal transfer tidak boleh di masa depan.',
        ];
    }
}
