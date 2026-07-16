<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdateProfileAdminRequest;
use Illuminate\Support\Facades\{Auth, Hash};

class ProfileController extends Controller
{
    public function edit() {
        return view('admin.profile', ['admin' => Auth::guard('admin')->user()]);
    }
    public function update(UpdateProfileAdminRequest $request) {
        $admin = Auth::guard('admin')->user();
        $data  = $request->only('nama','email');
        if ($request->filled('password')) $data['password'] = Hash::make($request->password);
        $admin->update($data);
        return back()->with('success','Profil berhasil diperbarui.');
    }
}
