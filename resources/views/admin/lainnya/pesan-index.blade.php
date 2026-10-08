@extends('layouts.admin')
@section('title','Pesan Masuk')
@section('page-title','Pesan Masuk')
@section('page-breadcrumb','Konten / Pesan Masuk')

@section('page-content')
<style>
  /* ── Base Container ── */
  .fcc-pesan-container {
    padding: 24px 28px;
    background: #F6F8FB;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
    box-sizing: border-box;
  }

  /* ── Header Area ── */
  .fcc-pesan-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
  }
  .fcc-pesan-badge-tag {
    background: #FFC81A;
    color: #131218;
    font-size: 11px;
    font-weight: 900;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1.5px solid #131218;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .fcc-pesan-unread-pill {
    background: #131218;
    color: #FFC81A;
    padding: 8px 16px;
    border-radius: 20px;
    border: 1.5px solid #FFC81A;
    font-size: 12.5px;
    font-weight: 900;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  /* ── Filter Bar ── */
  .fcc-pesan-card {
    padding: 24px;
    border-radius: 20px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    box-sizing: border-box;
  }
  .fcc-pesan-filter-form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    width: 100%;
    box-sizing: border-box;
  }
  .fcc-pesan-filter-left {
    display: flex;
    gap: 10px;
    align-items: center;
    flex: 1;
    min-width: 0;
    flex-wrap: nowrap;
  }
  .fcc-pesan-search-box {
    position: relative;
    flex: 1;
    min-width: 180px;
    max-width: 320px;
  }
  .fcc-pesan-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    pointer-events: none;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .fcc-pesan-search-input {
    width: 100% !important;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid #CBD5E1;
    font-size: 13px;
    padding: 0 32px 0 34px !important;
    background: #FFFFFF;
    box-sizing: border-box;
    color: #131218;
    transition: border-color .15s, box-shadow .15s;
  }
  .fcc-pesan-search-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
    background: #FFFFFF;
    outline: none;
  }
  .fcc-pesan-search-clear {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #E2E8F0;
    color: #64748B;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 800;
    text-decoration: none;
    transition: all .15s;
    line-height: 1;
  }
  .fcc-pesan-search-clear:hover {
    background: #CBD5E1;
    color: #0F172A;
  }
  .fcc-pesan-select-wrap {
    flex-shrink: 0;
  }
  .fcc-pesan-select {
    width: 150px !important;
    max-width: 160px;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid #CBD5E1;
    font-size: 13px;
    font-weight: 700;
    padding: 0 30px 0 12px;
    background-color: #FFFFFF;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    box-sizing: border-box;
    cursor: pointer;
    color: #131218;
    flex-shrink: 0;
    transition: border-color .15s, box-shadow .15s;
  }
  .fcc-pesan-select:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
    outline: none;
  }
  .fcc-pesan-btn-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }
  .fcc-pesan-btn-search {
    height: 38px;
    padding: 0 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 900;
    background: #FFC81A;
    color: #131218;
    border: 1.5px solid #131218;
    cursor: pointer;
    box-shadow: 2px 2px 0px #131218;
    transition: all .15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .fcc-pesan-btn-search:hover {
    background: #FFD447;
    transform: translateY(-1px);
    box-shadow: 2px 3px 0px #131218;
  }
  .fcc-pesan-btn-search:active {
    transform: translateY(1px);
    box-shadow: 1px 1px 0px #131218;
  }
  .fcc-pesan-btn-arrow {
    display: inline-block;
    transition: transform .15s;
  }
  .fcc-pesan-btn-search:hover .fcc-pesan-btn-arrow {
    transform: translateX(2px);
  }
  .fcc-pesan-btn-reset {
    padding: 0 12px;
    font-size: 12px;
    height: 38px;
    box-sizing: border-box;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    background: #FEF2F2;
    border: 1.5px solid #FCA5A5;
    color: #EF4444;
    border-radius: 10px;
    font-weight: 800;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
    transition: all .15s;
  }
  .fcc-pesan-btn-reset:hover {
    background: #FEE2E2;
    border-color: #EF4444;
    color: #DC2626;
  }
  .fcc-pesan-badge-wrap {
    display: flex;
    align-items: center;
    flex-shrink: 0;
  }
  .fcc-pesan-total-pill {
    font-size: 11.5px;
    font-weight: 800;
    color: #131218;
    background: #FFC81A;
    padding: 4px 12px;
    border-radius: 20px;
    border: 1.5px solid #131218;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 2px 2px 0px #131218;
    flex-shrink: 0;
    line-height: 1.2;
  }
  .fcc-pesan-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #131218;
    display: inline-block;
    flex-shrink: 0;
  }
  .fcc-pesan-toolbar-top-mobile {
    display: none;
  }

  /* ── Responsive Displays: Desktop Table vs Mobile Cards ── */
  .fcc-pesan-desktop-table {
    display: block;
    overflow-x: auto;
  }
  .fcc-pesan-mobile-list {
    display: none;
    flex-direction: column;
    gap: 12px;
  }

  /* ── Mobile Card Item ── */
  .fcc-pesan-card-item {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 14px;
    padding: 14px;
    box-sizing: border-box;
    transition: all .16s ease-in-out;
    display: flex;
    flex-direction: column;
    gap: 10px;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
  }
  .fcc-pesan-card-item.unread {
    background: #FFFDF5;
    border-color: #FFC81A;
    box-shadow: 0 4px 14px rgba(255,200,26,0.12);
  }
  .fcc-pesan-card-item:hover {
    border-color: #131218;
    transform: translateY(-1px);
  }
  .fcc-pesan-card-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 8px;
  }
  .fcc-pesan-card-sender {
    flex: 1;
    min-width: 0;
  }
  .fcc-pesan-card-name {
    font-size: 14px;
    font-weight: 900;
    color: #131218;
    margin: 0 0 2px;
    line-height: 1.3;
  }
  .fcc-pesan-card-email {
    font-size: 12px;
    color: #64748B;
    margin: 0;
    font-weight: 600;
    word-break: break-all;
  }
  .fcc-pesan-card-msg {
    font-size: 13px;
    color: #334155;
    line-height: 1.5;
    margin: 0;
    word-break: break-word;
    background: #F8FAFC;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #E2E8F0;
  }
  .fcc-pesan-card-foot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px dashed #E2E8F0;
    padding-top: 8px;
    gap: 8px;
  }
  .fcc-pesan-card-time {
    font-size: 11.5px;
    color: #94A3B8;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
  }
  .fcc-pesan-card-actions {
    display: flex;
    gap: 6px;
    align-items: center;
  }

  /* ── Modal Dialog Styles ── */
  .fcc-pesan-modal-card {
    background: #FFFFFF;
    border-radius: 24px;
    padding: 30px;
    max-width: 680px;
    width: 100%;
    position: relative;
    box-shadow: 0 24px 64px rgba(0,0,0,.25);
    border: 2px solid #131218;
    box-sizing: border-box;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
  }
  .fcc-pesan-modal-actions-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1.5px solid #F1F5F9;
    padding-top: 18px;
    flex-wrap: wrap;
    gap: 12px;
  }

  /* ── Responsive Breakpoints ── */
  /* iPad & Tablet Landscape / Portrait (768px to 1023px) */
  @media (max-width: 1023px) and (min-width: 768px) {
    .fcc-pesan-container {
      padding: 20px 16px;
    }
    .fcc-pesan-card {
      padding: 20px 16px;
    }
    .fcc-pesan-filter-form {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
      margin-bottom: 18px;
      flex-wrap: nowrap;
    }
    .fcc-pesan-filter-left {
      display: flex;
      align-items: center;
      gap: 8px;
      flex: 1;
      min-width: 0;
      flex-wrap: nowrap;
    }
    .fcc-pesan-search-box {
      flex: 1;
      min-width: 150px;
      max-width: 280px;
    }
    .fcc-pesan-search-input {
      font-size: 12.5px;
    }
    .fcc-pesan-select {
      width: 135px !important;
      max-width: 140px;
      font-size: 12px;
      padding: 0 26px 0 10px;
    }
    .fcc-pesan-btn-search {
      padding: 0 14px;
      font-size: 12px;
    }
    .fcc-pesan-btn-reset {
      padding: 0 10px;
      font-size: 11.5px;
    }
    .fcc-pesan-total-pill {
      font-size: 11px;
      padding: 3px 10px;
      box-shadow: 1.5px 1.5px 0px #131218;
    }
  }

  /* Mobile Phone & Small Screens (< 768px) */
  @media (max-width: 767px) {
    .fcc-pesan-container {
      padding: 14px 12px;
    }
    .fcc-pesan-header {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
      margin-bottom: 18px;
    }
    .fcc-pesan-unread-pill {
      align-self: flex-start;
      font-size: 11.5px;
      padding: 6px 14px;
    }
    .fcc-pesan-card {
      padding: 14px 12px;
      border-radius: 16px;
    }
    .fcc-pesan-filter-form {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
      margin-bottom: 16px;
    }
    .fcc-pesan-filter-left {
      flex-direction: column;
      align-items: stretch;
      width: 100%;
      gap: 8px;
    }
    .fcc-pesan-search-box {
      width: 100% !important;
      max-width: 100% !important;
    }
    .fcc-pesan-search-input {
      width: 100% !important;
      min-height: 40px;
    }
    .fcc-pesan-select-wrap {
      width: 100%;
    }
    .fcc-pesan-select {
      width: 100% !important;
      max-width: 100% !important;
      min-height: 40px;
    }
    .fcc-pesan-btn-group {
      width: 100%;
      display: flex;
      gap: 8px;
    }
    .fcc-pesan-btn-search {
      flex: 1;
      min-height: 40px;
    }
    .fcc-pesan-btn-reset {
      flex: 1;
      min-height: 40px;
    }
    .fcc-pesan-toolbar-top-mobile {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-bottom: 12px;
      margin-bottom: 12px;
      border-bottom: 1.5px dashed #E2E8F0;
      width: 100%;
      box-sizing: border-box;
    }
    .fcc-pesan-toolbar-title-box {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 11.5px;
      font-weight: 800;
      color: #475569;
      text-transform: uppercase;
      letter-spacing: 0.6px;
    }
    .fcc-pesan-toolbar-top-mobile .fcc-pesan-total-pill {
      font-size: 11px;
      padding: 3.5px 10px;
      box-shadow: 1.5px 1.5px 0px #131218;
    }
    .fcc-pesan-badge-wrap-desktop {
      display: none !important;
    }

    /* Switch display */
    .fcc-pesan-desktop-table {
      display: none !important;
    }
    .fcc-pesan-mobile-list {
      display: flex !important;
    }

    /* Modal Mobile */
    .fcc-pesan-modal-card {
      padding: 20px 16px;
      border-radius: 18px;
      max-height: calc(100vh - 28px);
    }
    .fcc-pesan-modal-actions-wrap {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
    }
    .fcc-pesan-modal-actions-left {
      display: flex;
      flex-direction: column;
      width: 100%;
      gap: 8px;
    }
    .fcc-pesan-modal-actions-left a,
    .fcc-pesan-modal-actions-left button {
      width: 100%;
      justify-content: center;
      min-height: 40px;
    }
    .fcc-pesan-modal-actions-right {
      display: flex;
      width: 100%;
      gap: 8px;
    }
    .fcc-pesan-modal-actions-right form {
      flex: 1;
    }
    .fcc-pesan-modal-actions-right button {
      width: 100%;
      min-height: 40px;
      justify-content: center;
    }
  }

  @media (max-width: 419px) {
    .fcc-pesan-container {
      padding: 10px 8px;
    }
    .fcc-pesan-card-item {
      padding: 12px 10px;
    }
  }
</style>

<div class="fcc-pesan-container">

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
      #pesan-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="pesan-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('pesan-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 350);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div class="fcc-pesan-header">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span class="fcc-pesan-badge-tag">Kotak Masuk</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;font-family:'Outfit',sans-serif;">Pesan Masuk</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Daftar pesan dan pertanyaan yang dikirimkan pengunjung dari halaman Hubungi Kami.</p>
        </div>
        @if($unreadCount > 0)
        <div class="fcc-pesan-unread-pill">
            @include('components.icon',['name'=>'mail','size'=>16,'style'=>'color:#FFC81A'])
            <span>{{ $unreadCount }} Pesan Belum Dibaca</span>
        </div>
        @endif
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div style="background:#ECFDF5;border:2px solid #10B981;border-radius:14px;padding:12px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;box-shadow:0 4px 14px rgba(16,185,129,0.12);">
        @include('components.icon',['name'=>'check','size'=>18,'style'=>'color:#059669;flex-shrink:0'])
        <p style="margin:0;font-size:13px;font-weight:800;color:#065F46;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Filter Toolbar & Table Card --}}
    <div class="fcc-card fcc-pesan-card">
        
        {{-- Mobile Top Row with Counter Badge --}}
        <div class="fcc-pesan-toolbar-top-mobile">
            <div class="fcc-pesan-toolbar-title-box">
                @include('components.icon',['name'=>'filter','size'=>13,'style'=>'color:#475569;'])
                <span>Filter &amp; Pencarian</span>
            </div>
            <span class="fcc-pesan-total-pill">
                <span class="fcc-pesan-badge-dot"></span>
                {{ $pesanList->total() }} Total Pesan
            </span>
        </div>

        <form method="GET" action="{{ route('admin.pesan.index') }}" class="fcc-pesan-filter-form">
            <div class="fcc-pesan-filter-left">
                {{-- Search Box with Icon & Clear Button --}}
                <div class="fcc-pesan-search-box">
                    <span class="fcc-pesan-search-icon">
                        @include('components.icon',['name'=>'search','size'=>14])
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, pesan..." class="fcc-input fcc-pesan-search-input" autocomplete="off">
                    @if(request('q'))
                    <a href="{{ route('admin.pesan.index', array_filter(['status' => request('status')])) }}" class="fcc-pesan-search-clear" title="Hapus teks pencarian">
                        ✕
                    </a>
                    @endif
                </div>

                {{-- Status Dropdown --}}
                <div class="fcc-pesan-select-wrap">
                    <select name="status" onchange="this.form.submit()" class="fcc-input fcc-pesan-select">
                        <option value="">Semua Status</option>
                        <option value="belum_dibaca" {{ request('status')==='belum_dibaca'?'selected':'' }}>Belum Dibaca</option>
                        <option value="dibaca" {{ request('status')==='dibaca'?'selected':'' }}>Sudah Dibaca</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="fcc-pesan-btn-group">
                    <button type="submit" class="fcc-pesan-btn-search">
                        <span>Cari</span>
                        <span class="fcc-pesan-btn-arrow">&rarr;</span>
                    </button>
                    @if(request('q') || request('status'))
                    <a href="{{ route('admin.pesan.index') }}" class="fcc-pesan-btn-reset" title="Reset Filter">
                        ✕ Reset
                    </a>
                    @endif
                </div>
            </div>

            {{-- Desktop Total Counter Pill --}}
            <div class="fcc-pesan-badge-wrap fcc-pesan-badge-wrap-desktop">
                <span class="fcc-pesan-total-pill">
                    <span class="fcc-pesan-badge-dot"></span>
                    {{ $pesanList->total() }} Total Pesan
                </span>
            </div>
        </form>

        {{-- 1. DESKTOP TABLE VIEW (>= 768px) --}}
        <div class="fcc-pesan-desktop-table">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;letter-spacing:0.5px;border-top-left-radius:12px;color:#FFC81A;width:50px;">NO</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;letter-spacing:0.5px;">PENGIRIM</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;letter-spacing:0.5px;">PESAN / PERTANYAAN</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;letter-spacing:0.5px;">STATUS</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;letter-spacing:0.5px;">WAKTU DIKIRIM</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;letter-spacing:0.5px;border-top-right-radius:12px;width:140px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanList as $index => $p)
                    @php
                        $pesanJson = json_encode([
                            'id' => $p->id,
                            'nama' => $p->nama,
                            'email' => $p->email,
                            'pesan' => $p->pesan,
                            'status' => $p->status,
                            'waktu_format' => $p->created_at?->format('d M Y, H:i') . ' WITA',
                        ]);
                    @endphp
                    <tr id="pesan-row-{{ $p->id }}"
                        style="border-bottom:1px solid #E2E8F0;background:{{ $p->status==='belum_dibaca'?'#FFFDF5':($index%2==0?'#FFFFFF':'#F8FAFC') }};transition:all .18s;cursor:pointer;"
                        onclick='openPesanModal({{ $pesanJson }})'
                        onmouseover="this.style.background='#F1F5F9'"
                        onmouseout="this.style.background='{{ $p->status==='belum_dibaca'?'#FFFDF5':($index%2==0?'#FFFFFF':'#F8FAFC') }}'">
                        <td style="padding:14px 16px;font-size:13px;font-weight:800;color:#131218;vertical-align:middle;">
                            {{ $pesanList->firstItem() + $index }}
                        </td>
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;">{{ $p->nama }}</p>
                            <p style="margin:0;font-size:12px;color:#64748B;font-weight:600;">{{ $p->email }}</p>
                        </td>
                        <td style="padding:14px 16px;max-width:320px;vertical-align:middle;">
                            <p style="margin:0;font-size:13px;color:#334155;font-weight:{{ $p->status==='belum_dibaca'?'800':'500' }};white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ Str::limit($p->pesan, 80) }}
                            </p>
                        </td>
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @if($p->status === 'belum_dibaca')
                            <span id="status-badge-{{ $p->id }}" style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:4px 12px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;white-space:nowrap;">
                                Belum Dibaca
                            </span>
                            @else
                            <span id="status-badge-{{ $p->id }}" style="background:#E2E8F0;color:#64748B;font-size:10.5px;font-weight:800;padding:4px 12px;border-radius:20px;border:1px solid #CBD5E1;text-transform:uppercase;white-space:nowrap;">
                                Sudah Dibaca
                            </span>
                            @endif
                        </td>
                        <td style="padding:14px 16px;font-size:12px;color:#64748B;font-weight:600;white-space:nowrap;vertical-align:middle;">
                            {{ $p->created_at?->format('d M Y, H:i') ?? '—' }} WITA
                        </td>
                        <td style="padding:14px 16px;text-align:center;white-space:nowrap;vertical-align:middle;" onclick="event.stopPropagation()">
                            <div style="display:inline-flex;gap:6px;align-items:center;">
                                <button type="button" onclick='openPesanModal({{ $pesanJson }})' class="fcc-btn-gold" style="padding:6px 14px;font-size:12px;border-radius:8px;font-weight:900;cursor:pointer;border:none;">
                                    Detail &rarr;
                                </button>
                                <form action="{{ route('admin.pesan.destroy', $p) }}" method="POST"
                                      onsubmit="return fccConfirmDelete(event, this, 'Hapus Pesan Masuk', 'Apakah Anda yakin ingin menghapus pesan dari {{ addslashes($p->nama) }}? Data yang dihapus tidak dapat dikembalikan.')"
                                      style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="padding:6px 10px;font-size:12px;border-radius:8px;font-weight:800;background:#FEF2F2;color:#DC2626;border:1px solid #EF4444;cursor:pointer;transition:all .15s;"
                                            onmouseover="this.style.background='#DC2626';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#DC2626';">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'mail','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Pesan Masuk Ditemukan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Belum ada pesan yang sesuai dengan kriteria pencarian atau filter Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 2. MOBILE CARD LIST (< 768px) --}}
        <div class="fcc-pesan-mobile-list">
            @forelse($pesanList as $index => $p)
            @php
                $pesanJson = json_encode([
                    'id' => $p->id,
                    'nama' => $p->nama,
                    'email' => $p->email,
                    'pesan' => $p->pesan,
                    'status' => $p->status,
                    'waktu_format' => $p->created_at?->format('d M Y, H:i') . ' WITA',
                ]);
            @endphp
            <div class="fcc-pesan-card-item {{ $p->status === 'belum_dibaca' ? 'unread' : '' }}"
                 id="pesan-card-{{ $p->id }}"
                 onclick='openPesanModal({{ $pesanJson }})'>
                
                {{-- Header Pengirim & Status --}}
                <div class="fcc-pesan-card-head">
                    <div class="fcc-pesan-card-sender">
                        <h4 class="fcc-pesan-card-name">{{ $p->nama }}</h4>
                        <p class="fcc-pesan-card-email">{{ $p->email }}</p>
                    </div>
                    @if($p->status === 'belum_dibaca')
                    <span id="status-badge-m-{{ $p->id }}" style="background:#FFC81A;color:#131218;font-size:10px;font-weight:900;padding:3px 8px;border-radius:16px;border:1px solid #131218;text-transform:uppercase;white-space:nowrap;flex-shrink:0;">
                        Belum Dibaca
                    </span>
                    @else
                    <span id="status-badge-m-{{ $p->id }}" style="background:#E2E8F0;color:#64748B;font-size:10px;font-weight:800;padding:3px 8px;border-radius:16px;border:1px solid #CBD5E1;text-transform:uppercase;white-space:nowrap;flex-shrink:0;">
                        Sudah Dibaca
                    </span>
                    @endif
                </div>

                {{-- Pesan Singkat --}}
                <p class="fcc-pesan-card-msg">
                    {{ Str::limit($p->pesan, 120) }}
                </p>

                {{-- Footer Info & Action --}}
                <div class="fcc-pesan-card-foot" onclick="event.stopPropagation()">
                    <span class="fcc-pesan-card-time">
                        <span>📅</span> {{ $p->created_at?->format('d M Y, H:i') ?? '—' }} WITA
                    </span>
                    <div class="fcc-pesan-card-actions">
                        <button type="button" onclick='openPesanModal({{ $pesanJson }})' class="fcc-btn-gold" style="padding:6px 12px;font-size:11.5px;border-radius:8px;font-weight:900;border:none;">
                            Detail &rarr;
                        </button>
                        <form action="{{ route('admin.pesan.destroy', $p) }}" method="POST"
                              onsubmit="return fccConfirmDelete(event, this, 'Hapus Pesan Masuk', 'Apakah Anda yakin ingin menghapus pesan dari {{ addslashes($p->nama) }}? Data yang dihapus tidak dapat dikembalikan.')"
                              style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" style="padding:6px 10px;font-size:11.5px;border-radius:8px;font-weight:800;background:#FEF2F2;color:#DC2626;border:1px solid #EF4444;cursor:pointer;">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div style="padding:36px 16px;text-align:center;color:#94A3B8;background:#F8FAFC;border-radius:14px;border:1.5px dashed #CBD5E1;">
                <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Pesan Masuk Ditemukan</p>
                <p style="font-size:12px;color:#64748B;margin:0;">Belum ada pesan yang sesuai dengan filter Anda.</p>
            </div>
            @endforelse
        </div>

        @if($pesanList->hasPages())
        <div style="padding:16px 0 0;margin-top:16px;border-top:1px solid #E2E8F0;overflow-x:auto;">
            {{ $pesanList->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ═══ POPUP MODAL DETAIL PESAN MASUK ═════════════════════════════════ --}}
<div id="pesan-detail-modal" onclick="closePesanModal()" role="dialog" aria-modal="true"
     style="display:none;position:fixed;inset:0;z-index:9999999 !important;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:16px;box-sizing:border-box;">
    <div onclick="event.stopPropagation()" class="fcc-pesan-modal-card">
        
        {{-- Close Button X --}}
        <button type="button" onclick="closePesanModal()" aria-label="Tutup" style="
            position:absolute;top:18px;right:18px;width:32px;height:32px;
            border:1.5px solid #131218;background:#F1F5F9;cursor:pointer;color:#131218;
            font-size:18px;line-height:1;border-radius:8px;transition:all .15s;display:flex;align-items:center;justify-content:center;font-weight:900;"
            onmouseover="this.style.background='#FFC81A';"
            onmouseout="this.style.background='#F1F5F9';">&#215;</button>

        {{-- Modal Header --}}
        <div style="margin-bottom:18px;border-bottom:1.5px solid #F1F5F9;padding-bottom:16px;padding-right:32px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                <span style="background:#FFC81A;color:#131218;font-size:10px;font-weight:900;padding:2px 8px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;">
                    Informasi Pengirim
                </span>
                <span id="modal-pesan-waktu" style="font-size:11.5px;color:#64748B;font-weight:700;"></span>
            </div>
            <h2 id="modal-pesan-nama" style="font-size:20px;font-weight:900;color:#131218;margin:0 0 4px;font-family:'Outfit',sans-serif;word-break:break-word;"></h2>
            <p style="font-size:13px;color:#64748B;margin:0;font-weight:600;word-break:break-all;">
                Email: <a id="modal-pesan-email" href="#" target="_blank" style="color:#2563EB;text-decoration:none;font-weight:800;"></a>
            </p>
        </div>

        {{-- Modal Message Content --}}
        <div style="margin-bottom:20px;">
            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">
                Isi Pesan / Pertanyaan:
            </label>
            <div id="modal-pesan-isi" style="background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:14px;padding:16px;font-size:13.5px;color:#1E293B;line-height:1.7;white-space:pre-wrap;font-weight:500;max-height:260px;overflow-y:auto;box-shadow:inset 0 2px 4px rgba(0,0,0,0.02);word-break:break-word;">
            </div>
        </div>

        {{-- Modal Actions Footer --}}
        <div class="fcc-pesan-modal-actions-wrap">
            <div class="fcc-pesan-modal-actions-left" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                <a id="modal-pesan-gmail-btn" href="#" target="_blank" class="fcc-btn-gold" style="padding:10px 16px;font-size:12px;border-radius:10px;font-weight:900;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 3px 10px rgba(255,200,26,0.3);">
                    @include('components.icon',['name'=>'mail','size'=>14,'style'=>'color:#131218']) Balas via Gmail &rarr;
                </a>

                <a id="modal-pesan-mailto-btn" href="#" style="padding:10px 14px;font-size:12px;border-radius:10px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:6px;background:#F1F5F9;color:#334155;border:1.5px solid #CBD5E1;transition:all .18s;" title="Buka aplikasi email default komputer (Outlook/Mail)">
                    💻 Mailto
                </a>

                <button type="button" onclick="copyModalEmail()" style="padding:10px 14px;font-size:12px;border-radius:10px;font-weight:800;background:#F8FAFC;color:#475569;border:1.5px solid #CBD5E1;cursor:pointer;display:inline-flex;align-items:center;gap:6px;" title="Salin alamat email pengirim">
                    📋 Salin Email
                </button>
            </div>

            <div class="fcc-pesan-modal-actions-right" style="display:flex;gap:8px;align-items:center;">
                <form id="modal-pesan-delete-form" action="" method="POST"
                      onsubmit="return fccConfirmDelete(event, this, 'Hapus Pesan Masuk', 'Apakah Anda yakin ingin menghapus pesan ini? Data yang dihapus tidak dapat dikembalikan.')"
                      style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" style="padding:10px 16px;font-size:12.5px;font-weight:800;background:#FEF2F2;color:#DC2626;border:1.5px solid #EF4444;border-radius:10px;cursor:pointer;transition:all .18s;"
                            onmouseover="this.style.background='#DC2626';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#DC2626';">
                        Hapus Pesan
                    </button>
                </form>

                <button type="button" onclick="closePesanModal()" class="fcc-btn-outline-dark" style="padding:10px 16px;font-size:12.5px;font-weight:800;border-radius:10px;cursor:pointer;">
                    Tutup
                </button>
            </div>
        </div>

    </div>
</div>

<script>
let currentModalEmail = '';

function openPesanModal(pesan) {
    currentModalEmail = pesan.email;
    document.getElementById('modal-pesan-nama').textContent = pesan.nama;
    
    const mailLink = document.getElementById('modal-pesan-email');
    mailLink.textContent = pesan.email;
    
    const subject = encodeURIComponent('Re: Pesan dari FIKOM Certification Center');
    
    const quoteMsg = pesan.pesan.length > 250 ? pesan.pesan.substring(0, 250) + '...' : pesan.pesan;
    const bodyStr  = "\n\n--------------------------------------------------\n" +
                     "Membalas Pesan Dari: " + pesan.nama + " (" + pesan.email + ")\n" +
                     "\"" + quoteMsg + "\"";
    const body = encodeURIComponent(bodyStr);
    
    const gmailUrl  = 'https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=' + encodeURIComponent(pesan.email) + '&su=' + subject + '&body=' + body;
    const mailtoUrl = 'mailto:' + encodeURIComponent(pesan.email) + '?subject=' + subject + '&body=' + body;
    
    mailLink.href = gmailUrl;
    document.getElementById('modal-pesan-gmail-btn').href = gmailUrl;
    document.getElementById('modal-pesan-mailto-btn').href = mailtoUrl;
    
    document.getElementById('modal-pesan-waktu').textContent = 'Diterima: ' + pesan.waktu_format;
    document.getElementById('modal-pesan-isi').textContent = pesan.pesan;
    document.getElementById('modal-pesan-delete-form').action = '{{ url("admin/pesan") }}/' + pesan.id;
    
    const overlay = document.getElementById('pesan-detail-modal');
    overlay.style.display = 'flex';

    // Auto mark as read via AJAX if status was 'belum_dibaca'
    if (pesan.status === 'belum_dibaca') {
        fetch('{{ url("admin/pesan") }}/' + pesan.id + '/read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(r => r.json()).then(data => {
            if (data.success) {
                pesan.status = 'dibaca';
                const badge = document.getElementById('status-badge-' + pesan.id);
                if (badge) {
                    badge.style.background = '#E2E8F0';
                    badge.style.color = '#64748B';
                    badge.style.borderColor = '#CBD5E1';
                    badge.textContent = 'Sudah Dibaca';
                }
                const badgeM = document.getElementById('status-badge-m-' + pesan.id);
                if (badgeM) {
                    badgeM.style.background = '#E2E8F0';
                    badgeM.style.color = '#64748B';
                    badgeM.style.borderColor = '#CBD5E1';
                    badgeM.textContent = 'Sudah Dibaca';
                }
                const row = document.getElementById('pesan-row-' + pesan.id);
                if (row) {
                    row.style.background = '#FFFFFF';
                }
                const card = document.getElementById('pesan-card-' + pesan.id);
                if (card) {
                    card.classList.remove('unread');
                }
            }
        }).catch(err => console.error(err));
    }
}

function copyModalEmail() {
    if (!currentModalEmail) return;
    navigator.clipboard.writeText(currentModalEmail).then(() => {
        if (typeof window.fccToast === 'function') {
            window.fccToast('Alamat email ' + currentModalEmail + ' berhasil disalin!', 'success');
        } else {
            alert('Alamat email ' + currentModalEmail + ' berhasil disalin!');
        }
    }).catch(err => {
        console.error('Gagal menyalin email: ', err);
    });
}

function closePesanModal() {
    document.getElementById('pesan-detail-modal').style.display = 'none';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePesanModal();
});
</script>
@endsection
