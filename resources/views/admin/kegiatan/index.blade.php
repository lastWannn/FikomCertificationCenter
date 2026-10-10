@extends('layouts.admin')
@section('title','Kegiatan Aktif')
@section('page-title','Kegiatan Aktif')

@section('page-content')
<div class="fcc-kegiatan-container" style="padding:24px;position:relative;">

    {{-- === SKELETON LOADING OVERLAY === --}}
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
      #kegiatan-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }

      /* Container */
      .fcc-kegiatan-container {
        padding: 24px;
        position: relative;
        box-sizing: border-box;
        width: 100%;
      }

      /* Desktop & Tablet Table Display */
      .fcc-kegiatan-desktop-table {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      .fcc-kegiatan-mobile-list {
        display: none;
      }

      /* 4 Stat Cards Grid */
      .fcc-kegiatan-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
      }
      .fcc-kegiatan-stat-card {
        padding: 18px 20px;
        border-radius: 18px;
        background: #FFFFFF;
        border: 2px solid #E5E7EB;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 14px;
        height: 100%;
        min-width: 0;
        box-sizing: border-box;
      }

      /* Kolom Kegiatan Title (No Awkward Wrap on Tablet) */
      .fcc-kegiatan-col-title {
        white-space: nowrap !important;
        min-width: 250px !important;
      }
      .fcc-kegiatan-col-title .fcc-kegiatan-title-link {
        white-space: nowrap !important;
      }

      /* ═══ TABLET BREAKPOINT (768px – 1023px) ═══ */
      @media (min-width: 768px) and (max-width: 1023px) {
        .fcc-kegiatan-container {
          padding: 18px 16px !important;
        }
        .fcc-kegiatan-stats-grid {
          grid-template-columns: repeat(2, 1fr) !important;
          gap: 12px !important;
          margin-bottom: 20px !important;
        }
        .fcc-kegiatan-stat-card {
          padding: 16px 16px !important;
        }
        .fcc-kegiatan-col-title {
          white-space: nowrap !important;
          min-width: 240px !important;
        }
      }

    /* ═══ MOBILE BREAKPOINT (< 768px) ═══ */
    @media (max-width: 767px) {
      .fcc-kegiatan-container {
        padding: 16px 14px 44px !important;
      }
      .fcc-kegiatan-desktop-table {
        display: none !important;
      }
      /* Remove double-nested card on mobile: let cards breathe on the page background */
      .fcc-kegiatan-main-card {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        overflow: visible !important;
      }
      .fcc-kegiatan-card-header {
        padding: 0 4px 14px 4px !important;
        background: transparent !important;
        border-bottom: none !important;
      }
      .fcc-kegiatan-mobile-list {
        display: flex !important;
        flex-direction: column !important;
        gap: 14px !important;
        padding: 0 !important;
        background: transparent !important;
      }
      .fcc-kegiatan-header-actions {
        width: 100% !important;
      }
      .fcc-kegiatan-header-btn {
        width: 100% !important;
        justify-content: center !important;
        padding: 12px 20px !important;
        font-size: 13.5px !important;
        border-radius: 14px !important;
      }
      .fcc-kegiatan-stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
        margin-bottom: 22px !important;
      }
      .fcc-kegiatan-stat-card {
        padding: 14px 12px !important;
        border-radius: 16px !important;
        background: #FFFFFF !important;
        border: 1.5px solid #E2E8F0 !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02) !important;
      }
      /* Floating Pagination Capsule on Mobile */
      .fcc-kegiatan-pagination-bar {
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
      .fcc-kegiatan-pagination-bar > div {
        justify-content: center !important;
        width: 100% !important;
      }
    }
  </style>

    <div id="kegiatan-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div style="width:40%;min-width:240px;">
          <div class="fcc-skeleton-box" style="width:110px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:200px;height:12px;"></div>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <div class="fcc-skeleton-box" style="width:140px;height:40px;border-radius:30px;"></div>
          <div class="fcc-skeleton-box" style="width:140px;height:40px;border-radius:30px;"></div>
        </div>
      </div>
      {{-- 4 Stat Cards Skeleton --}}
      <div class="fcc-kegiatan-stats-grid">
        <div class="fcc-skeleton-box" style="height:80px;border-radius:18px;"></div>
        <div class="fcc-skeleton-box" style="height:80px;border-radius:18px;"></div>
        <div class="fcc-skeleton-box" style="height:80px;border-radius:18px;"></div>
        <div class="fcc-skeleton-box" style="height:80px;border-radius:18px;"></div>
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
          var sk = document.getElementById('kegiatan-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Kegiatan Publik</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Kegiatan Aktif</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Semua kegiatan yang sedang aktif dan terbuka untuk pendaftaran publik.</p>
        </div>
        <div class="fcc-kegiatan-header-actions" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="fcc-kegiatan-header-btn"
               style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.04);text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                @include('components.icon',['name'=>'book-open','size'=>15,'style'=>'color:#131218']) Kelola Pelatihan
            </a>
            <a href="{{ route('admin.jadwal-sertifikasi.index') }}" class="fcc-kegiatan-header-btn"
               style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFC81A;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.35);text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                @include('components.icon',['name'=>'award','size'=>15,'style'=>'color:#131218']) Kelola Sertifikasi
            </a>
        </div>
    </div>

    {{-- Stat Cards Grid (Neo-Brutalist) --}}
    <div class="fcc-kegiatan-stats-grid">
        {{-- Card 1: Total Aktif --}}
        <div class="fcc-card fcc-kegiatan-stat-card">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'zap','size'=>20])
            </div>
            <div style="flex:1;min-width:0;">
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Kegiatan Aktif</p>
                <p style="margin:2px 0 0;font-size:20px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $totalAktif }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Kegiatan</span></p>
            </div>
        </div>

        {{-- Card 2: Pelatihan Aktif --}}
        <div class="fcc-card fcc-kegiatan-stat-card">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'book-open','size'=>20])
            </div>
            <div style="flex:1;min-width:0;">
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Pelatihan Aktif</p>
                <p style="margin:2px 0 0;font-size:20px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $totalPelatihan }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        {{-- Card 3: Sertifikasi Aktif --}}
        <div class="fcc-card fcc-kegiatan-stat-card">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div style="flex:1;min-width:0;">
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Sertifikasi Aktif</p>
                <p style="margin:2px 0 0;font-size:20px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $totalSertifikasi }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        {{-- Card 4: Total Pendaftar --}}
        <div class="fcc-card fcc-kegiatan-stat-card">
            <div style="width:44px;height:44px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;color:#D97706;flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div style="flex:1;min-width:0;">
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Total Pendaftar</p>
                <p style="margin:2px 0 0;font-size:20px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $totalPendaftar }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card fcc-kegiatan-main-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div class="fcc-kegiatan-card-header" style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Kegiatan Aktif</h3>
            <div style="display:flex;align-items:center;gap:12px;">
                <form method="GET" style="display:flex;gap:8px;margin:0;">
                    <select name="jenis" class="fcc-input" style="width:auto;padding:6px 14px;font-size:12.5px;font-weight:700;border:1.5px solid #CBD5E1;border-radius:10px;background:#FFF;" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        <option value="pelatihan" {{ request('jenis')==='pelatihan'?'selected':'' }}>Pelatihan</option>
                        <option value="sertifikasi" {{ request('jenis')==='sertifikasi'?'selected':'' }}>Sertifikasi</option>
                    </select>
                </form>
                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $kegiatan->total() }} Data</span>
            </div>
        </div>

        <div class="fcc-kegiatan-desktop-table" style="width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
            <table style="width:100%;min-width:860px;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th class="fcc-kegiatan-col-title" style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;min-width:240px;white-space:nowrap;">Kegiatan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:120px;min-width:120px;white-space:nowrap;">Jenis</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:170px;min-width:170px;white-space:nowrap;">Jadwal</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:150px;min-width:150px;white-space:nowrap;">Kuota &amp; Peserta</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:130px;min-width:130px;white-space:nowrap;">Status Biaya</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:145px;min-width:145px;white-space:nowrap;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan as $k)
                    @php
                        $isPel = $k->jenis_kegiatan === 'pelatihan';
                        $isPassed = $k->isPassed();
                        $detail = $k->detail;
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;cursor:pointer; {{ $isPassed ? 'background:#FFFDF5;' : '' }}" onclick="if(!event.target.closest('button, a, select, input, form')) window.location.href='{{ route('admin.kegiatan.show', $k) }}'" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='{{ $isPassed ? '#FFFDF5' : '' }}'">
                        {{-- Kegiatan Info --}}
                        <td class="fcc-kegiatan-col-title" style="padding:14px 20px;vertical-align:middle;white-space:nowrap;">
                            <div style="display:flex;align-items:center;gap:12px;white-space:nowrap;">
                                <div style="width:42px;height:42px;border-radius:10px;background:{{ $isPel?'rgba(255,200,26,.18)':'rgba(59,130,246,.14)' }};border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>18,'style'=>'color:'.($isPel?'#131218':'#2563EB')])
                                </div>
                                <div style="white-space:nowrap;">
                                    <a href="{{ route('admin.kegiatan.show', $k) }}" class="fcc-kegiatan-title-link" style="font-size:14px;font-weight:900;color:#131218;text-decoration:none;margin:0;display:block;line-height:1.3;white-space:nowrap;transition:color .15s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#131218'">
                                        {{ $k->judul }}
                                    </a>
                                    <div style="display:flex;gap:6px;align-items:center;margin-top:4px;flex-wrap:nowrap;white-space:nowrap;">
                                        @if($k->isDraf())
                                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#F3F4F6;color:#4B5563;border:1px solid #D1D5DB;">Draft</span>
                                        @elseif($k->isComingSoon())
                                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#FEF3C7;color:#D97706;border:1px solid #FCD34D;">Coming Soon</span>
                                        @else
                                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#ECFDF5;color:#10B981;border:1px solid #6EE7B7;">Public</span>
                                        @endif

                                        @if($isPassed)
                                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#FEF3C7;color:#D97706;border:1px solid #FCD34D;display:inline-flex;align-items:center;gap:3px;">
                                            @include('components.icon',['name'=>'alert-triangle','size'=>10,'style'=>'color:#D97706;flex-shrink:0;'])
                                            Lewat Tanggal
                                        </span>
                                        @endif
                                        @if($k->isFull())
                                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#FEE2E2;color:#EF4444;border:1px solid #FCA5A5;">Kuota Penuh</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Jenis --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-size:11.5px;font-weight:800;padding:4px 12px;border-radius:20px;background:{{ $isPel?'#FFFDF5':'#EFF6FF' }};color:{{ $isPel?'#B38F00':'#2563EB' }};border:1px solid {{ $isPel?'#FFC81A':'#93C5FD' }};display:inline-block;white-space:nowrap;">
                                {{ ucfirst($k->jenis_kegiatan) }}
                            </span>
                        </td>

                        {{-- Jadwal --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <div>
                                <p style="margin:0;font-size:13px;font-weight:800;color:#131218;">{{ $k->jadwal?->tgl_pelaksanaan?->translatedFormat('d M Y') ?? 'TBA' }}</p>
                                <p style="margin:2px 0 0;font-size:11.5px;color:#64748B;font-weight:600;display:flex;align-items:center;gap:4px;">
                                    @include('components.icon',['name'=>'clock','size'=>12,'style'=>'color:#94A3B8;flex-shrink:0;'])
                                    <span>{{ $k->jadwal?->jam_mulai ? substr($k->jadwal->jam_mulai, 0, 5) : '' }} &ndash; {{ $k->jadwal?->jam_selesai ? substr($k->jadwal->jam_selesai, 0, 5) : '' }}</span>
                                </p>
                            </div>
                        </td>

                        {{-- Kuota & Peserta --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-block;width:100%;max-width:130px;">
                                <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748B;margin-bottom:4px;font-weight:800;">
                                    <span>Terisi</span>
                                    <span style="color:#131218;">{{ $k->terisi }} / {{ $k->kuota }}</span>
                                </div>
                                <div style="height:6px;background:#E2E8F0;border-radius:4px;overflow:hidden;border:1px solid #CBD5E1;">
                                    <div style="height:100%;border-radius:3px;transition:width .3s;
                                        background:{{ $k->isFull()?'#EF4444':($k->kuota > 0 && ($k->terisi/$k->kuota)>0.8?'#F59E0B':'#131218') }};
                                        width:{{ $k->kuota>0?min(100,round($k->terisi/$k->kuota*100)):0 }}%;"></div>
                                </div>
                            </div>
                        </td>

                        {{-- Biaya --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @if($k->biaya->isEmpty())
                                <span style="font-size:11.5px;font-weight:900;color:#10B981;background:#ECFDF5;border:1px solid #A7F3D0;padding:4px 10px;border-radius:20px;display:inline-block;">Gratis</span>
                            @else
                                <span style="font-size:13px;font-weight:900;color:#131218;">
                                    Rp {{ number_format($k->biaya->min('nominal'),0,',','.') }}+
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;white-space:nowrap;width:145px;min-width:145px;">
                            <div style="display:inline-flex;gap:7px;align-items:center;justify-content:center;white-space:nowrap;flex-wrap:nowrap;">
                                {{-- Detail Button --}}
                                <a href="{{ route('admin.kegiatan.show', $k) }}" title="Lihat Detail"
                                   style="width:34px;height:34px;border-radius:10px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:inline-flex;align-items:center;justify-content:center;color:#131218;text-decoration:none;transition:all .18s;flex-shrink:0;"
                                   onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                                    @include('components.icon',['name'=>'eye','size'=>15])
                                </a>

                                {{-- Edit Button --}}
                                <button type="button" onclick="document.getElementById('edit-kegiatan-modal-{{ $k->id }}').style.display='flex'" title="Edit Kegiatan"
                                        style="width:34px;height:34px;border-radius:10px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:inline-flex;align-items:center;justify-content:center;color:#131218;cursor:pointer;transition:all .18s;padding:0;flex-shrink:0;"
                                        onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                                    @include('components.icon',['name'=>'edit','size'=>15])
                                </button>

                                {{-- Delete / Archive Button --}}
                                <form action="{{ route('admin.kegiatan.destroy', $k) }}" method="POST" style="margin:0;display:inline-flex;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="fccConfirmDelete(this, '{{ $k->isPassed() ? 'Pindahkan ke Arsip' : 'Hapus Kegiatan' }}', '{{ $k->isPassed() ? 'Kegiatan telah selesai. Apakah Anda yakin ingin memindahkannya ke Arsip Kegiatan?' : 'Apakah Anda yakin ingin menghapus kegiatan '.addslashes($k->judul).'?' }}')"
                                            title="{{ $k->isPassed() ? 'Pindahkan ke Arsip Kegiatan' : 'Hapus Kegiatan' }}"
                                            style="width:34px;height:34px;border-radius:10px;background:{{ $k->isPassed() ? '#ECFDF5' : '#FEF2F2' }};border:1.5px solid {{ $k->isPassed() ? '#A7F3D0' : '#FCA5A5' }};display:inline-flex;align-items:center;justify-content:center;color:{{ $k->isPassed() ? '#10B981' : '#EF4444' }};cursor:pointer;transition:all .18s;padding:0;flex-shrink:0;"
                                            onmouseover="this.style.background='{{ $k->isPassed() ? '#10B981' : '#EF4444' }}';this.style.color='#FFFFFF';this.style.borderColor='#131218';" onmouseout="this.style.background='{{ $k->isPassed() ? '#ECFDF5' : '#FEF2F2' }}';this.style.color='{{ $k->isPassed() ? '#10B981' : '#EF4444' }}';this.style.borderColor='{{ $k->isPassed() ? '#A7F3D0' : '#FCA5A5' }}';">
                                        @include('components.icon',['name'=>$k->isPassed() ? 'archive' : 'trash','size'=>15])
                                    </button>
                                </form>
                            </div>
                            @include('admin.kegiatan.partials.edit-modal', ['kegiatan' => $k])
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:48px 24px;text-align:center;color:#94A3B8;">
                            <div style="width:56px;height:56px;border-radius:18px;background:#F8FAFC;border:2px solid #E2E8F0;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:#94A3B8;">
                                @include('components.icon',['name'=>'zap','size'=>26])
                            </div>
                            <p style="font-size:15px;font-weight:900;color:#131218;margin:0 0 6px;">Belum Ada Kegiatan Aktif</p>
                            <p style="font-size:13px;color:#64748B;margin:0 0 20px;font-weight:500;">Aktifkan jadwal pelatihan atau sertifikasi untuk mulai menerima pendaftaran publik.</p>
                            <div style="display:flex;gap:10px;justify-content:center;">
                                <a href="{{ route('admin.jadwal-pelatihan.index') }}" style="padding:9px 18px;font-size:12.5px;font-weight:800;background:#131218;color:#FFFFFF;border-radius:30px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                                    @include('components.icon',['name'=>'book-open','size'=>14,'style'=>'color:#FFC81A']) Jadwal Pelatihan
                                </a>
                                <a href="{{ route('admin.jadwal-sertifikasi.index') }}" style="padding:9px 18px;font-size:12.5px;font-weight:800;background:#FFC81A;color:#131218;border-radius:30px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                                    @include('components.icon',['name'=>'award','size'=>14]) Jadwal Sertifikasi
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards List View (< 768px) --}}
        <div class="fcc-kegiatan-mobile-list">
            @forelse($kegiatan as $k)
            @php
                $isPel = $k->jenis_kegiatan === 'pelatihan';
                $isPassed = $k->isPassed();
                $detail = $k->detail;
            @endphp
            <div class="fcc-mobile-item-card" style="background:#FFFFFF;border:1.5px solid #E2E8F0;border-left:4px solid {{ $isPassed ? '#F59E0B' : '#FFC81A' }};border-radius:16px;padding:16px 18px;box-shadow:0 3px 12px rgba(0,0,0,0.03);position:relative;">
                {{-- 1. Top Badges: Jenis & Status --}}
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:12px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;background:{{ $isPel?'#FFFDF5':'#EFF6FF' }};color:{{ $isPel?'#B38F00':'#2563EB' }};border:1px solid {{ $isPel?'#FFC81A':'#93C5FD' }};display:inline-flex;align-items:center;gap:4px;">
                            @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>12,'style'=>'color:'.($isPel?'#B38F00':'#2563EB')])
                            {{ ucfirst($k->jenis_kegiatan) }}
                        </span>
                        @if($k->isDraf())
                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#F3F4F6;color:#4B5563;border:1px solid #D1D5DB;">Draft</span>
                        @elseif($k->isComingSoon())
                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#FEF3C7;color:#D97706;border:1px solid #FCD34D;">Coming Soon</span>
                        @else
                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#ECFDF5;color:#10B981;border:1px solid #6EE7B7;">Public</span>
                        @endif
                    </div>
                    
                    <div style="display:flex;align-items:center;gap:6px;">
                        @if($isPassed)
                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#FEF3C7;color:#D97706;border:1px solid #FCD34D;display:inline-flex;align-items:center;gap:3px;">
                            @include('components.icon',['name'=>'alert-triangle','size'=>10,'style'=>'color:#D97706;flex-shrink:0;'])
                            Lewat Tanggal
                        </span>
                        @endif
                        @if($k->isFull())
                        <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:#FEE2E2;color:#EF4444;border:1px solid #FCA5A5;">Penuh</span>
                        @endif
                    </div>
                </div>

                {{-- 2. Judul Kegiatan --}}
                <a href="{{ route('admin.kegiatan.show', $k) }}" style="font-size:14.5px;font-weight:900;color:#131218;text-decoration:none;margin:0 0 12px;display:block;line-height:1.35;word-break:break-word;">
                    {{ $k->judul }}
                </a>

                {{-- 3. Info Box: Jadwal, Biaya, Kuota --}}
                <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;padding:12px;margin-bottom:14px;display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <span style="font-size:10px;font-weight:800;color:#64748B;display:block;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:2px;">Jadwal</span>
                        <p style="margin:0;font-size:12.5px;font-weight:800;color:#131218;">{{ $k->jadwal?->tgl_pelaksanaan?->translatedFormat('d M Y') ?? 'TBA' }}</p>
                        @if($k->jadwal?->jam_mulai)
                        <span style="font-size:11px;color:#64748B;font-weight:600;display:inline-flex;align-items:center;gap:3px;margin-top:2px;">
                            @include('components.icon',['name'=>'clock','size'=>11,'style'=>'color:#94A3B8;flex-shrink:0;'])
                            {{ substr($k->jadwal->jam_mulai, 0, 5) }} &ndash; {{ substr($k->jadwal->jam_selesai, 0, 5) }}
                        </span>
                        @endif
                    </div>

                    <div>
                        <span style="font-size:10px;font-weight:800;color:#64748B;display:block;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:2px;">Status Biaya</span>
                        @if($k->biaya->isEmpty())
                            <span style="font-size:11.5px;font-weight:900;color:#10B981;background:#ECFDF5;border:1px solid #A7F3D0;padding:2px 8px;border-radius:12px;display:inline-block;">Gratis</span>
                        @else
                            <span style="font-size:12.5px;font-weight:900;color:#131218;">
                                Rp {{ number_format($k->biaya->min('nominal'),0,',','.') }}+
                            </span>
                        @endif
                    </div>

                    <div style="grid-column: span 2; border-top: 1px dashed #E2E8F0; padding-top: 8px;">
                        <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748B;margin-bottom:4px;font-weight:800;">
                            <span>Kuota &amp; Peserta</span>
                            <span style="color:#131218;">{{ $k->terisi }} / {{ $k->kuota }}</span>
                        </div>
                        <div style="height:6px;background:#E2E8F0;border-radius:4px;overflow:hidden;border:1px solid #CBD5E1;">
                            <div style="height:100%;border-radius:3px;
                                background:{{ $k->isFull()?'#EF4444':($k->kuota > 0 && ($k->terisi/$k->kuota)>0.8?'#F59E0B':'#131218') }};
                                width:{{ $k->kuota>0?min(100,round($k->terisi/$k->kuota*100)):0 }}%;"></div>
                        </div>
                    </div>
                </div>

                {{-- 4. Action Buttons Bar (Lega, Bersih, Touch-Friendly) --}}
                <div style="display:grid;grid-template-columns:1fr 1fr 38px;gap:8px;padding-top:12px;border-top:1px dashed #E2E8F0;">
                    <a href="{{ route('admin.kegiatan.show', $k) }}"
                       style="height:38px;padding:0 12px;font-size:12.5px;font-weight:800;background:#F8FAFC;border:1.5px solid #CBD5E1;border-radius:10px;color:#131218;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .15s;">
                        @include('components.icon',['name'=>'eye','size'=>14])
                        <span>Detail</span>
                    </a>
                    <button type="button" onclick="document.getElementById('edit-kegiatan-modal-{{ $k->id }}').style.display='flex'"
                            style="height:38px;padding:0 12px;font-size:12.5px;font-weight:800;color:#131218;background:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .15s;">
                        @include('components.icon',['name'=>'edit','size'=>14])
                        <span>Edit</span>
                    </button>
                    <form action="{{ route('admin.kegiatan.destroy', $k) }}" method="POST" style="margin:0;display:inline-flex;">
                        @csrf @method('DELETE')
                        <button type="button" onclick="fccConfirmDelete(this, '{{ $k->isPassed() ? 'Pindahkan ke Arsip' : 'Hapus Kegiatan' }}', '{{ $k->isPassed() ? 'Kegiatan telah selesai. Apakah Anda yakin ingin memindahkannya ke Arsip Kegiatan?' : 'Apakah Anda yakin ingin menghapus kegiatan '.addslashes($k->judul).'?' }}')"
                                style="width:38px;height:38px;font-size:12px;font-weight:800;color:{{ $k->isPassed() ? '#10B981' : '#EF4444' }};background:{{ $k->isPassed() ? '#ECFDF5' : '#FEF2F2' }};border:1.5px solid {{ $k->isPassed() ? '#A7F3D0' : '#FCA5A5' }};border-radius:10px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:all .15s;padding:0;"
                                title="{{ $k->isPassed() ? 'Arsipkan Kegiatan' : 'Hapus Kegiatan' }}">
                            @include('components.icon',['name'=>$k->isPassed() ? 'archive' : 'trash','size'=>15])
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div style="padding:48px 20px;text-align:center;color:#94A3B8;background:#FFFFFF;border-radius:16px;border:1.5px dashed #CBD5E1;">
                <div style="width:48px;height:48px;border-radius:14px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;color:#94A3B8;">
                    @include('components.icon',['name'=>'zap','size'=>22])
                </div>
                <p style="font-size:14.5px;font-weight:900;color:#131218;margin:0 0 4px;">Belum Ada Kegiatan Aktif</p>
                <p style="font-size:12.5px;color:#64748B;margin:0;">Aktifkan jadwal pelatihan atau sertifikasi untuk mulai menerima pendaftaran publik.</p>
            </div>
            @endforelse
        </div>

        <div class="fcc-kegiatan-pagination-bar" style="padding:14px 20px;border-top:1.5px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <form method="GET" action="{{ url()->current() }}" style="margin:0;">
                    @if(request()->filled('jenis'))
                        <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                    @endif
                    <select name="per_page" onchange="this.form.submit()" class="fcc-input" style="width:auto;font-size:12.5px;height:34px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:700;cursor:pointer;color:#131218;outline:none;" title="Jumlah data per halaman">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / hal</option>
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 / hal</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 / hal</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / hal</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / hal</option>
                </select>
                </form>
                <span style="font-size:12px;color:#64748B;font-weight:600;">
                    Menampilkan {{ $kegiatan->firstItem() ?? 0 }} &ndash; {{ $kegiatan->lastItem() ?? 0 }} dari {{ $kegiatan->total() }} data
                </span>
            </div>
            <div>
                {{ $kegiatan->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
