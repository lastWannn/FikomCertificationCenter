@extends('layouts.admin')
@section('title','Program Pelatihan')

@section('page-content')
<div class="fcc-catalog-container" style="padding:24px;position:relative;">

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
      #tambah-pelatihan-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="tambah-pelatihan-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:110px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:200px;height:12px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:180px;height:40px;border-radius:30px;"></div>
      </div>
    {{-- 3 Stat Cards Skeleton --}}
    <div class="fcc-catalog-stats-grid" style="margin-bottom:24px;">
      @for($sc=0;$sc<3;$sc++)
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
        var sk = document.getElementById('tambah-pelatihan-skeleton-overlay');
        if (sk) {
          sk.style.opacity = '0';
          sk.style.visibility = 'hidden';
          setTimeout(function() { sk.style.display = 'none'; }, 350);
        }
      }, 400);
    })();
  </script>

  <style>
    .fcc-catalog-container {
      padding: 24px;
      position: relative;
      box-sizing: border-box;
      width: 100%;
    }
    .fcc-pelatihan-desktop-table {
      display: block;
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    .fcc-pelatihan-mobile-list {
      display: none;
    }

    /* 3 Stat Cards Grid */
    .fcc-catalog-stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    /* Kolom Program Pelatihan TIDAK DI-WRAP di tablet maupun desktop */
    .fcc-col-program {
      white-space: nowrap !important;
      min-width: 260px !important;
    }
    .fcc-col-program * {
      white-space: nowrap !important;
    }

    /* Kolom Kategori di Desktop: 1 Baris (nowrap), Proporsional & Rapi */
    .fcc-col-kategori {
      white-space: nowrap !important;
    }
    .fcc-kategori-badge {
      display: inline-flex !important;
      align-items: center !important;
      gap: 6px !important;
      font-size: 11.5px !important;
      font-weight: 800 !important;
      color: #334155 !important;
      background: #F8FAFC !important;
      padding: 5px 12px !important;
      border-radius: 8px !important;
      border: 1.5px solid #CBD5E1 !important;
      line-height: 1.2 !important;
      white-space: nowrap !important;
      word-break: normal !important;
      box-sizing: border-box !important;
      text-align: left !important;
    }

    /* ═══ TABLET BREAKPOINT (768px – 1023px) ═══ */
    @media (min-width: 768px) and (max-width: 1023px) {
      .fcc-catalog-container {
        padding: 18px 16px !important;
      }
      .fcc-catalog-stats-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 12px !important;
      }
      .fcc-col-program {
        white-space: nowrap !important;
        min-width: 250px !important;
      }
      .fcc-col-program * {
        white-space: nowrap !important;
      }
      .fcc-col-kategori {
        white-space: nowrap !important;
      }
      .fcc-kategori-badge {
        white-space: nowrap !important;
        font-size: 11px !important;
        padding: 4px 10px !important;
        line-height: 1.2 !important;
      }
    }

    /* ═══ MOBILE BREAKPOINT (< 768px) ═══ */
    @media (max-width: 767px) {
      .fcc-catalog-container {
        padding: 16px 14px 44px !important;
      }
      .fcc-pelatihan-desktop-table {
        display: none !important;
      }
      /* Remove double-nested card on mobile: let cards breathe on the page background */
      .fcc-catalog-main-card {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        overflow: visible !important;
      }
      .fcc-catalog-card-header {
        padding: 0 4px 14px 4px !important;
        background: transparent !important;
        border-bottom: none !important;
      }
      .fcc-catalog-card-header h3 {
        font-size: 16px !important;
      }
      .fcc-pelatihan-mobile-list {
        display: flex !important;
        flex-direction: column !important;
        gap: 14px !important;
        padding: 0 !important;
        background: transparent !important;
      }
      .fcc-catalog-header-bar {
        margin-bottom: 20px !important;
        gap: 14px !important;
      }
      .fcc-catalog-header-btn {
        width: 100% !important;
        justify-content: center !important;
        padding: 12px 20px !important;
        font-size: 13.5px !important;
        border-radius: 14px !important;
      }
      /* Stat Cards: 3 Sleek Compact Tiles Side-by-Side */
      .fcc-catalog-stats-grid {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 8px !important;
        margin-bottom: 22px !important;
        overflow-x: visible !important;
      }
      .fcc-catalog-stats-grid .fcc-card {
        padding: 12px 6px !important;
        border-radius: 14px !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        gap: 6px !important;
        min-width: 0 !important;
        background: #FFFFFF !important;
        border: 1.5px solid #E2E8F0 !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02) !important;
      }
      .fcc-catalog-stats-grid .fcc-stat-icon-wrapper {
        width: 32px !important;
        height: 32px !important;
        border-radius: 9px !important;
        margin-bottom: 2px !important;
      }
      .fcc-catalog-stats-grid .fcc-stat-icon-wrapper svg {
        width: 15px !important;
        height: 15px !important;
      }
      .fcc-catalog-stats-grid .fcc-stat-lbl {
        font-size: 9px !important;
        letter-spacing: 0.3px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        width: 100% !important;
        display: block !important;
      }
      .fcc-catalog-stats-grid .fcc-stat-val {
        font-size: 17px !important;
        line-height: 1.1 !important;
        margin: 0 !important;
      }
      .fcc-catalog-stats-grid .fcc-stat-unit {
        display: none !important;
      }
      /* Floating Pagination Capsule on Mobile */
      .fcc-pagination-bar {
        background: #FFFFFF !important;
        border: 1.5px solid #E2E8F0 !important;
        border-radius: 16px !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03) !important;
        padding: 16px 14px !important;
        margin-top: 8px !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        gap: 14px !important;
      }
      .fcc-pagination-bar > div {
        justify-content: center !important;
        width: 100% !important;
      }
    }
  </style>

  {{-- Header & Action Bar --}}
  <div class="fcc-catalog-header-bar" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
      <div>
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
              <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Katalog Master</span>
              <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Program Pelatihan</h1>
          </div>
          <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola master data program pelatihan, materi pembelajaran, dan biaya.</p>
      </div>
      <button type="button" class="fcc-catalog-header-btn" onclick="document.getElementById('create-modal').style.display='flex'"
              style="padding:10px 22px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.35);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
              onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
          @include('components.icon',['name'=>'plus','size'=>16]) Tambah Pelatihan Baru
      </button>
  </div>

  {{-- Stat Cards Grid (Neo-Brutalist) --}}
  <div class="fcc-catalog-stats-grid">
      <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
          <div class="fcc-stat-icon-wrapper" style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
              @include('components.icon',['name'=>'book','size'=>20])
          </div>
          <div style="min-width:0;">
              <p class="fcc-stat-lbl" style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Pelatihan</p>
              <p class="fcc-stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $pelatihan->total() }} <span class="fcc-stat-unit" style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
          </div>
      </div>

      <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
          <div class="fcc-stat-icon-wrapper" style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
              @include('components.icon',['name'=>'tag','size'=>20])
          </div>
          <div style="min-width:0;">
              <p class="fcc-stat-lbl" style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Kategori Pelatihan</p>
              <p class="fcc-stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $kategori->count() }} <span class="fcc-stat-unit" style="font-size:12px;font-weight:700;color:#94A3B8;">Kategori</span></p>
          </div>
      </div>

      <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
          <div class="fcc-stat-icon-wrapper" style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
              @include('components.icon',['name'=>'calendar','size'=>20])
          </div>
          <div style="min-width:0;">
              <p class="fcc-stat-lbl" style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Jadwal Terdaftar</p>
              <p class="fcc-stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\JadwalPelatihan::count() }} <span class="fcc-stat-unit" style="font-size:12px;font-weight:700;color:#94A3B8;">Batch</span></p>
          </div>
      </div>
  </div>

  {{-- Main Neo-Brutalist Table Card --}}
  <div class="fcc-card fcc-catalog-main-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
      <div class="fcc-catalog-card-header" style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
          <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Master Pelatihan</h3>
          <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $pelatihan->total() }} Data</span>
      </div>

      <div class="fcc-pelatihan-desktop-table">
          <table style="width:100%;border-collapse:collapse;min-width:820px;">
              <thead>
                  <tr style="background:#131218;color:#FFFFFF;">
                      <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:85px;white-space:nowrap;">Kode</th>
                      <th class="fcc-col-program" style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;white-space:nowrap;">Program Pelatihan</th>
                      <th class="fcc-col-kategori" style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;white-space:nowrap;">Kategori</th>
                      <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;white-space:nowrap;width:180px;">Status Modul &amp; Jadwal</th>
                      <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;white-space:nowrap;width:130px;min-width:130px;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($pelatihan as $p)
                  <tr style="border-top:1px solid #F1F5F9;transition:background .15s;cursor:pointer;" onclick="if(!event.target.closest('button, a, select, input, form')) window.location.href='{{ route('admin.pelatihan.show', $p) }}'" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                      {{-- Kode --}}
                      <td style="padding:14px 20px;vertical-align:middle;white-space:nowrap;width:85px;">
                          <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                              {{ $p->kode }}
                          </span>
                      </td>

                      {{-- Judul (Program Pelatihan TIDAK DI-WRAP) --}}
                      <td class="fcc-col-program" style="padding:14px 16px;vertical-align:middle;white-space:nowrap;">
                          <div style="display:flex;align-items:center;gap:12px;white-space:nowrap;">
                              @if($p->gambar_url)
                                  <img src="{{ $p->gambar_url }}" alt="{{ $p->judul }}" style="width:42px;height:42px;border-radius:10px;object-fit:cover;border:1.5px solid #131218;flex-shrink:0;">
                              @else
                                  <div style="width:42px;height:42px;border-radius:10px;background:#F1F5F9;border:1.5px solid #CBD5E1;display:flex;align-items:center;justify-content:center;color:#94A3B8;flex-shrink:0;">
                                      @include('components.icon',['name'=>'book','size'=>18])
                                  </div>
                              @endif
                              <div style="white-space:nowrap;">
                                  <a href="{{ route('admin.pelatihan.show', $p) }}" class="fcc-program-title" style="font-size:14px;font-weight:900;color:#131218;text-decoration:none;margin:0;display:block;white-space:nowrap;transition:color .15s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#131218'">
                                      {{ $p->judul }}
                                  </a>
                                  <span style="font-size:11px;color:#64748B;font-weight:600;white-space:nowrap;display:block;">Dibuat: {{ $p->created_at?->format('d M Y') ?? '—' }}</span>
                              </div>
                          </div>
                      </td>

                      {{-- Kategori (Proporsional & Rapi) --}}
                      <td class="fcc-col-kategori" style="padding:14px 16px;vertical-align:middle;white-space:nowrap;">
                          <span class="fcc-kategori-badge">
                              <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#6366F1;flex-shrink:0;"></span>
                              <span>{{ $p->kategori->nama_kategori ?? 'Umum' }}</span>
                          </span>
                      </td>

                      {{-- Modul & Jadwal Stats (Compact Capsule) --}}
                      <td style="padding:14px 16px;vertical-align:middle;white-space:nowrap;width:180px;">
                          @php
                              $cntJadwal = $p->jadwal_count ?? $p->jadwal()->count();
                              $cntMateri = $p->materi_count ?? $p->materi()->count();
                          @endphp
                          <div style="display:inline-flex;align-items:center;gap:4px;background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:10px;padding:3px 6px;white-space:nowrap;" title="{{ $cntJadwal }} Jadwal, {{ $cntMateri }} Modul">
                                {{-- Jadwal Pill --}}
                                @if($cntJadwal > 0)
                                    <span style="display:inline-flex;align-items:center;gap:3.5px;font-size:11px;font-weight:800;color:#131218;background:#FFFDF5;border:1px solid #FFC81A;padding:2px 7px;border-radius:6px;line-height:1.2;">
                                        <span style="font-size:10.5px;">📅</span> {{ $cntJadwal }} <span style="font-size:9.5px;color:#78350F;font-weight:700;">Jadwal</span>
                                    </span>
                                @else
                                    <span style="display:inline-flex;align-items:center;gap:3px;font-size:10.5px;font-weight:700;color:#94A3B8;padding:2px 6px;line-height:1.2;">
                                        <span style="font-size:10.5px;opacity:0.6;">📅</span> 0 <span style="font-size:9.5px;">Jadwal</span>
                                    </span>
                                @endif

                                {{-- Divider --}}
                                <span style="width:1px;height:12px;background:#CBD5E1;margin:0 1px;"></span>

                                {{-- Modul Pill --}}
                                @if($cntMateri > 0)
                                    <span style="display:inline-flex;align-items:center;gap:3.5px;font-size:11px;font-weight:800;color:#1D4ED8;background:#EFF6FF;border:1px solid #93C5FD;padding:2px 7px;border-radius:6px;line-height:1.2;">
                                        <span style="font-size:10.5px;">📚</span> {{ $cntMateri }} <span style="font-size:9.5px;color:#1E40AF;font-weight:700;">Modul</span>
                                    </span>
                                @else
                                    <span style="display:inline-flex;align-items:center;gap:3px;font-size:10.5px;font-weight:700;color:#94A3B8;padding:2px 6px;line-height:1.2;">
                                        <span style="font-size:10.5px;opacity:0.6;">📚</span> 0 <span style="font-size:9.5px;">Modul</span>
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;width:130px;min-width:130px;white-space:nowrap;">
                            <div style="display:inline-flex;gap:6px;align-items:center;">
                                {{-- Detail Button --}}
                                <a href="{{ route('admin.pelatihan.show', $p) }}" title="Detail Pelatihan"
                                   style="width:32px;height:32px;border-radius:9px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;text-decoration:none;transition:all .18s;"
                                   onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                                    @include('components.icon',['name'=>'eye','size'=>15])
                                </a>

                                {{-- Edit Button --}}
                                <button type="button" onclick="document.getElementById('edit-modal-{{ $p->id }}').style.display='flex'" title="Edit Pelatihan"
                                        style="width:32px;height:32px;border-radius:9px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;cursor:pointer;transition:all .18s;padding:0;"
                                        onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                                    @include('components.icon',['name'=>'edit','size'=>15])
                                </button>

                                {{-- Hapus Button --}}
                                <form action="{{ route('admin.pelatihan.destroy', $p) }}" method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="fccConfirmDelete(this, 'Hapus Pelatihan', 'Apakah Anda yakin ingin menghapus pelatihan {{ addslashes($p->judul) }}?')" title="Hapus"
                                            style="width:32px;height:32px;border-radius:9px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;color:#EF4444;cursor:pointer;transition:all .18s;padding:0;"
                                            onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';this.style.borderColor='#131218';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                                        @include('components.icon',['name'=>'trash','size'=>15])
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:40px 24px;text-align:center;color:#94A3B8;font-size:14px;font-weight:600;">
                            Belum ada data program pelatihan. Klik <strong>Tambah Pelatihan Baru</strong> di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards List View (< 768px) --}}
        <div class="fcc-pelatihan-mobile-list">
            @forelse($pelatihan as $p)
            @php
                $cntJadwal = $p->jadwal_count ?? $p->jadwal()->count();
                $cntMateri = $p->materi_count ?? $p->materi()->count();
            @endphp
            <div class="fcc-mobile-item-card" style="background:#FFFFFF;border:1.5px solid #E2E8F0;border-left:4px solid #FFC81A;border-radius:16px;padding:16px 18px;box-shadow:0 3px 12px rgba(0,0,0,0.03);position:relative;">
                {{-- 1. Top Bar: Kode + Kategori --}}
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:12px;">
                    <span style="font-size:11px;font-weight:900;color:#FFC81A;background:#131218;padding:3px 9px;border-radius:7px;font-family:monospace;letter-spacing:0.5px;flex-shrink:0;">
                        {{ $p->kode }}
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:800;color:#334155;background:#F1F5F9;border:1px solid #CBD5E1;padding:3px 10px;border-radius:20px;max-width:68%;line-height:1.2;">
                        <span style="display:inline-block;width:5px;height:5px;border-radius:50%;background:#6366F1;flex-shrink:0;"></span>
                        <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $p->kategori->nama_kategori ?? 'Umum' }}</span>
                    </span>
                </div>

                {{-- 2. Program Info: Thumbnail + Judul + Tanggal --}}
                <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:14px;">
                    @if($p->gambar_url)
                        <img src="{{ $p->gambar_url }}" alt="{{ $p->judul }}" style="width:48px;height:48px;border-radius:12px;object-fit:cover;border:1.5px solid #131218;flex-shrink:0;">
                    @else
                        <div style="width:48px;height:48px;border-radius:12px;background:#F8FAFC;border:1.5px solid #CBD5E1;display:flex;align-items:center;justify-content:center;color:#94A3B8;flex-shrink:0;">
                            @include('components.icon',['name'=>'book','size'=>20])
                        </div>
                    @endif
                    <div style="flex:1;min-width:0;">
                        <a href="{{ route('admin.pelatihan.show', $p) }}" style="font-size:14.5px;font-weight:900;color:#131218;text-decoration:none;margin:0 0 5px;display:block;line-height:1.35;word-break:break-word;">
                            {{ $p->judul }}
                        </a>
                        <span style="font-size:11px;color:#64748B;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                            <span>🕒</span> Dibuat: {{ $p->created_at?->format('d M Y') ?? '—' }}
                        </span>
                    </div>
                </div>

                {{-- 3. Badges / Meta Info: Jadwal & Modul --}}
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;padding:8px 12px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;">
                    @if($cntJadwal > 0)
                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:800;color:#78350F;background:#FFFDF5;border:1px solid #FFC81A;padding:3px 9px;border-radius:6px;line-height:1.2;">
                            <span>📅</span> {{ $cntJadwal }} Jadwal
                        </span>
                    @else
                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;color:#94A3B8;padding:3px 6px;line-height:1.2;">
                            <span style="opacity:0.6;">📅</span> 0 Jadwal
                        </span>
                    @endif

                    <span style="width:1px;height:12px;background:#CBD5E1;margin:0 2px;"></span>

                    @if($cntMateri > 0)
                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:800;color:#1E40AF;background:#EFF6FF;border:1px solid #93C5FD;padding:3px 9px;border-radius:6px;line-height:1.2;">
                            <span>📚</span> {{ $cntMateri }} Modul
                        </span>
                    @else
                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;color:#94A3B8;padding:3px 6px;line-height:1.2;">
                            <span style="opacity:0.6;">📚</span> 0 Modul
                        </span>
                    @endif
                </div>

                {{-- 4. Action Buttons Bar (Lega, Bersih, Touch-Friendly) --}}
                <div style="display:grid;grid-template-columns:1fr 1fr 38px;gap:8px;padding-top:12px;border-top:1px dashed #E2E8F0;">
                    <a href="{{ route('admin.pelatihan.show', $p) }}"
                       style="height:38px;padding:0 12px;font-size:12.5px;font-weight:800;background:#F8FAFC;border:1.5px solid #CBD5E1;border-radius:10px;color:#131218;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .15s;">
                        @include('components.icon',['name'=>'eye','size'=>14])
                        <span>Detail</span>
                    </a>
                    <button type="button" onclick="document.getElementById('edit-modal-{{ $p->id }}').style.display='flex'"
                            style="height:38px;padding:0 12px;font-size:12.5px;font-weight:800;color:#131218;background:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .15s;">
                        @include('components.icon',['name'=>'edit','size'=>14])
                        <span>Edit</span>
                    </button>
                    <form action="{{ route('admin.pelatihan.destroy', $p) }}" method="POST" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="button" onclick="fccConfirmDelete(this, 'Hapus Pelatihan', 'Apakah Anda yakin ingin menghapus pelatihan {{ addslashes($p->judul) }}?')"
                                style="width:38px;height:38px;font-size:12px;font-weight:800;color:#EF4444;background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:10px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:all .15s;padding:0;"
                                title="Hapus Pelatihan">
                            @include('components.icon',['name'=>'trash','size'=>15])
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div style="padding:48px 20px;text-align:center;color:#94A3B8;background:#FFFFFF;border-radius:16px;border:1.5px dashed #CBD5E1;">
                <div style="width:48px;height:48px;background:#F1F5F9;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;color:#94A3B8;">
                    @include('components.icon',['name'=>'book','size'=>22])
                </div>
                <p style="margin:0 0 4px;font-size:14px;font-weight:800;color:#131218;">Belum ada data pelatihan</p>
                <p style="margin:0;font-size:12px;color:#64748B;">Klik tombol Tambah Pelatihan Baru di atas untuk membuat.</p>
            </div>
            @endforelse
        </div>

        <div class="fcc-pagination-bar" style="padding:14px 20px;border-top:1.5px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <form method="GET" action="{{ url()->current() }}" style="margin:0;">
                <select name="per_page" onchange="this.form.submit()" class="fcc-input" style="width:auto;font-size:12.5px;height:34px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:700;cursor:pointer;color:#131218;outline:none;" title="Jumlah data per halaman">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / hal</option>
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 / hal</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 / hal</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / hal</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / hal</option>
                </select>
                </form>
                <span style="font-size:12px;color:#64748B;font-weight:600;">
                    Menampilkan {{ $pelatihan->firstItem() ?? 0 }}–{{ $pelatihan->lastItem() ?? 0 }} dari {{ $pelatihan->total() }} data
                </span>
            </div>
            <div>
                {{ $pelatihan->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

{{-- ── TAMBAH & EDIT PELATIHAN MODALS ────────────────────────────────────── --}}
@include('admin.pelatihan.tambah.create-modal')
@include('admin.pelatihan.tambah.edit-modal')
@endsection

@push('scripts')
<script>
function addBiayaRow(containerId) {
    const container = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'biaya-row';
    div.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;';
    div.innerHTML = `
        <input type="text" name="nama_jenis_biaya[]" placeholder="contoh: Umum" class="fcc-input" style="background:#FFF;">
        <input type="number" name="nominal_biaya[]" placeholder="Nominal (Rp)" min="0" max="999999999" class="fcc-input" style="background:#FFF;">
        <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:6px;">@include('components.icon',['name'=>'trash','size'=>14])</button>
    `;
    container.appendChild(div);
}

function previewGambar(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        preview.src = e.target.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(file);
}

function handleImagePreview(input, previewId, labelId, statusId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        const label = document.getElementById(labelId);
        const status = document.getElementById(statusId);
        
        if (preview) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        if (label) {
            label.textContent = 'Ganti File Gambar (' + file.name + ')';
        }
        if (status) {
            status.innerHTML = '✨ <span style="color:#10B981;font-weight:900;">Foto Baru Terpilih:</span> ' + file.name;
        }
    };
    reader.readAsDataURL(file);
}
</script>

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('create-modal').style.display = 'flex';
});
</script>
@endif
@endpush
