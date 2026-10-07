@extends('layouts.admin')
@section('title','Status Pembayaran')
@section('page-title','Status Pembayaran')

@section('page-content')

<style>
  /* ── FCC PEMBAYARAN MULTI-TIER RESPONSIVE STYLES ─────────────────── */
  .fcc-pembayaran-container {
    padding: 24px;
    position: relative;
    box-sizing: border-box;
    max-width: 100%;
  }
  @media (max-width: 1023px) {
    .fcc-pembayaran-container {
      padding: 20px 16px;
    }
  }
  @media (max-width: 639px) {
    .fcc-pembayaran-container {
      padding: 14px 12px;
    }
  }
  @media (max-width: 420px) {
    .fcc-pembayaran-container {
      padding: 12px 8px;
    }
  }

  /* Skeleton Loading Shimmer */
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
  #pembayaran-skeleton-overlay {
    transition: opacity 0.35s ease, visibility 0.35s ease;
  }

  /* Skeleton Grid Multi-Tier */
  .fcc-skeleton-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
  }
  @media (max-width: 1023px) {
    .fcc-skeleton-stats-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
    }
  }
  @media (max-width: 639px) {
    .fcc-skeleton-stats-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-bottom: 16px;
    }
  }
  @media (max-width: 420px) {
    .fcc-skeleton-stats-grid {
      grid-template-columns: 1fr;
      gap: 8px;
    }
  }

  /* Header Layout */
  .fcc-pembayaran-header-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
  }
  .fcc-pembayaran-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
  }
  .fcc-pembayaran-title {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 0;
    letter-spacing: -0.02em;
    line-height: 1.25;
  }
  .fcc-pembayaran-subtitle {
    color: #64748B;
    font-size: 13px;
    margin: 0;
    font-weight: 500;
    line-height: 1.4;
  }
  .fcc-pembayaran-btn-rekening {
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 800;
    background: #FFFFFF;
    color: #131218;
    border-radius: 30px;
    border: 1.5px solid #131218;
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all .18s;
  }
  .fcc-pembayaran-btn-rekening:hover {
    transform: translateY(-2px);
    background: #FFFDF5;
  }

  /* Text switching helpers */
  .fcc-text-desktop { display: inline; }
  .fcc-text-mobile { display: none; }

  @media (max-width: 639px) {
    .fcc-text-desktop { display: none; }
    .fcc-text-mobile { display: inline; }

    .fcc-pembayaran-header-wrap {
      flex-direction: column;
      align-items: stretch;
      gap: 14px;
      margin-bottom: 18px;
    }
    .fcc-pembayaran-title-row {
      flex-direction: column;
      align-items: flex-start;
      gap: 6px;
    }
    .fcc-pembayaran-title {
      font-size: 19px;
    }
    .fcc-pembayaran-subtitle {
      font-size: 12px;
    }
    .fcc-pembayaran-btn-rekening {
      width: 100%;
      justify-content: center;
      padding: 10px 14px;
      font-size: 12.5px;
      box-sizing: border-box;
    }
  }
</style>

<div class="fcc-pembayaran-container">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <div id="pembayaran-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:inherit;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;">
        <div style="max-width:400px;width:100%;">
          <div class="fcc-skeleton-box" style="width:130px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:75%;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:90%;height:12px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:170px;height:40px;border-radius:30px;"></div>
      </div>
      {{-- 4 Stat Cards Skeleton --}}
      <div class="fcc-skeleton-stats-grid">
        @for($sc=0;$sc<4;$sc++)
        <div style="padding:16px 18px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:12px;">
          <div class="fcc-skeleton-box" style="width:42px;height:42px;border-radius:12px;flex-shrink:0;"></div>
          <div style="flex:1;min-width:0;">
            <div class="fcc-skeleton-box" style="width:70%;height:12px;margin-bottom:6px;"></div>
            <div class="fcc-skeleton-box" style="width:45%;height:18px;"></div>
          </div>
        </div>
        @endfor
      </div>
      {{-- Table Skeleton --}}
      <div style="padding:22px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:40px;margin-bottom:12px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:40px;margin-bottom:12px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:40px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('pembayaran-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div class="fcc-pembayaran-header-wrap">
        <div>
            <div class="fcc-pembayaran-title-row">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">
                    <span class="fcc-text-desktop">Transaksi &amp; Finansial</span>
                    <span class="fcc-text-mobile">Finansial</span>
                </span>
                <h1 class="fcc-pembayaran-title">Status Pembayaran</h1>
            </div>
            <p class="fcc-pembayaran-subtitle">Verifikasi, cari, dan kelola semua transaksi pembayaran peserta secara real-time.</p>
        </div>
        <div>
            <a href="{{ route('admin.rekening.index') }}" class="fcc-pembayaran-btn-rekening">
                @include('components.icon',['name'=>'credit-card','size'=>15,'style'=>'color:#131218'])
                <span>Kelola Rekening Tujuan</span>
            </a>
        </div>
    </div>

    {{-- Livewire Pembayaran Manager Component --}}
    @livewire('admin.pembayaran-manager')
</div>

@endsection
