<?php
namespace App\Http\Requests\Peserta;

use Illuminate\Foundation\Http\FormRequest;

class RequestPerpanjanganRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'alasan' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'alasan.max' => 'Alasan maksimal 500 karakter.',
        ];
    }
}
