@extends('layouts.admin')
@section('title','Manajemen Admin')
@section('page-title','Manajemen Admin & Pengelola')

@section('page-content')
<div style="padding:24px;position:relative;">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <style>
      @keyframes skeletonShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
      }
      .fcc-skeleton-box {
        background: linear-gradient(90deg, #E2E8F0 25%, #F1F5F9 50%, #E2E8F0 75%);
        background-size: 200% 100%;
        animation: skeletonShimmer 1.4s infinite ease-in-out;
        border-radius: 12px;
      }
      #admin-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="admin-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:180px;height:40px;border-radius:30px;"></div>
      </div>
      {{-- Table Skeleton --}}
      <div style="padding:28px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('admin-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(16,185,129,0.12);border:1.5px solid rgba(16,185,129,0.3);color:#059669;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#059669;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.12);border:1.5px solid rgba(239,68,68,0.3);color:#DC2626;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('error') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#DC2626;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
    </div>
    @endif

    {{-- Header & Add Button --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Pengguna &amp; Hak Akses</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Manajemen Akun Admin</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola hak akses akun pengelola sistem FCC (Super Admin &amp; Admin Biasa).</p>
        </div>

        <button type="button" onclick="openAddModal()"
                style="padding:10px 18px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.1);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Admin Baru
        </button>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Akun Pengelola</h3>
            
            <form method="GET" action="{{ route('admin.pengguna.admin.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin:0;">
                {{-- Search Bar --}}
                <div style="position:relative;width:240px;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
                        @include('components.icon', ['name'=>'search', 'size'=>14])
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari nama atau email..."
                           class="fcc-input" style="padding-left:34px;font-size:12.5px;height:36px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;"
                           autocomplete="off">
                </div>

                {{-- Role Dropdown --}}
                <select name="role" class="fcc-input" style="width:auto;font-size:12.5px;height:36px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;" onchange="this.form.submit()">
                    <option value="">Semua Role Access</option>
                    <option value="super_admin" {{ request('role')==='super_admin'?'selected':'' }}>Super Admin</option>
                    <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin Biasa</option>
                </select>

                <button type="submit" style="padding:6px 14px;font-size:12px;height:36px;font-weight:800;background:#131218;color:#FFC81A;border-radius:10px;border:1px solid #131218;cursor:pointer;">
                    Cari
                </button>

                @if(request('q') || request('role'))
                <a href="{{ route('admin.pengguna.admin.index') }}" style="padding:6px 12px;font-size:12px;height:36px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;text-decoration:none;">
                    ✕ Reset
                </a>
                @endif

                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $admins->total() }} Admin</span>
            </form>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Nama Admin</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Email Login</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:170px;">Role Access</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:150px;">Tgl Dibuat</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $adm)
                    @php
                        $isSuper = $adm->isSuperAdmin();
                        $isSelf  = auth('admin')->id() === $adm->id;
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- Nama Admin --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:40px;height:40px;border-radius:10px;background:{{ $isSuper ? '#131218' : '#F1F5F9' }};border:1.5px solid {{ $isSuper ? '#FFC81A' : '#CBD5E1' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @include('components.icon',['name'=>'user','size'=>18,'style'=>"color:".($isSuper ? '#FFC81A' : '#64748B')])
                                </div>
                                <div>
                                    <p style="margin:0;font-size:13.5px;font-weight:900;color:#131218;">
                                        {{ $adm->nama }}
                                        @if($isSelf)
                                        <span style="font-size:10px;font-weight:900;background:#EEF2FF;color:#4F46E5;padding:2px 8px;border-radius:6px;border:1px solid #818CF8;margin-left:4px;">Anda</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Email Login --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;color:#64748B;font-weight:700;">
                            {{ $adm->email }}
                        </td>

                        {{-- Role Access --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @if($isSuper)
                            <span style="font-size:11px;font-weight:900;padding:4px 12px;border-radius:12px;background:#FFFDF5;color:#B38F00;border:1px solid #FFC81A;display:inline-flex;align-items:center;gap:4px;">
                                👑 Super Admin
                            </span>
                            @else
                            <span style="font-size:11px;font-weight:800;padding:4px 12px;border-radius:12px;background:#EEF2FF;color:#4F46E5;border:1px solid #818CF8;display:inline-flex;align-items:center;gap:4px;">
                                🛡️ Admin Biasa
                            </span>
                            @endif
                        </td>

                        {{-- Tgl Dibuat --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:12.5px;color:#64748B;font-weight:700;">
                            📅 {{ $adm->created_at?->format('d M Y') ?? '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:flex;gap:6px;justify-content:center;align-items:center;">
                                {{-- Edit Button --}}
                                <button type="button" onclick="openEditModal({{ json_encode($adm) }})"
                                        style="padding:6px 12px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;cursor:pointer;transition:all .18s;"
                                        onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';" title="Edit Data Admin">
                                    Edit
                                </button>

                                {{-- Delete Button (Cannot delete self or last admin) --}}
                                @if(!$isSelf && $admins->total() > 1)
                                <form action="{{ route('admin.pengguna.admin.destroy', $adm) }}" method="POST" onsubmit="return fccConfirmDelete(event, this, 'Hapus Admin', 'Apakah Anda yakin ingin menghapus akun admin ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="padding:6px 10px;border-radius:8px;border:1px solid #FCA5A5;background:#FEF2F2;color:#EF4444;font-size:12px;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';" title="Hapus Admin">
                                        @include('components.icon',['name'=>'trash','size'=>13])
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'user','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Akun Admin Ditemukan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Klik tombol "Tambah Admin Baru" untuk menambahkan pengelola pertama.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($admins->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;">
            {{ $admins->links() }}
        </div>
        @endif
    </div>

</div>

{{-- MODAL TAMBAH ADMIN --}}
<div id="add-admin-modal" class="hidden" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.6);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border-radius:24px;padding:32px;max-width:480px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.35);border:2.5px solid #131218;position:relative;">
        <button type="button" onclick="closeAddModal()" style="position:absolute;top:20px;right:20px;width:34px;height:34px;border:1.5px solid #131218;background:#FFFFFF;cursor:pointer;color:#131218;font-size:20px;line-height:1;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">&times;</button>
        
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Akun Pengelola</span>
        </div>
        <h3 style="margin:4px 0;font-size:19px;font-weight:900;color:#131218;">Tambah Akun Admin Baru</h3>
        <p style="margin:0 0 20px;font-size:12.5px;color:#64748B;font-weight:500;">Buat akun pengelola baru untuk mengakses dashboard admin.</p>

        <form action="{{ route('admin.pengguna.admin.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Nama Lengkap Admin *</label>
                <input type="text" name="nama" required placeholder="Contoh: Ahmad Rizky" class="fcc-input" style="font-size:13px;height:40px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Email Login *</label>
                <input type="email" name="email" required placeholder="admin@fcc.umi.ac.id" class="fcc-input" style="font-size:13px;height:40px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Password Login *</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="fcc-input" style="font-size:13px;height:40px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Role Hak Akses *</label>
                <select name="role" required class="fcc-input" style="font-size:13px;height:40px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;width:100%;cursor:pointer;">
                    <option value="admin">Admin Biasa (Akses Standar Dashboard)</option>
                    <option value="super_admin">Super Admin (Akses Penuh Seluruh Sistem)</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeAddModal()" style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 22px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Simpan Admin</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT ADMIN --}}
<div id="edit-admin-modal" class="hidden" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.6);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border-radius:24px;padding:32px;max-width:480px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.35);border:2.5px solid #131218;position:relative;">
        <button type="button" onclick="closeEditModal()" style="position:absolute;top:20px;right:20px;width:34px;height:34px;border:1.5px solid #131218;background:#FFFFFF;cursor:pointer;color:#131218;font-size:20px;line-height:1;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">&times;</button>
        
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Edit Akun</span>
        </div>
        <h3 style="margin:4px 0;font-size:19px;font-weight:900;color:#131218;">Edit Akun Admin</h3>
        <p style="margin:0 0 20px;font-size:12.5px;color:#64748B;font-weight:500;">Perbarui data atau hak akses akun pengelola.</p>

        <form id="edit-admin-form" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Nama Lengkap Admin *</label>
                <input type="text" id="edit-nama" name="nama" required class="fcc-input" style="font-size:13px;height:40px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Email Login *</label>
                <input type="email" id="edit-email" name="email" required class="fcc-input" style="font-size:13px;height:40px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="fcc-input" style="font-size:13px;height:40px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Role Hak Akses *</label>
                <select id="edit-role" name="role" required class="fcc-input" style="font-size:13px;height:40px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;width:100%;cursor:pointer;">
                    <option value="admin">Admin Biasa</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeEditModal()" style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 22px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Simpan Perubahan</button>
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

