@extends('layouts.admin')
@section('title','Manajemen Admin')
@section('page-title','Manajemen Admin & Pengelola')

@section('page-content')
<div style="padding:24px;">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(16,185,129,0.12);border:1.5px solid rgba(16,185,129,0.3);color:#059669;font-weight:700;font-size:13px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#059669;cursor:pointer;font-size:16px;font-weight:900;">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.12);border:1.5px solid rgba(239,68,68,0.3);color:#DC2626;font-weight:700;font-size:13px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('error') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#DC2626;cursor:pointer;font-size:16px;font-weight:900;">&times;</button>
    </div>
    @endif

    {{-- Header & Add Button --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:14px;">
        <div>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Manajemen Akun Admin</h1>
            <p style="color:#6B7280;font-size:13.5px;margin:0;">Kelola hak akses akun pengelola sistem FCC (Super Admin & Admin Biasa).</p>
        </div>

        <button type="button" onclick="openAddModal()" class="fcc-btn-gold" style="padding:10px 20px;font-size:13.5px;font-weight:800;border-radius:10px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
            @include('components.icon',['name'=>'plus','size'=>16]) Tambah Admin Baru
        </button>
    </div>

    {{-- Toolbar Filter & Search Bar --}}
    <div class="fcc-card" style="padding:16px 20px;margin-bottom:20px;border-radius:16px;">
        <form method="GET" action="{{ route('admin.pengguna.admin.index') }}" style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;">
            
            {{-- Search Bar --}}
            <div style="position:relative;flex:1;min-width:240px;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9CA3B0;display:flex;pointer-events:none;">
                    @include('components.icon', ['name'=>'search', 'size'=>15])
                </span>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari nama atau email admin..."
                       class="fcc-input" style="padding-left:36px;font-size:13px;height:38px;background:#FFF;"
                       autocomplete="off">
            </div>

            {{-- Dropdown Filters --}}
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <select name="role" class="fcc-input" style="width:auto;font-size:12.5px;height:38px;padding-top:0;padding-bottom:0;background:#FFF;cursor:pointer;" onchange="this.form.submit()">
                    <option value="">Semua Role Access</option>
                    <option value="super_admin" {{ request('role')==='super_admin'?'selected':'' }}>Super Admin</option>
                    <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin Biasa</option>
                </select>

                <button type="submit" class="fcc-btn-gold" style="padding:8px 16px;font-size:12.5px;height:38px;cursor:pointer;">
                    Cari
                </button>

                @if(request('q') || request('role'))
                <a href="{{ route('admin.pengguna.admin.index') }}" class="fcc-btn-outline-dark" style="padding:8px 14px;font-size:12.5px;height:38px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;background:#FFF;border:1.5px solid #E2E4EB;color:#EF4444;border-radius:10px;font-weight:700;">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel Admin --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;">
        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Nama Admin</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Email Login</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Role Access</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Tgl Dibuat</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $adm)
                    @php
                        $isSuper = $adm->isSuperAdmin();
                        $isSelf  = auth('admin')->id() === $adm->id;
                    @endphp
                    <tr style="border-top:1px solid #F0F1F5;">
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:40px;height:40px;border-radius:12px;background:{{ $isSuper ? '#131218' : '#F3F4F6' }};border:1.5px solid {{ $isSuper ? '#FFC81A' : '#E5E7EB' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @include('components.icon',['name'=>'user','size'=>18,'style'=>"color:".($isSuper ? '#FFC81A' : '#6B7280')])
                                </div>
                                <div>
                                    <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">
                                        {{ $adm->nama }}
                                        @if($isSelf)
                                        <span style="font-size:10px;font-weight:800;background:#E0E7FF;color:#3730A3;padding:2px 6px;border-radius:6px;margin-left:4px;">(Anda)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td style="padding:14px 16px;vertical-align:middle;font-size:13.5px;color:#374151;font-weight:600;">
                            {{ $adm->email }}
                        </td>

                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @if($isSuper)
                            <span style="font-size:11px;font-weight:900;padding:4px 12px;border-radius:20px;background:rgba(255,200,26,0.18);color:#B38F00;border:1px solid rgba(255,200,26,0.4);display:inline-flex;align-items:center;gap:4px;">
                                👑 Super Admin
                            </span>
                            @else
                            <span style="font-size:11px;font-weight:800;padding:4px 12px;border-radius:20px;background:rgba(59,130,246,0.12);color:#2563EB;border:1px solid rgba(59,130,246,0.3);display:inline-flex;align-items:center;gap:4px;">
                                🛡️ Admin Biasa
                            </span>
                            @endif
                        </td>

                        <td style="padding:14px 16px;vertical-align:middle;font-size:12.5px;color:#6B7280;font-weight:500;">
                            {{ $adm->created_at?->format('d M Y') ?? '-' }}
                        </td>

                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:flex;gap:6px;justify-content:center;">
                                {{-- Edit Button --}}
                                <button type="button" onclick="openEditModal({{ json_encode($adm) }})" class="fcc-btn-dark" style="padding:6px 12px;font-size:11.5px;border-radius:8px;" title="Edit Data Admin">
                                    Edit
                                </button>

                                {{-- Delete Button (Cannot delete self or last admin) --}}
                                @if(!$isSelf && $admins->total() > 1)
                                <form action="{{ route('admin.pengguna.admin.destroy', $adm) }}" method="POST" onsubmit="return fccConfirmDelete(event, this, 'Hapus Admin', 'Apakah Anda yakin ingin menghapus akun admin ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="padding:6px 10px;border-radius:8px;border:1px solid rgba(239,68,68,.3);background:rgba(239,68,68,.08);color:#EF4444;font-size:12px;cursor:pointer;" title="Hapus Admin">
                                        @include('components.icon',['name'=>'trash','size'=>13])
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#9CA3B0;">
                            Belum ada akun admin ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($admins->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8F9FB;">
            {{ $admins->links() }}
        </div>
        @endif
    </div>

</div>

{{-- MODAL TAMBAH ADMIN --}}
<div id="add-admin-modal" class="hidden" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;">
    <div style="background:#FFF;border-radius:20px;padding:28px 32px;max-width:480px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.22);position:relative;">
        <button type="button" onclick="closeAddModal()" style="position:absolute;top:18px;right:18px;background:none;border:none;font-size:22px;color:#9CA3B0;cursor:pointer;">&times;</button>
        
        <h3 style="margin:0 0 4px;font-size:18px;font-weight:900;color:#131218;">Tambah Akun Admin Baru</h3>
        <p style="margin:0 0 20px;font-size:12.5px;color:#6B7280;">Buat akun pengelola baru untuk mengakses dashboard admin.</p>

        <form action="{{ route('admin.pengguna.admin.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:12px;font-weight:800;color:#374151;margin-bottom:4px;">Nama Lengkap Admin</label>
                <input type="text" name="nama" required placeholder="Contoh: Ahmad Rizky" class="fcc-input" style="font-size:13px;height:38px;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:12px;font-weight:800;color:#374151;margin-bottom:4px;">Email Login</label>
                <input type="email" name="email" required placeholder="admin@fcc.umi.ac.id" class="fcc-input" style="font-size:13px;height:38px;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:12px;font-weight:800;color:#374151;margin-bottom:4px;">Password Login</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="fcc-input" style="font-size:13px;height:38px;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:12px;font-weight:800;color:#374151;margin-bottom:4px;">Role Hak Akses</label>
                <select name="role" required class="fcc-input" style="font-size:13px;height:38px;cursor:pointer;">
                    <option value="admin">Admin Biasa (Tidak dapat ubah rekening & kelola admin)</option>
                    <option value="super_admin">Super Admin (Akses penuh seluruh sistem)</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeAddModal()" class="fcc-btn-outline-dark" style="padding:8px 16px;font-size:13px;">Batal</button>
                <button type="submit" class="fcc-btn-gold" style="padding:8px 20px;font-size:13px;font-weight:800;">Simpan Admin</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT ADMIN --}}
<div id="edit-admin-modal" class="hidden" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;">
    <div style="background:#FFF;border-radius:20px;padding:28px 32px;max-width:480px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.22);position:relative;">
        <button type="button" onclick="closeEditModal()" style="position:absolute;top:18px;right:18px;background:none;border:none;font-size:22px;color:#9CA3B0;cursor:pointer;">&times;</button>
        
        <h3 style="margin:0 0 4px;font-size:18px;font-weight:900;color:#131218;">Edit Akun Admin</h3>
        <p style="margin:0 0 20px;font-size:12.5px;color:#6B7280;">Perbarui data atau hak akses akun pengelola.</p>

        <form id="edit-admin-form" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:12px;font-weight:800;color:#374151;margin-bottom:4px;">Nama Lengkap Admin</label>
                <input type="text" id="edit-nama" name="nama" required class="fcc-input" style="font-size:13px;height:38px;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:12px;font-weight:800;color:#374151;margin-bottom:4px;">Email Login</label>
                <input type="email" id="edit-email" name="email" required class="fcc-input" style="font-size:13px;height:38px;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:12px;font-weight:800;color:#374151;margin-bottom:4px;">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="fcc-input" style="font-size:13px;height:38px;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:12px;font-weight:800;color:#374151;margin-bottom:4px;">Role Hak Akses</label>
                <select id="edit-role" name="role" required class="fcc-input" style="font-size:13px;height:38px;cursor:pointer;">
                    <option value="admin">Admin Biasa</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeEditModal()" class="fcc-btn-outline-dark" style="padding:8px 16px;font-size:13px;">Batal</button>
                <button type="submit" class="fcc-btn-gold" style="padding:8px 20px;font-size:13px;font-weight:800;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openAddModal() {
    document.getElementById('add-admin-modal').classList.remove('hidden');
}
function closeAddModal() {
    document.getElementById('add-admin-modal').classList.add('hidden');
}
function openEditModal(admin) {
    const form = document.getElementById('edit-admin-form');
    form.action = `/admin/pengguna/admin/${admin.id}`;
    document.getElementById('edit-nama').value = admin.nama;
    document.getElementById('edit-email').value = admin.email;
    document.getElementById('edit-role').value = admin.role || 'admin';
    document.getElementById('edit-admin-modal').classList.remove('hidden');
}
function closeEditModal() {
    document.getElementById('edit-admin-modal').classList.add('hidden');
}
</script>
@endpush
@endsection
