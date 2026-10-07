@extends('layouts.admin')
@section('title','Presensi Per Kegiatan')
@section('page-title','Presensi Per Kegiatan')

@section('page-content')
<style>
  /* ── FCC PRESENSI RESPONSIVE CONTAINER & SKELETON ── */
  .fcc-presensi-container {
    padding: 24px;
    position: relative;
    box-sizing: border-box;
    max-width: 100%;
  }
  @media (max-width: 1023px) {
    .fcc-presensi-container {
      padding: 18px 16px;
    }
  }
  @media (max-width: 639px) {
    .fcc-presensi-container {
      padding: 14px 12px;
    }
  }
  @media (max-width: 420px) {
    .fcc-presensi-container {
      padding: 12px 8px;
    }
  }

  /* Skeleton Loading Styles */
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
  #presensi-skeleton-overlay {
    transition: opacity 0.35s ease, visibility 0.35s ease;
  }

  /* Skeleton Stat Cards Grid Responsive */
  .fcc-skel-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
  }
  @media (max-width: 1239px) {
    .fcc-skel-stat-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
  }
  @media (max-width: 639px) {
    .fcc-skel-stat-grid {
      grid-template-columns: 1fr;
      gap: 10px;
    }
  }

  /* Presensi Header Responsive */
  .fcc-presensi-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 14px;
  }
  .fcc-presensi-title-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
    flex-wrap: wrap;
  }
  .fcc-presensi-heading {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 0;
    letter-spacing: -0.02em;
  }
  @media (max-width: 639px) {
    .fcc-presensi-heading {
      font-size: 19px;
    }
  }
</style>

<div class="fcc-presensi-container">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <div id="presensi-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:50%;max-width:320px;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:200px;height:12px;"></div>
        </div>
      </div>
      {{-- 4 Stat Cards Skeleton --}}
      <div class="fcc-skel-stat-grid">
        @for($sc=0;$sc<4;$sc++)
        <div style="padding:16px 18px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:14px;">
          <div class="fcc-skeleton-box" style="width:42px;height:42px;border-radius:12px;flex-shrink:0;"></div>
          <div style="flex:1;">
            <div class="fcc-skeleton-box" style="width:65%;height:12px;margin-bottom:6px;"></div>
            <div class="fcc-skeleton-box" style="width:40%;height:20px;"></div>
          </div>
        </div>
        @endfor
      </div>
      {{-- Table Skeleton --}}
      <div style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
          <div class="fcc-skeleton-box" style="width:180px;height:20px;"></div>
          <div style="display:flex;gap:10px;">
            <div class="fcc-skeleton-box" style="width:140px;height:36px;border-radius:10px;"></div>
            <div class="fcc-skeleton-box" style="width:120px;height:36px;border-radius:10px;"></div>
          </div>
        </div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:12px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:12px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('presensi-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div class="fcc-presensi-header">
        <div>
            <div class="fcc-presensi-title-wrap">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Presensi &amp; Kehadiran</span>
                <h1 class="fcc-presensi-heading">Presensi Per Kegiatan</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Pilih kegiatan untuk mencetak lembar presensi fisik (kertas), mengunduh data CSV, atau mengelola presensi real-time.</p>
        </div>
    </div>

    {{-- Livewire Presensi Kegiatan List Component --}}
    @livewire('admin.presensi-kegiatan-list')

</div>
@endsection
