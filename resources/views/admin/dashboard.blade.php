@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')

@push('styles')
<style>
  .calendar-day-cell { position: relative; }
  .calendar-day-cell[data-tooltip]:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-6px);
    background: #131218;
    color: #FFC81A;
    font-size: 11px;
    font-weight: 800;
    padding: 6px 12px;
    border-radius: 8px;
    border: 1.5px solid #FFC81A;
    white-space: nowrap;
    pointer-events: none;
    z-index: 100;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  }

  /* ═══ RESPONSIVE DASHBOARD MULTI-TIER DESIGN SYSTEM ═══ */
  .fcc-dashboard-wrapper {
    padding: 24px 28px;
    background: #F6F8FB;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
    box-sizing: border-box;
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
  }

  /* 4-Stat Cards Grid (Default Desktop >= 1240px) */
  .fcc-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 24px;
  }
  .taskora-stat-link {
    text-decoration: none;
    display: flex;
    flex-direction: column;
    height: 100%;
  }
  .fcc-stat-card {
    padding: 20px;
    border-radius: 18px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all .28s ease;
    box-sizing: border-box;
    min-width: 0;
    height: 100%;
  }
  .fcc-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .fcc-stat-body {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
  }
  .fcc-stat-lbl {
    margin: 0 0 2px;
    color: #64748B;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .fcc-stat-val {
    margin: 0;
    color: #131218;
    font-size: 24px;
    font-weight: 900;
    letter-spacing: -0.02em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
  }
  .fcc-stat-suf {
    margin: 2px 0 0;
    font-size: 11px;
    color: #131218;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* Main Layout Grid */
  .fcc-dashboard-main-grid {
    display: grid;
    grid-template-columns: 1fr 330px;
    gap: 24px;
    align-items: start;
  }
  .fcc-dashboard-main-col {
    display: flex;
    flex-direction: column;
    gap: 24px;
    min-width: 0;
  }
  .fcc-dashboard-sidebar-widgets {
    display: flex;
    flex-direction: column;
    gap: 24px;
    min-width: 0;
  }

  /* Action Banner */
  .fcc-action-banner {
    background: #FFFDF5;
    border: 2px solid #FFC81A;
    border-radius: 18px;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    box-shadow: 0 6px 18px rgba(255, 200, 26, 0.15);
  }
  .fcc-action-banner-body {
    display: flex;
    align-items: center;
    gap: 16px;
    flex: 1;
    min-width: 0;
  }
  .fcc-action-banner-icon {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: #FFC81A;
    border: 1.5px solid #131218;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(255,200,26,0.3);
  }
  .fcc-action-banner-title {
    margin: 0;
    font-weight: 900;
    color: #131218;
    font-size: 14.5px;
  }
  .fcc-action-banner-desc {
    margin: 2px 0 0;
    font-size: 12px;
    color: #4B5563;
    font-weight: 500;
  }
  .fcc-action-banner-btn {
    padding: 9px 20px;
    font-size: 12.5px;
    font-weight: 800;
    text-decoration: none;
    flex-shrink: 0;
    background: #131218;
    color: #FFC81A;
    border-radius: 30px;
    border: 1.5px solid #131218;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all .18s ease;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  /* Expired Activities */
  .fcc-expired-card {
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    border-radius: 18px;
    padding: 18px 22px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  }
  .fcc-expired-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
    flex-wrap: wrap;
  }
  .fcc-expired-items-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
  }
  .fcc-expired-item {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  /* Chart Card */
  .fcc-chart-card {
    padding: 24px;
    border-radius: 20px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  }
  .fcc-chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    gap: 14px;
    flex-wrap: wrap;
  }
  .fcc-chart-controls {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
  }
  .fcc-chart-legend {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 12px;
    font-weight: 800;
  }
  .fcc-chart-selects {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .fcc-chart-canvas-wrapper {
    position: relative;
    height: 270px;
    width: 100%;
  }

  /* Table Card */
  .fcc-table-card {
    padding: 0;
    overflow: hidden;
    border-radius: 20px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  }
  .fcc-table-header {
    padding: 18px 24px;
    border-bottom: 2px solid #E5E7EB;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #F8FAFC;
    gap: 12px;
    flex-wrap: wrap;
  }
  .fcc-table-wrapper {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  .fcc-table {
    width: 100%;
    min-width: 580px;
    border-collapse: collapse;
  }

  /* Mobile Kegiatan Cards List (< 640px) */
  .fcc-dashboard-kegiatan-mobile-list {
    display: none;
    padding: 12px;
    gap: 10px;
  }
  .fcc-kegiatan-m-card {
    background: #FFFFFF;
    border: 1.5px solid #E5E7EB;
    border-radius: 14px;
    padding: 14px;
    transition: all .2s ease;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
  }
  .fcc-kegiatan-m-card:hover {
    border-color: #FFC81A;
    box-shadow: 0 6px 16px rgba(255, 200, 26, 0.15);
  }
  .fcc-kegiatan-m-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 12px;
  }
  .fcc-kegiatan-m-title {
    margin: 0 0 6px;
    font-size: 13.5px;
    font-weight: 800;
    color: #131218;
    line-height: 1.35;
  }
  .fcc-kegiatan-m-badge {
    font-size: 9.5px;
    font-weight: 900;
    padding: 3px 8px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
  }
  .fcc-kegiatan-m-btn {
    font-size: 11.5px;
    font-weight: 800;
    color: #131218;
    background: #FFC81A;
    border: 1px solid #131218;
    padding: 5px 12px;
    border-radius: 18px;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    transition: all .15s ease;
  }
  .fcc-kegiatan-m-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding-top: 10px;
    border-top: 1px solid #F1F5F9;
    font-size: 12px;
  }
  .fcc-kegiatan-m-date {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: #64748B;
    font-weight: 600;
    font-size: 11.5px;
    white-space: nowrap;
  }
  .fcc-kegiatan-m-progress-wrap {
    flex: 1;
    max-width: 140px;
    display: flex;
    flex-direction: column;
    gap: 3px;
  }
  .fcc-kegiatan-m-quota-lbl {
    display: flex;
    justify-content: space-between;
    font-size: 10.5px;
    color: #64748B;
  }
  .fcc-kegiatan-m-quota-lbl strong {
    color: #131218;
    font-weight: 800;
  }
  .fcc-kegiatan-m-progress-bar {
    width: 100%;
    height: 5px;
    background: #E5E7EB;
    border-radius: 3px;
    overflow: hidden;
  }

  /* Right Side Widgets */
  .fcc-widget-card {
    padding: 22px;
    border-radius: 20px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  }

  /* ══════════════════════════════════════════════════════════════════
     TIER 1: LAPTOP & MEDIUM DESKTOP (1024px – 1239px)
     Sidebar: 256px visible. Viewport content: 768px – 983px
     ══════════════════════════════════════════════════════════════════ */
  @media (max-width: 1239px) {
    .fcc-dashboard-wrapper {
      padding: 20px 20px;
    }
    .fcc-dashboard-main-grid {
      grid-template-columns: 1fr;
      gap: 22px;
    }
    .fcc-dashboard-sidebar-widgets {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      align-items: start;
    }
    .fcc-widget-full-on-grid {
      grid-column: span 2;
    }
    .fcc-stats-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }
    .fcc-chart-canvas-wrapper {
      height: 250px;
    }
  }

  /* ══════════════════════════════════════════════════════════════════
     TIER 2: TABLET STANDARD (768px – 1023px, iPad Air / Pro Portrait)
     Sidebar: Off-canvas (0px). Full Viewport: 768px – 1023px
     ══════════════════════════════════════════════════════════════════ */
  @media (min-width: 768px) and (max-width: 1023px) {
    .fcc-dashboard-wrapper {
      padding: 18px 18px;
    }
    .fcc-stats-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }
    .fcc-dashboard-main-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }
    .fcc-dashboard-sidebar-widgets {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 18px;
      align-items: start;
    }
    .fcc-widget-full-on-grid {
      grid-column: span 2;
    }
    .fcc-chart-card,
    .fcc-widget-card {
      padding: 20px 18px;
    }
    .fcc-chart-canvas-wrapper {
      height: 240px;
    }
  }

  /* ══════════════════════════════════════════════════════════════════
     TIER 3: SMALL TABLET / MOBILE LANDSCAPE / PHABLET (640px – 767px)
     ══════════════════════════════════════════════════════════════════ */
  @media (min-width: 640px) and (max-width: 767px) {
    .fcc-dashboard-wrapper {
      padding: 16px 14px;
    }
    .fcc-stats-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
      margin-bottom: 18px;
    }
    .fcc-stat-card {
      padding: 16px 14px;
      gap: 12px;
    }
    .fcc-stat-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
    }
    .fcc-stat-val {
      font-size: 20px;
    }
    .fcc-dashboard-main-grid {
      grid-template-columns: 1fr;
      gap: 18px;
    }
    .fcc-dashboard-sidebar-widgets {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
      align-items: start;
    }
    .fcc-widget-full-on-grid {
      grid-column: span 2;
    }
    .fcc-chart-card,
    .fcc-widget-card {
      padding: 18px 16px;
    }
    .fcc-chart-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 12px;
    }
    .fcc-chart-controls {
      width: 100%;
      justify-content: space-between;
    }
    .fcc-chart-canvas-wrapper {
      height: 230px;
    }
  }

  /* ══════════════════════════════════════════════════════════════════
     TIER 4: STANDARD MOBILE (420px – 639px)
     ══════════════════════════════════════════════════════════════════ */
  @media (max-width: 639px) {
    .fcc-dashboard-wrapper {
      padding: 14px 10px;
    }
    .fcc-stats-grid {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 10px !important;
      margin-bottom: 16px !important;
    }
    .taskora-stat-link {
      display: flex !important;
      flex-direction: column !important;
      height: 100% !important;
      text-decoration: none !important;
    }
    .fcc-stat-card {
      flex-direction: column !important;
      align-items: flex-start !important;
      justify-content: space-between !important;
      padding: 12px 11px !important;
      border-radius: 16px !important;
      height: 100% !important;
      min-height: 136px !important;
      box-sizing: border-box !important;
      gap: 10px !important;
    }
    .fcc-stat-icon {
      width: 38px !important;
      height: 38px !important;
      border-radius: 11px !important;
      flex-shrink: 0 !important;
    }
    .fcc-stat-icon svg {
      width: 18px !important;
      height: 18px !important;
    }
    .fcc-stat-body {
      width: 100% !important;
      min-width: 0 !important;
      display: flex !important;
      flex-direction: column !important;
    }
    .fcc-stat-lbl {
      font-size: 10px !important;
      font-weight: 800 !important;
      color: #64748B !important;
      text-transform: uppercase !important;
      letter-spacing: 0.3px !important;
      margin: 0 0 2px !important;
    }
    .fcc-stat-val {
      font-size: 17px !important;
      font-weight: 900 !important;
      color: #131218 !important;
      letter-spacing: -0.02em !important;
      line-height: 1.2 !important;
      margin: 0 !important;
    }
    .fcc-stat-suf {
      font-size: 10px !important;
      color: #131218 !important;
      font-weight: 700 !important;
      margin: 2px 0 0 !important;
    }

    /* Main Grid & Widgets */
    .fcc-dashboard-main-grid {
      grid-template-columns: 1fr !important;
      gap: 16px !important;
    }
    .fcc-dashboard-sidebar-widgets {
      display: flex !important;
      flex-direction: column !important;
      gap: 16px !important;
    }
    .fcc-widget-full-on-grid {
      grid-column: auto !important;
    }

    /* Action Banner Mobile Stacking */
    .fcc-action-banner {
      flex-direction: column;
      align-items: stretch;
      padding: 14px 14px;
      gap: 12px;
      border-radius: 16px;
    }
    .fcc-action-banner-body {
      gap: 12px;
    }
    .fcc-action-banner-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
    }
    .fcc-action-banner-title {
      font-size: 13.5px;
    }
    .fcc-action-banner-desc {
      font-size: 11.5px;
    }
    .fcc-action-banner-btn {
      width: 100%;
      text-align: center;
      justify-content: center;
      display: block;
      box-sizing: border-box;
      padding: 10px 16px;
    }

    /* Expired Activities */
    .fcc-expired-card {
      padding: 14px 14px;
      border-radius: 16px;
    }
    .fcc-expired-header {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }
    .fcc-expired-item {
      width: 100%;
      box-sizing: border-box;
      justify-content: space-between;
    }

    /* Chart Card */
    .fcc-chart-card {
      padding: 16px 14px;
      border-radius: 16px;
    }
    .fcc-chart-header {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
      margin-bottom: 14px;
    }
    .fcc-chart-controls {
      width: 100%;
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }
    .fcc-chart-legend {
      justify-content: flex-start;
      gap: 12px;
      font-size: 11.5px;
    }
    .fcc-chart-selects {
      width: 100%;
      display: flex;
      gap: 8px;
    }
    .fcc-chart-selects select {
      flex: 1;
      font-size: 11.5px !important;
      padding: 6px 10px !important;
    }
    .fcc-chart-canvas-wrapper {
      height: 220px;
    }

    /* Kegiatan Aktif Dual Layout */
    .fcc-table-card {
      border-radius: 16px;
    }
    .fcc-table-header {
      padding: 14px 16px;
    }
    .fcc-table-wrapper {
      display: none !important;
    }
    .fcc-dashboard-kegiatan-mobile-list {
      display: flex !important;
      flex-direction: column !important;
    }

    /* Widgets */
    .fcc-widget-card {
      padding: 16px 14px;
      border-radius: 16px;
    }
    #mini-calendar-widget {
      padding: 16px 14px;
    }
    .calendar-day-cell {
      padding: 6px 0 !important;
      font-size: 11.5px !important;
    }
    .calendar-day-cell[data-tooltip]:hover::after {
      display: none !important;
    }
  }

  /* ══════════════════════════════════════════════════════════════════
     TIER 5: COMPACT MOBILE (< 420px, iPhone SE, Galaxy Mini)
     ══════════════════════════════════════════════════════════════════ */
  @media (max-width: 419px) {
    .fcc-dashboard-wrapper {
      padding: 12px 8px;
    }
    .fcc-stats-grid {
      grid-template-columns: 1fr !important;
      gap: 8px !important;
    }
    .fcc-stat-card {
      flex-direction: row !important;
      align-items: center !important;
      justify-content: flex-start !important;
      padding: 12px 14px !important;
      min-height: auto !important;
      gap: 12px !important;
      border-radius: 14px !important;
    }
    .fcc-stat-icon {
      width: 42px !important;
      height: 42px !important;
      border-radius: 12px !important;
    }
    .fcc-stat-val {
      font-size: 18px !important;
    }
    .fcc-chart-canvas-wrapper {
      height: 200px;
    }
    .calendar-day-cell {
      padding: 5px 0 !important;
      font-size: 11px !important;
    }
    .fcc-kegiatan-m-meta {
      flex-direction: column;
      align-items: stretch;
      gap: 8px;
    }
    .fcc-kegiatan-m-progress-wrap {
      max-width: 100%;
    }
    .fcc-verif-item {
      padding: 10px 12px !important;
    }
  }
</style>
@endpush

@section('page-content')
<div class="fcc-dashboard-wrapper">

  {{-- ═══ DASHBOARD SKELETON LOADING OVERLAY ════════════════════════ --}}
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
    #dashboard-skeleton-overlay {
      transition: opacity 0.35s ease, visibility 0.35s ease;
    }
  </style>

  <div id="dashboard-skeleton-overlay" class="no-print fcc-dashboard-wrapper" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;box-sizing:border-box;pointer-events:none;">
    {{-- 4 Stat Cards Skeleton --}}
    <div class="fcc-stats-grid">
      @for($s=0;$s<4;$s++)
      <div class="fcc-stat-card">
        <div class="fcc-skeleton-box fcc-stat-icon" style="flex-shrink:0;"></div>
        <div class="fcc-stat-body" style="flex:1;width:100%;">
          <div class="fcc-skeleton-box" style="width:60%;height:10px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:85%;height:20px;margin-bottom:4px;"></div>
          <div class="fcc-skeleton-box" style="width:40%;height:10px;"></div>
        </div>
      </div>
      @endfor
    </div>

    {{-- 2 Columns Skeleton --}}
    <div class="fcc-dashboard-main-grid">
      {{-- Left Side --}}
      <div class="fcc-dashboard-main-col">
        <div class="fcc-card" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:16px;">
          <div class="fcc-skeleton-box" style="width:46px;height:46px;border-radius:14px;flex-shrink:0;"></div>
          <div style="flex:1;">
            <div class="fcc-skeleton-box" style="width:50%;height:14px;margin-bottom:8px;"></div>
            <div class="fcc-skeleton-box" style="width:80%;height:11px;"></div>
          </div>
          <div class="fcc-skeleton-box" style="width:130px;height:36px;border-radius:30px;"></div>
        </div>

        <div class="fcc-chart-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div style="width:45%;">
              <div class="fcc-skeleton-box" style="width:80%;height:16px;margin-bottom:8px;"></div>
              <div class="fcc-skeleton-box" style="width:100%;height:11px;"></div>
            </div>
            <div class="fcc-skeleton-box" style="width:140px;height:32px;border-radius:10px;"></div>
          </div>
          <div class="fcc-skeleton-box" style="width:100%;height:220px;border-radius:14px;"></div>
        </div>
      </div>

      {{-- Right Side --}}
      <div class="fcc-dashboard-sidebar-widgets">
        <div class="fcc-widget-card">
          <div class="fcc-skeleton-box" style="width:100%;height:28px;margin-bottom:16px;border-radius:8px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:180px;border-radius:12px;"></div>
        </div>
        <div class="fcc-widget-card">
          <div class="fcc-skeleton-box" style="width:60%;height:16px;margin-bottom:16px;"></div>
          <div class="fcc-skeleton-box" style="width:120px;height:120px;border-radius:50%;margin:0 auto 14px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:24px;border-radius:6px;"></div>
        </div>
        <div class="fcc-widget-card fcc-widget-full-on-grid">
          <div class="fcc-skeleton-box" style="width:40%;height:16px;margin-bottom:16px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:80px;border-radius:8px;"></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function() {
      setTimeout(function() {
        var sk = document.getElementById('dashboard-skeleton-overlay');
        if (sk) {
          sk.style.opacity = '0';
          sk.style.visibility = 'hidden';
          setTimeout(function() { sk.style.display = 'none'; }, 350);
        }
      }, 450);
    })();
  </script>



  {{-- Stat Cards Grid (4 Columns Aligned with Home Page Aesthetics) --}}
  <div id="stats-grid" class="fcc-stats-grid">
    @foreach([
      ['Total Pelatihan',   $stats['pelatihan'],   'Program aktif',     'book-open',   '#FFC81A', '#131218', 'rgba(255,200,26,0.3)', route('admin.pelatihan.index')],
      ['Total Sertifikasi', $stats['sertifikasi'], 'Sertifikasi resmi', 'award',       '#131218', '#FFC81A', 'rgba(19,18,24,0.25)',   route('admin.sertifikasi.index')],
      ['Total Peserta',     number_format($stats['peserta']), 'Siswa/i terdaftar', 'users', '#FFC81A', '#131218', 'rgba(255,200,26,0.3)', route('admin.pengguna.peserta')],
      ['Total Pendapatan',  'Rp '.number_format($stats['pendapatan'],0,',','.'), 'Terverifikasi', 'credit-card', '#131218', '#FFC81A', 'rgba(19,18,24,0.25)', route('admin.laporan.index')],
    ] as [$lbl,$val,$suf,$ic,$bg,$fg,$glow,$link])
    <a href="{{ $link }}" style="text-decoration:none;display:flex;flex-direction:column;" class="taskora-stat-link">
      <div class="fcc-card fcc-stat-card"
           onmouseover="this.style.transform='translateY(-4px)';this.style.borderColor='#FFC81A';this.style.boxShadow='0 14px 28px rgba(255,200,26,0.2)';"
           onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#E5E7EB';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">
        <div class="fcc-stat-icon" style="background:{{ $bg }};border:1.5px solid #131218;box-shadow:0 6px 16px {{ $glow }};">
          @include('components.icon',['name'=>$ic,'size'=>22,'style'=>"color:{$fg}"])
        </div>
        <div class="fcc-stat-body" style="flex:1;min-width:0;">
          <p class="fcc-stat-lbl">{{ $lbl }}</p>
          <p class="fcc-stat-val">{{ $val }}</p>
          <p id="stat-delta-{{ $loop->index }}" class="fcc-stat-suf">{{ $suf }}</p>
        </div>
      </div>
    </a>
    @endforeach
  </div>

  {{-- 2 Columns Grid (Main Area + Side Widgets Area) --}}
  <div class="fcc-dashboard-main-grid">

    {{-- MAIN LEFT AREA (~70% on desktop, 100% on tablet/mobile) --}}
    <div class="fcc-dashboard-main-col">

      {{-- Pending Payment Banner --}}
      @php $pendingBayar = \App\Models\Pembayaran::where('status_pembayaran','menunggu_verifikasi')->count(); @endphp
      @if($pendingBayar > 0)
      <div class="fcc-card fcc-action-banner">
        <div class="fcc-action-banner-body">
          <div class="fcc-action-banner-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          </div>
          <div style="flex:1;min-width:0;">
            <p class="fcc-action-banner-title">{{ $pendingBayar }} Pembayaran Menunggu Verifikasi</p>
            <p class="fcc-action-banner-desc">Ada transaksi peserta yang memerlukan tindakan verifikasi segera.</p>
          </div>
        </div>
        <a href="{{ route('admin.pembayaran.index',['status'=>'menunggu_verifikasi']) }}" class="fcc-action-banner-btn" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Verifikasi Sekarang</a>
      </div>
      @endif

      {{-- Expired Activities Banner --}}
      @php
        $passedKegiatans = \App\Models\Kegiatan::passed()->doesntHave('arsip')->with(['kegiatanPelatihan.jadwalPelatihan.pelatihan', 'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'])->get();
      @endphp
      @if($passedKegiatans->count() > 0)
      <div class="fcc-card fcc-expired-card">
        <div class="fcc-expired-header">
          <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:38px;height:38px;border-radius:12px;background:#FEE2E2;border:1px solid #EF4444;display:flex;align-items:center;justify-content:center;color:#EF4444;font-weight:800;font-size:16px;flex-shrink:0;">
              ⚠
            </div>
            <div>
              <h4 style="margin:0;font-weight:900;color:#131218;font-size:14px;">{{ $passedKegiatans->count() }} Kegiatan Melewati Tanggal Pelaksanaan</h4>
              <p style="margin:2px 0 0;font-size:12px;color:#64748B;">Perpanjang jadwal kegiatan atau pindahkan ke arsip.</p>
            </div>
          </div>
          <a href="{{ route('admin.kegiatan.index') }}" style="padding:7px 16px;font-size:12px;text-decoration:none;flex-shrink:0;background:#131218;color:#FFC81A;border-radius:20px;border:1.5px solid #131218;font-weight:800;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
            Kelola Kegiatan &rarr;
          </a>
        </div>
        <div class="fcc-expired-items-grid">
          @foreach($passedKegiatans->take(4) as $pk)
          @php
            $detail = $pk->detail;
            $editUrl = $pk->jenis_kegiatan === 'pelatihan' ? ($detail ? route('admin.pelatihan.edit', $detail) : '#') : ($detail ? route('admin.sertifikasi.edit', $detail) : '#');
          @endphp
          <div class="fcc-expired-item">
            <span style="font-weight:700;color:#0F172A;flex:1;min-width:140px;">{{ $pk->judul }}</span>
            <span style="color:#64748B;font-size:11px;white-space:nowrap;">(Lewat {{ $pk->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Tgl' }})</span>
            <div style="display:flex;gap:6px;margin-left:auto;">
              <a href="{{ $editUrl }}" style="color:#131218;font-size:11px;font-weight:800;text-decoration:none;background:#FFC81A;padding:4px 10px;border-radius:6px;border:1px solid #131218;white-space:nowrap;">Perpanjang</a>
              <form action="{{ route('admin.kegiatan.arsipkan', $pk) }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" style="color:#FFFFFF;font-size:11px;font-weight:800;background:#131218;padding:4px 10px;border-radius:6px;border:none;cursor:pointer;white-space:nowrap;">Arsipkan</button>
              </form>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      {{-- Combined Combo Chart: Pendapatan & Pendaftaran --}}
      <div class="fcc-card fcc-chart-card">
        <div class="fcc-chart-header">
          <div>
            <h3 style="margin:0 0 2px;font-size:16px;font-weight:900;color:#131218;">Grafik Tren Pendapatan &amp; Pendaftaran</h3>
            <p style="margin:0;font-size:12px;color:#64748B;">Perbandingan pendapatan (Rp) dan jumlah pendaftaran per bulan tahun <span id="chart-year-label">{{ date('Y') }}</span></p>
          </div>
          <div class="fcc-chart-controls">
            <div class="fcc-chart-legend">
              <span style="display:inline-flex;align-items:center;gap:6px;color:#131218;">
                <span style="width:12px;height:12px;border-radius:3px;background:#FFC81A;border:1px solid #131218;"></span> Pendapatan (Rp)
              </span>
              <span style="display:inline-flex;align-items:center;gap:6px;color:#3B82F6;">
                <span style="width:12px;height:12px;border-radius:3px;background:#3B82F6;"></span> Pendaftaran
              </span>
            </div>
            <div class="fcc-chart-selects">
              <select id="chart-metric" class="fcc-input" style="width:auto;font-size:12px;font-weight:800;padding:6px 14px;border-radius:10px;border:1.5px solid #E5E7EB;background:#F8FAFC;">
                <option value="semua" selected>Semua</option>
                <option value="pendapatan">Pendapatan</option>
                <option value="pendaftaran">Pendaftaran</option>
              </select>
              <select id="chart-year" class="fcc-input" style="width:auto;font-size:12px;font-weight:800;padding:6px 14px;border-radius:10px;border:1.5px solid #E5E7EB;background:#F8FAFC;">
                @foreach(range(date('Y'),date('Y')-3) as $y)
                <option value="{{ $y }}" {{ date('Y')==$y?'selected':'' }}>Tahun {{ $y }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="fcc-chart-canvas-wrapper">
          <canvas id="chartPendapatanPendaftaran"></canvas>
        </div>
      </div>

      {{-- Widget 3: Tabel & Kartu Kegiatan Aktif Terbaru --}}
      <div class="fcc-card fcc-table-card">
        <div class="fcc-table-header">
          <div>
            <h3 style="margin:0 0 2px;font-size:16px;font-weight:900;color:#131218;">Kegiatan Aktif Terbaru</h3>
            <p style="margin:0;font-size:12px;color:#64748B;">Program yang sedang berjalan dan membuka pendaftaran</p>
          </div>
          <a href="{{ route('admin.kegiatan.index') }}" style="font-size:12px;font-weight:800;color:#131218;text-decoration:none;background:#FFC81A;padding:6px 14px;border-radius:20px;border:1px solid #131218;transition:all .18s;" onmouseover="this.style.background='#131218';this.style.color='#FFC81A';" onmouseout="this.style.background='#FFC81A';this.style.color='#131218';">Lihat semua &rarr;</a>
        </div>

        {{-- Desktop & Tablet Table (>= 640px) --}}
        <div class="fcc-table-wrapper">
          <table class="fcc-table">
            <thead>
              <tr style="background:#F8FAFC;border-bottom:1.5px solid #E5E7EB;">
                <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;min-width:180px;">Kegiatan</th>
                <th style="padding:12px 14px;text-align:center;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;width:110px;min-width:110px;">Peserta</th>
                <th style="padding:12px 14px;text-align:center;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;width:130px;min-width:130px;">Tgl Pelaksanaan</th>
                <th style="padding:12px 16px;text-align:center;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;width:110px;min-width:110px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kegiatanTerbaru as $k)
              <tr style="border-top:1px solid #F1F5F9;transition:background .15s;cursor:pointer;" onclick="if(!event.target.closest('button, a, select, input, form')) window.location.href='{{ route('admin.kegiatan.show', $k) }}'" onmouseover="this.style.background='#FAFAFA'" onmouseout="this.style.background=''">
                <td style="padding:14px 18px;vertical-align:middle;">
                  <p style="margin:0 0 4px;font-size:13.5px;font-weight:800;color:#131218;max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $k->judul }}</p>
                  <span style="font-size:10px;font-weight:900;padding:3px 9px;border-radius:6px;text-transform:uppercase;letter-spacing:0.5px;background:{{ $k->jenis_kegiatan==='pelatihan'?'#FFC81A':'#131218' }};color:{{ $k->jenis_kegiatan==='pelatihan'?'#131218':'#FFC81A' }};border:1px solid #131218;">{{ ucfirst($k->jenis_kegiatan) }}</span>
                </td>
                <td style="padding:14px 14px;text-align:center;vertical-align:middle;white-space:nowrap;">
                  <p style="margin:0 0 4px;font-size:13px;font-weight:800;color:#131218;">{{ $k->terisi }}/{{ $k->kuota }}</p>
                  <div style="width:80px;height:5px;background:#E5E7EB;border-radius:3px;overflow:hidden;margin:0 auto;">
                    <div style="height:5px;border-radius:3px;background:{{ $k->isFull()?'#EF4444':'#FFC81A' }};width:{{ $k->kuota>0?min(100,round($k->terisi/$k->kuota*100)):0 }}%;"></div>
                  </div>
                </td>
                <td style="padding:14px 14px;text-align:center;vertical-align:middle;font-size:12.5px;color:#4B5563;font-weight:600;white-space:nowrap;">{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? '—' }}</td>
                <td style="padding:14px 16px;text-align:center;vertical-align:middle;white-space:nowrap;width:110px;min-width:110px;">
                  <a href="{{ route('admin.kegiatan.show', $k) }}" style="display:inline-flex;align-items:center;justify-content:center;gap:4px;color:#FFC81A;font-size:12px;font-weight:800;text-decoration:none;background:#131218;padding:7px 16px;border-radius:20px;border:1px solid #131218;white-space:nowrap;transition:all .15s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Detail &rarr;</a>
                </td>
              </tr>
              @empty
              <tr><td colspan="4" style="padding:28px;text-align:center;color:#94A3B8;font-size:13px;">Belum ada kegiatan aktif.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Mobile Cards List (< 640px) --}}
        <div class="fcc-dashboard-kegiatan-mobile-list">
          @forelse($kegiatanTerbaru as $k)
          <div class="fcc-kegiatan-m-card" onclick="if(!event.target.closest('a, button')) window.location.href='{{ route('admin.kegiatan.show', $k) }}'">
            <div class="fcc-kegiatan-m-top">
              <div style="flex:1;min-width:0;">
                <h4 class="fcc-kegiatan-m-title">{{ $k->judul }}</h4>
                <span class="fcc-kegiatan-m-badge" style="background:{{ $k->jenis_kegiatan==='pelatihan'?'#FFC81A':'#131218' }};color:{{ $k->jenis_kegiatan==='pelatihan'?'#131218':'#FFC81A' }};border:1px solid #131218;">
                  {{ ucfirst($k->jenis_kegiatan) }}
                </span>
              </div>
              <a href="{{ route('admin.kegiatan.show', $k) }}" class="fcc-kegiatan-m-btn" onmouseover="this.style.background='#131218';this.style.color='#FFC81A';" onmouseout="this.style.background='#FFC81A';this.style.color='#131218';">
                Detail &rarr;
              </a>
            </div>

            <div class="fcc-kegiatan-m-meta">
              <div class="fcc-kegiatan-m-date">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="18" y2="10"/></svg>
                <span>{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? '—' }}</span>
              </div>
              <div class="fcc-kegiatan-m-progress-wrap">
                <div class="fcc-kegiatan-m-quota-lbl">
                  <span>Peserta</span>
                  <strong>{{ $k->terisi }}/{{ $k->kuota }}</strong>
                </div>
                <div class="fcc-kegiatan-m-progress-bar">
                  <div style="height:100%;border-radius:3px;background:{{ $k->isFull()?'#EF4444':'#FFC81A' }};width:{{ $k->kuota>0?min(100,round($k->terisi/$k->kuota*100)):0 }}%;"></div>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div style="padding:24px 16px;text-align:center;color:#94A3B8;font-size:12.5px;font-weight:600;">Belum ada kegiatan aktif.</div>
          @endforelse
        </div>
      </div>

    </div>

    {{-- RIGHT SIDE WIDGETS AREA (~30% on desktop >=1240px, 2-col grid on tablet/laptop, 1-col on mobile) --}}
    <div class="fcc-dashboard-sidebar-widgets">

      {{-- Mini Calendar Widget (AJAX Enabled) --}}
      <div id="mini-calendar-widget" class="fcc-card fcc-widget-card" style="transition:opacity .2s;">
        {{-- Calendar grid --}}
        @php
          $currentCalDate = $calendarDate ?? now();
          $today = now();
          $startOfMonth = $currentCalDate->copy()->startOfMonth();
          $daysInMonth = $currentCalDate->daysInMonth;
          $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)
          $kegiatanMap = $tanggalKegiatanMap ?? [];
          $isCurrentRealMonth = $currentCalDate->format('Y-m') === $today->format('Y-m');
        @endphp

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
          <button type="button" id="cal-prev-btn" onclick="loadCalendarMonth('{{ $prevMonth }}')" title="Bulan Sebelumnya" style="width:32px;height:32px;border-radius:8px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;font-weight:900;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
            &larr;
          </button>

          <div style="text-align:center;">
            <h3 id="cal-month-label" style="margin:0;font-size:15px;font-weight:900;color:#131218;">
              {{ $currentCalDate->translatedFormat('F Y') }}
            </h3>
            <button type="button" id="cal-reset-btn" onclick="loadCalendarMonth('{{ now()->format('Y-m') }}')" style="display:{{ $isCurrentRealMonth ? 'none' : 'inline-block' }};font-size:10px;font-weight:800;color:#3B82F6;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;">Ke Bulan Ini</button>
          </div>

          <button type="button" id="cal-next-btn" onclick="loadCalendarMonth('{{ $nextMonth }}')" title="Bulan Berikutnya" style="width:32px;height:32px;border-radius:8px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;font-weight:900;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
            &rarr;
          </button>
        </div>

        <div style="display:grid;grid-template-columns:repeat(7, 1fr);gap:4px;text-align:center;font-size:11px;font-weight:800;color:#94A3B8;margin-bottom:8px;">
          <span>Mg</span><span>Sn</span><span>Sl</span><span>Rb</span><span>Km</span><span>Jm</span><span>St</span>
        </div>
        <div id="cal-days-grid" style="display:grid;grid-template-columns:repeat(7, 1fr);gap:4px;text-align:center;">
          @for($i = 0; $i < $startDayOfWeek; $i++)
            <div style="padding:6px;font-size:12px;color:#CBD5E1;"></div>
          @endfor
          @for($day = 1; $day <= $daysInMonth; $day++)
            @php 
              $isToday = ($isCurrentRealMonth && $day == $today->day);
              $hasActivity = isset($kegiatanMap[$day]) && count($kegiatanMap[$day]) > 0;
              $activityTitles = $hasActivity ? implode(', ', $kegiatanMap[$day]) : '';
            @endphp
            <div class="calendar-day-cell"
                 title="{{ $hasActivity ? $activityTitles : ($isToday ? 'Hari ini' : '') }}"
                 @if($hasActivity) data-tooltip="{{ $activityTitles }}" @endif
                 style="position:relative;padding:7px 0;font-size:12px;font-weight:{{ ($isToday || $hasActivity) ? '900' : '600' }};border-radius:10px;cursor:{{ $hasActivity ? 'pointer' : 'default' }};
                        background:{{ $isToday ? '#FFC81A' : 'transparent' }};
                        color:{{ $isToday ? '#131218' : ($hasActivity ? '#131218' : '#334155') }};
                        border:{{ $isToday ? '1.5px solid #131218' : 'none' }};
                        box-shadow:{{ $isToday ? '0 4px 12px rgba(255, 200, 26, 0.35)' : 'none' }};">
              {{ $day }}
              @if($hasActivity)
                <div style="position:absolute;bottom:2px;left:50%;transform:translateX(-50%);display:flex;gap:2.5px;align-items:center;">
                  @foreach(array_slice($kegiatanMap[$day], 0, 3) as $actItem)
                    <span style="width:4px;height:4px;border-radius:50%;background:{{ $isToday ? '#131218' : '#FFC81A' }};border:{{ $isToday ? 'none' : '1px solid #131218' }};"></span>
                  @endforeach
                </div>
              @endif
            </div>
          @endfor
        </div>

        {{-- Legenda Kalender --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px;padding-top:10px;border-top:1.5px solid #F1F5F9;font-size:10.5px;font-weight:700;flex-wrap:wrap;gap:6px;">
          <span style="display:inline-flex;align-items:center;gap:5px;color:#131218;">
            <span style="width:10px;height:10px;border-radius:3px;background:#FFC81A;border:1px solid #131218;"></span> Hari Ini
          </span>
          <span style="display:inline-flex;align-items:center;gap:5px;color:#131218;">
            <span style="width:6px;height:6px;border-radius:50%;background:#FFC81A;border:1px solid #131218;"></span> Tanggal Kegiatan
          </span>
        </div>
      </div>

      {{-- Status Pendaftar Chart Widget --}}
      <div class="fcc-card fcc-widget-card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
          <h3 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Status Pendaftar</h3>
          <span style="font-size:10.5px;font-weight:800;color:#131218;background:#FFC81A;padding:3px 8px;border-radius:6px;border:1px solid #131218;">Transaksi</span>
        </div>
        <div style="position:relative;height:150px;margin-bottom:10px;">
          <canvas id="chartStatusPendaftar"></canvas>
        </div>
        <div id="status-pendaftar-legend" style="display:flex;flex-direction:column;gap:2px;margin-top:8px;"></div>
      </div>

      {{-- Menunggu Verifikasi List Widget --}}
      <div class="fcc-card fcc-table-card fcc-widget-full-on-grid">
        <div style="padding:16px 20px;border-bottom:2px solid #E5E7EB;display:flex;justify-content:space-between;align-items:center;background:#F8FAFC;">
          <h3 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Menunggu Verifikasi</h3>
          @if($pendingBayar)
          <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;">{{ $pendingBayar }}</span>
          @endif
        </div>
        @forelse($pembayaranMenunggu as $p)
        <a href="{{ route('admin.pembayaran.show', $p) }}" class="fcc-verif-item" style="display:flex;align-items:center;gap:12px;padding:14px 18px;border-top:1px solid #F8FAFC;text-decoration:none;transition:background .18s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
          <div style="width:36px;height:36px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 10px rgba(255,200,26,0.25);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div style="flex:1;min-width:0;">
            <p style="margin:0;font-size:13px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->pendaftaran->peserta->nama }}</p>
            <p style="margin:0;font-size:11px;color:#64748B;">{{ Str::limit($p->pendaftaran->kegiatan->judul, 22) }}</p>
          </div>
          <p style="margin:0;font-size:12.5px;font-weight:900;color:#131218;white-space:nowrap;">{{ $p->jumlah_bayar_format }}</p>
        </a>
        @empty
        <div style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;">Tidak ada pembayaran menunggu.</div>
        @endforelse
      </div>

    </div>

  </div>

</div>
@endsection

@push('page-data')
<script>
window.PAGE_DATA = {!! json_encode([
    'api' => [
        'base'     => url('/admin/api'),
        'stats'    => route('admin.api.chart.stats'),
        'calendar' => route('admin.api.calendar'),
    ],
]) !!};
</script>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@vite('resources/js/pages/admin-dashboard.js')
@endpush

