<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManagementController extends Controller
{
    private function checkSuperAdmin(): void
    {
        if (!auth('admin')->user()?->isSuperAdmin()) {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang dapat mengelola akun admin.');
        }
    }

    public function index(Request $request)
    {
        $this->checkSuperAdmin();

        $query = Admin::query();

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.pengguna.admin-index', compact('admins'));
    }

    public function store(Request $request)
    {
        $this->checkSuperAdmin();

        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'string', 'max:150', new \App\Rules\ValidEmailAddress(), 'unique:admins,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', Rule::in(['super_admin', 'admin'])],
        ], [
            'nama.required'     => 'Nama admin wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.required'     => 'Role wajib dipilih.',
        ]);

        Admin::create([
            'nama'     => $validated['nama'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('admin.pengguna.admin.index')
            ->with('success', 'Akun admin baru berhasil ditambahkan.');
    }

    public function update(Request $request, Admin $admin)
    {
        $this->checkSuperAdmin();

        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'string', 'max:150', new \App\Rules\ValidEmailAddress(), Rule::unique('admins', 'email')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role'     => ['required', Rule::in(['super_admin', 'admin'])],
        ], [
            'nama.required'  => 'Nama admin wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah terdaftar.',
            'password.min'   => 'Password minimal 6 karakter.',
            'role.required'  => 'Role wajib dipilih.',
        ]);

        $data = [
            'nama'  => $validated['nama'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.pengguna.admin.index')
            ->with('success', 'Data akun admin berhasil diperbarui.');
    }

    public function destroy(Admin $admin)
    {
        $this->checkSuperAdmin();

        if (auth('admin')->id() === $admin->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if (Admin::count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus admin terakhir dalam sistem.');
        }

        $admin->delete();

        return redirect()->route('admin.pengguna.admin.index')
            ->with('success', 'Akun admin berhasil dihapus.');
    }
}
