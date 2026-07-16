<?php
namespace App\Http\Requests\Admin\Pembayaran;

use Illuminate\Foundation\Http\FormRequest;

class TolakPerpanjanganRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'catatan' => 'nullable|string|max:500',
        ];
    }
}
