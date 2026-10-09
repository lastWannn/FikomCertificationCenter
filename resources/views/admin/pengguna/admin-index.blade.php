@extends('layouts.admin')
@section('title','Manajemen Admin')
@section('page-title','Manajemen Admin & Pengelola')

@section('page-content')
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

  /* ── Base Responsive View Rules ── */
  .fcc-admin-mgmt-container {
    padding: 24px;
    position: relative;
  }
  .fcc-admin-desktop-table {
    display: block;
  }
  .fcc-admin-mobile-list {
    display: none;
  }
  .fcc-admin-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
  }

  /* ── Tablet Breakpoints (768px – 1023px) ── */
  @media (max-width: 1023px) {
    .fcc-admin-mgmt-container {
      padding: 20px 16px !important;
    }
    .fcc-admin-stats-grid {
      gap: 12px !important;
      margin-bottom: 20px !important;
    }
  }

  /* ── Mobile & Phablet Breakpoints (< 768px) ── */
  @media (max-width: 767px) {
    .fcc-admin-desktop-table {
      display: none !important;
    }
    .fcc-admin-mobile-list {
      display: flex !important;
      flex-direction: column !important;
      gap: 12px !important;
      padding: 12px !important;
    }
    .fcc-admin-stats-grid {
      grid-template-columns: repeat(3, 1fr) !important;
      gap: 8px !important;
      margin-bottom: 16px !important;
    }
    .fcc-admin-stat-card {
      padding: 12px 6px !important;
      border-radius: 14px !important;
      flex-direction: column !important;
      align-items: center !important;
      text-align: center !important;
      gap: 6px !important;
      box-shadow: 0 2px 8px rgba(0,0,0,0.03) !important;
    }
    .fcc-admin-stat-icon {
      width: 34px !important;
      height: 34px !important;
      border-radius: 10px !important;
    }
    .fcc-admin-stat-icon svg {
      width: 17px !important;
      height: 17px !important;
    }
    .fcc-admin-stat-lbl {
      font-size: 9.5px !important;
      font-weight: 800 !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      max-width: 100% !important;
    }
    .fcc-admin-stat-val {
      font-size: 18px !important;
      line-height: 1.1 !important;
      margin: 2px 0 0 !important;
    }
    .fcc-admin-stat-sub {
      display: none !important;
    }
  }

  /* ── Mobile Standard (< 640px) ── */
  @media (max-width: 639px) {
    .fcc-admin-mgmt-container {
      padding: 14px 12px !important;
    }
    .fcc-admin-page-hero {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
      margin-bottom: 16px !important;
    }
    .fcc-admin-page-hero-btn {
      width: 100% !important;
      justify-content: center !important;
      padding: 11px 18px !important;
      font-size: 13.5px !important;
    }
    .fcc-admin-filter-header {
      padding: 14px 12px !important;
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 10px !important;
    }
    .fcc-admin-filter-title-row {
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      width: 100% !important;
    }
    .fcc-admin-filter-form {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 8px !important;
      width: 100% !important;
    }
    .fcc-admin-search-wrap {
      width: 100% !important;
    }
    .fcc-admin-filter-actions {
      display: flex !important;
      align-items: center !important;
      gap: 8px !important;
      width: 100% !important;
    }
    .fcc-admin-filter-actions select {
      flex: 1 !important;
      min-width: 0 !important;
    }
    .fcc-admin-filter-actions button {
      min-width: 72px !important;
    }
    .fcc-admin-filter-actions a {
      min-width: 64px !important;
    }
    .fcc-admin-modal-card {
      padding: 20px 16px !important;
      border-radius: 18px !important;
      width: 95% !important;
      max-height: 90vh !important;
    }
    .fcc-admin-modal-btns {
      flex-direction: column-reverse !important;
      gap: 8px !important;
    }
    .fcc-admin-modal-btns button {
      width: 100% !important;
      justify-content: center !important;
      padding: 11px 18px !important;
    }
  }

  /* ── Compact Mobile (< 420px) ── */
  @media (max-width: 419px) {
    .fcc-admin-mgmt-container {
      padding: 12px 10px !important;
    }
    .fcc-admin-stats-grid {
      grid-template-columns: repeat(3, 1fr) !important;
      gap: 6px !important;
    }
    .fcc-admin-stat-card {
      padding: 10px 4px !important;
      border-radius: 12px !important;
    }
    .fcc-admin-stat-icon {
      width: 30px !important;
      height: 30px !important;
      border-radius: 8px !important;
    }
    .fcc-admin-stat-icon svg {
      width: 15px !important;
      height: 15px !important;
    }
    .fcc-admin-stat-lbl {
      font-size: 8.5px !important;
      letter-spacing: 0 !important;
    }
    .fcc-admin-stat-val {
      font-size: 16px !important;
    }
    .fcc-admin-mobile-list {
      padding: 10px 8px !important;
      gap: 10px !important;
    }
    .fcc-admin-card-item {
      padding: 12px 10px !important;
    }
    .fcc-admin-mobile-actions {
      flex-direction: row !important;
      gap: 8px !important;
    }
    .fcc-admin-mobile-actions button,
    .fcc-admin-mobile-actions form {
      flex: 1 !important;
      min-width: 0 !important;
    }
    .fcc-admin-mobile-actions form button {
      width: 100% !important;
      justify-content: center !important;
    }
  }
</style>

<div class="fcc-admin-mgmt-container">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <div id="admin-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:inherit;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:14px;">
        <div style="flex:1;min-width:220px;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:180px;height:40px;border-radius:30px;"></div>
      </div>
      {{-- Stats Skeleton --}}
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:14px;margin-bottom:22px;">
        @for($sk=0; $sk<3; $sk++)
        <div style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:14px;">
          <div class="fcc-skeleton-box" style="width:44px;height:44px;border-radius:12px;flex-shrink:0;"></div>
          <div style="flex:1;">
            <div class="fcc-skeleton-box" style="width:65%;height:12px;margin-bottom:6px;"></div>
            <div class="fcc-skeleton-box" style="width:40%;height:20px;"></div>
          </div>
        </div>
        @endfor
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
    <div class="fcc-admin-page-hero" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;flex-wrap:wrap;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;flex-shrink:0;">Pengguna &amp; Hak Akses</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Manajemen Akun Admin</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola hak akses akun pengelola sistem FCC (Super Admin &amp; Admin Biasa).</p>
        </div>

        <button type="button" onclick="openAddModal()" class="fcc-admin-page-hero-btn"
                style="padding:10px 20px;font-size:13.5px;font-weight:900;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(0,0,0,0.12);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;white-space:nowrap;"
                onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
            @include('components.icon',['name'=>'plus','size'=>16]) Tambah Admin Baru
        </button>
    </div>

    {{-- Neo-Brutalist Stat Cards Grid --}}
    <div class="fcc-admin-stats-grid">
        {{-- Total Admin --}}
        <div class="fcc-card fcc-admin-stat-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div class="fcc-admin-stat-icon" style="width:44px;height:44px;border-radius:12px;background:#F1F5F9;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(0,0,0,0.06);flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div class="fcc-admin-stat-info" style="min-width:0;flex:1;">
                <p class="fcc-admin-stat-lbl" style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Pengelola</p>
                <p class="fcc-admin-stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ $totalAdmins ?? $admins->total() }} <span class="fcc-admin-stat-sub" style="font-size:12px;font-weight:700;color:#94A3B8;">Admin</span>
                </p>
            </div>
        </div>

        {{-- Super Admin --}}
        <div class="fcc-card fcc-admin-stat-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div class="fcc-admin-stat-icon" style="width:44px;height:44px;border-radius:12px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#B38F00;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'shield','size'=>20])
            </div>
            <div class="fcc-admin-stat-info" style="min-width:0;flex:1;">
                <p class="fcc-admin-stat-lbl" style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Super Admin</p>
                <p class="fcc-admin-stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ $totalSuperAdmin ?? 0 }} <span class="fcc-admin-stat-sub" style="font-size:12px;font-weight:700;color:#94A3B8;">Akun</span>
                </p>
            </div>
        </div>

        {{-- Admin Biasa --}}
        <div class="fcc-card fcc-admin-stat-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div class="fcc-admin-stat-icon" style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'user-check','size'=>20])
            </div>
            <div class="fcc-admin-stat-info" style="min-width:0;flex:1;">
                <p class="fcc-admin-stat-lbl" style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Admin Biasa</p>
                <p class="fcc-admin-stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ $totalRegularAdmin ?? 0 }} <span class="fcc-admin-stat-sub" style="font-size:12px;font-weight:700;color:#94A3B8;">Akun</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div class="fcc-admin-filter-header" style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <div class="fcc-admin-filter-title-row" style="display:flex;align-items:center;gap:10px;">
                <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Akun Pengelola</h3>
                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;white-space:nowrap;">
                    {{ $admins->total() }} Admin
                </span>
            </div>
            
            <form method="GET" action="{{ route('admin.pengguna.admin.index') }}" class="fcc-admin-filter-form" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin:0;">
                {{-- Search Bar --}}
                <div class="fcc-admin-search-wrap" style="position:relative;width:240px;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
                        @include('components.icon', ['name'=>'search', 'size'=>14])
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari nama atau email..."
                           class="fcc-input" style="width:100%;box-sizing:border-box;padding-left:34px;font-size:12.5px;height:38px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;outline:none;"
                           autocomplete="off">
                </div>

                <div class="fcc-admin-filter-actions" style="display:flex;align-items:center;gap:8px;">
                    {{-- Role Dropdown --}}
                    <select name="role" class="fcc-input" style="font-size:12.5px;height:38px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;outline:none;" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        <option value="super_admin" {{ request('role')==='super_admin'?'selected':'' }}>Super Admin</option>
                        <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin Biasa</option>
                    </select>

                    <button type="submit" style="padding:6px 16px;font-size:12px;height:38px;font-weight:800;background:#131218;color:#FFC81A;border-radius:10px;border:1.5px solid #131218;cursor:pointer;transition:all .18s;white-space:nowrap;"
                            onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                        Cari
                    </button>

                    @if(request('q') || request('role'))
                    <a href="{{ route('admin.pengguna.admin.index') }}" style="padding:6px 12px;font-size:12px;height:38px;box-sizing:border-box;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;text-decoration:none;white-space:nowrap;">
                        ✕ Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Desktop Table View (>= 768px) --}}
        <div class="fcc-admin-desktop-table" style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
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
                                <div style="min-width:0;">
                                    <p style="margin:0;font-size:13.5px;font-weight:900;color:#131218;word-break:break-word;">
                                        {{ $adm->nama }}
                                        @if($isSelf)
                                        <span style="font-size:10px;font-weight:900;background:#EEF2FF;color:#4F46E5;padding:2px 8px;border-radius:6px;border:1px solid #818CF8;margin-left:4px;white-space:nowrap;">Anda</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Email Login --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;color:#64748B;font-weight:700;word-break:break-all;">
                            {{ $adm->email }}
                        </td>

                        {{-- Role Access --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @if($isSuper)
                            <span style="font-size:11px;font-weight:900;padding:4px 12px;border-radius:12px;background:#FFFDF5;color:#B38F00;border:1px solid #FFC81A;display:inline-flex;align-items:center;gap:4px;white-space:nowrap;">
                                👑 Super Admin
                            </span>
                            @else
                            <span style="font-size:11px;font-weight:800;padding:4px 12px;border-radius:12px;background:#EEF2FF;color:#4F46E5;border:1px solid #818CF8;display:inline-flex;align-items:center;gap:4px;white-space:nowrap;">
                                🛡️ Admin Biasa
                            </span>
                            @endif
                        </td>

                        {{-- Tgl Dibuat --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:12.5px;color:#64748B;font-weight:700;white-space:nowrap;">
                            📅 {{ $adm->created_at?->format('d M Y') ?? '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:flex;gap:6px;justify-content:center;align-items:center;">
                                {{-- Edit Button --}}
                                <button type="button" onclick="openEditModal({{ json_encode($adm) }})"
                                        style="padding:6px 14px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;cursor:pointer;transition:all .18s;"
                                        onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';" title="Edit Data Admin">
                                    Edit
                                </button>

                                {{-- Delete Button (Cannot delete self or last admin) --}}
                                @if(!$isSelf && $admins->total() > 1)
                                <form action="{{ route('admin.pengguna.admin.destroy', $adm) }}" method="POST" onsubmit="return fccConfirmDelete(event, this, 'Hapus Admin', 'Apakah Anda yakin ingin menghapus akun admin \'{{ addslashes($adm->nama) }}\'?')" style="margin:0;">
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
                        <td colspan="5" style="padding:48px 20px;text-align:center;color:#94A3B8;">
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

        {{-- Mobile Cards List View (< 768px) --}}
        <div class="fcc-admin-mobile-list">
            @forelse($admins as $adm)
            @php
                $isSuper = $adm->isSuperAdmin();
                $isSelf  = auth('admin')->id() === $adm->id;
            @endphp
            <div class="fcc-admin-card-item" style="background:#FFFFFF;border:1.5px solid #E2E8F0;border-radius:16px;padding:16px;box-shadow:0 2px 8px rgba(0,0,0,0.03);display:flex;flex-direction:column;gap:12px;">
                {{-- Header Row: Avatar, Name, Anda Tag, Role Badge --}}
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;">
                    <div style="display:flex;align-items:center;gap:10px;min-width:0;flex:1;">
                        <div style="width:40px;height:40px;border-radius:10px;background:{{ $isSuper ? '#131218' : '#F1F5F9' }};border:1.5px solid {{ $isSuper ? '#FFC81A' : '#CBD5E1' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            @include('components.icon',['name'=>'user','size'=>18,'style'=>"color:".($isSuper ? '#FFC81A' : '#64748B')])
                        </div>
                        <div style="min-width:0;flex:1;">
                            <h4 style="margin:0 0 2px;font-size:14.5px;font-weight:900;color:#131218;line-height:1.3;word-break:break-word;">
                                {{ $adm->nama }}
                                @if($isSelf)
                                <span style="font-size:10px;font-weight:900;background:#EEF2FF;color:#4F46E5;padding:2px 8px;border-radius:6px;border:1px solid #818CF8;margin-left:4px;white-space:nowrap;">Anda</span>
                                @endif
                            </h4>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;word-break:break-all;">
                                {{ $adm->email }}
                            </p>
                        </div>
                    </div>
                    @if($isSuper)
                    <span style="font-size:10.5px;font-weight:900;padding:3px 9px;border-radius:10px;background:#FFFDF5;color:#B38F00;border:1px solid #FFC81A;white-space:nowrap;flex-shrink:0;">
                        👑 Super Admin
                    </span>
                    @else
                    <span style="font-size:10.5px;font-weight:800;padding:3px 9px;border-radius:10px;background:#EEF2FF;color:#4F46E5;border:1px solid #818CF8;white-space:nowrap;flex-shrink:0;">
                        🛡️ Admin Biasa
                    </span>
                    @endif
                </div>

                {{-- Detail Meta Info --}}
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;padding:8px 12px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;font-size:11.5px;color:#64748B;font-weight:600;">
                    <span>📅 Terdaftar: {{ $adm->created_at?->format('d M Y') ?? '-' }}</span>
                    <span>🔑 Role: {{ $isSuper ? 'Akses Penuh' : 'Akses Standar' }}</span>
                </div>

                {{-- Actions Row --}}
                <div class="fcc-admin-mobile-actions" style="display:flex;gap:8px;justify-content:flex-end;padding-top:4px;border-top:1px dashed #E2E8F0;">
                    <button type="button" onclick="openEditModal({{ json_encode($adm) }})"
                            style="flex:1;padding:9px 14px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:12.5px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .18s;"
                            onmouseover="this.style.background='#FFC81A';"
                            onmouseout="this.style.background='#FFFFFF';">
                        @include('components.icon',['name'=>'edit','size'=>14]) Edit
                    </button>

                    @if(!$isSelf && $admins->total() > 1)
                    <form action="{{ route('admin.pengguna.admin.destroy', $adm) }}" method="POST" onsubmit="return fccConfirmDelete(event, this, 'Hapus Admin', 'Apakah Anda yakin ingin menghapus akun admin \'{{ addslashes($adm->nama) }}\'?')" style="margin:0;flex:1;">
                        @csrf @method('DELETE')
                        <button type="submit" style="width:100%;padding:9px 14px;border-radius:10px;border:1.5px solid #FCA5A5;background:#FEF2F2;color:#EF4444;font-size:12.5px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .18s;">
                            @include('components.icon',['name'=>'trash','size'=>14]) Hapus
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div style="padding:36px 16px;text-align:center;color:#94A3B8;background:#FFFFFF;border-radius:16px;">
                <div style="width:48px;height:48px;border-radius:14px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    @include('components.icon',['name'=>'user','size'=>22,'style'=>'color:#9CA3B0'])
                </div>
                <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Akun Admin</p>
                <p style="font-size:12px;color:#64748B;margin:0 0 12px;">Ketuk tombol "Tambah Admin Baru" di atas.</p>
            </div>
            @endforelse
        </div>

        @if($admins->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;">
            {{ $admins->links() }}
        </div>
        @endif
    </div>

</div>

{{-- MODAL TAMBAH ADMIN --}}
<div id="add-admin-modal" class="hidden fcc-modal-backdrop" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;overflow-y:auto;">
    <div class="fcc-admin-modal-card" style="background:#FFFFFF;border-radius:24px;padding:30px 28px;max-width:480px;width:92%;box-shadow:0 24px 64px rgba(0,0,0,.35);border:2.5px solid #131218;position:relative;margin:auto;box-sizing:border-box;">
        <button type="button" onclick="closeAddModal()" aria-label="Tutup" style="position:absolute;top:18px;right:18px;width:34px;height:34px;border:1.5px solid #131218;background:#FFFFFF;cursor:pointer;color:#131218;font-size:20px;line-height:1;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;transition:all .18s;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">&times;</button>
        
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Akun Pengelola</span>
        </div>
        <h3 style="margin:4px 0;font-size:19px;font-weight:900;color:#131218;line-height:1.3;">Tambah Akun Admin Baru</h3>
        <p style="margin:0 0 20px;font-size:12.5px;color:#64748B;font-weight:500;">Buat akun pengelola baru untuk mengakses dashboard admin.</p>

        <form action="{{ route('admin.pengguna.admin.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Nama Lengkap Admin *</label>
                <input type="text" name="nama" required placeholder="Contoh: Ahmad Rizky" class="fcc-input" style="font-size:14px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Email Login *</label>
                <input type="email" name="email" required placeholder="admin@fcc.umi.ac.id" class="fcc-input" style="font-size:14px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Password Login *</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="fcc-input" style="font-size:14px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:22px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Role Hak Akses *</label>
                <select name="role" required class="fcc-input" style="font-size:13.5px;height:42px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;width:100%;box-sizing:border-box;cursor:pointer;">
                    <option value="admin">Admin Biasa (Akses Standar Dashboard)</option>
                    <option value="super_admin">Super Admin (Akses Penuh Seluruh Sistem)</option>
                </select>
            </div>

            <div class="fcc-admin-modal-btns" style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeAddModal()" style="padding:10px 20px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 24px;font-size:13px;font-weight:900;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;box-shadow:0 4px 12px rgba(0,0,0,0.12);" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Simpan Admin</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT ADMIN --}}
<div id="edit-admin-modal" class="hidden fcc-modal-backdrop" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;overflow-y:auto;">
    <div class="fcc-admin-modal-card" style="background:#FFFFFF;border-radius:24px;padding:30px 28px;max-width:480px;width:92%;box-shadow:0 24px 64px rgba(0,0,0,.35);border:2.5px solid #131218;position:relative;margin:auto;box-sizing:border-box;">
        <button type="button" onclick="closeEditModal()" aria-label="Tutup" style="position:absolute;top:18px;right:18px;width:34px;height:34px;border:1.5px solid #131218;background:#FFFFFF;cursor:pointer;color:#131218;font-size:20px;line-height:1;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:900;transition:all .18s;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">&times;</button>
        
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Edit Akun</span>
        </div>
        <h3 style="margin:4px 0;font-size:19px;font-weight:900;color:#131218;line-height:1.3;">Edit Akun Admin</h3>
        <p style="margin:0 0 20px;font-size:12.5px;color:#64748B;font-weight:500;">Perbarui data atau hak akses akun pengelola.</p>

        <form id="edit-admin-form" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Nama Lengkap Admin *</label>
                <input type="text" id="edit-nama" name="nama" required class="fcc-input" style="font-size:14px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Email Login *</label>
                <input type="email" id="edit-email" name="email" required class="fcc-input" style="font-size:14px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="fcc-input" style="font-size:14px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:22px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Role Hak Akses *</label>
                <select id="edit-role" name="role" required class="fcc-input" style="font-size:13.5px;height:42px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;width:100%;box-sizing:border-box;cursor:pointer;">
                    <option value="admin">Admin Biasa</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>

            <div class="fcc-admin-modal-btns" style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeEditModal()" style="padding:10px 20px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 24px;font-size:13px;font-weight:900;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;box-shadow:0 4px 12px rgba(0,0,0,0.12);" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openAddModal() {
    const m = document.getElementById('add-admin-modal');
    if (!m) return;
    m.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeAddModal() {
    const m = document.getElementById('add-admin-modal');
    if (!m) return;
    m.classList.add('hidden');
    document.body.style.overflow = '';
}
function openEditModal(admin) {
    const form = document.getElementById('edit-admin-form');
    form.action = `/admin/pengguna/admin/${admin.id}`;
    document.getElementById('edit-nama').value = admin.nama;
    document.getElementById('edit-email').value = admin.email;
    document.getElementById('edit-role').value = admin.role || 'admin';
    const m = document.getElementById('edit-admin-modal');
    if (!m) return;
    m.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    const m = document.getElementById('edit-admin-modal');
    if (!m) return;
    m.classList.add('hidden');
    document.body.style.overflow = '';
}

// Close on backdrop click
document.getElementById('add-admin-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAddModal();
});
document.getElementById('edit-admin-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAddModal();
        closeEditModal();
    }
});
</script>
@endpush
@endsection
