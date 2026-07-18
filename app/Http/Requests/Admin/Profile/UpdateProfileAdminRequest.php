<?php
namespace App\Http\Requests\Admin\Profile;
use App\Rules\UniqueEmailAcrossRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileAdminRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = Auth::guard('admin')->id();
        return ['nama'=>'required|string|max:150','email'=>['required','email',new UniqueEmailAcrossRoles('admins', $id)],
                'password'=>'nullable|string|min:8|confirmed'];
    }
}
