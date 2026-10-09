@extends('layouts.admin')
@section('title','Laporan & Statistik')
@section('page-title','Laporan & Statistik')

@push('styles')
<style>
  /* ── Base Styling & Responsive Containers ── */
  .laporan-container {
    padding: 24px 28px;
    max-width: 1600px;
    margin: 0 auto;
    font-family: 'Inter', sans-serif;
  }
  .stat-card-glow {
    transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }
  .stat-card-glow:hover {
    transform: translateY(-4px);
    border-color: #FFC81A !important;
    box-shadow: 0 14px 28px rgba(255, 200, 26, 0.2) !important;
  }
  .badge-status {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 10.5px;
    font-weight: 900;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .badge-terverifikasi { background: #ECFDF5; color: #059669; border: 1px solid #10B981; }
  .badge-menunggu { background: #FFC81A; color: #131218; border: 1px solid #131218; }
  .badge-ditolak { background: #FEF2F2; color: #DC2626; border: 1px solid #EF4444; }
  .badge-kadaluarsa { background: #F3F4F6; color: #4B5563; border: 1px solid #9CA3AF; }

  /* ── Layout Breakpoint Rules ── */
  .fcc-laporan-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 24px;
  }
  .fcc-laporan-main-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    align-items: start;
  }
  .fcc-transaksi-desktop-table {
    display: block;
  }
  .fcc-transaksi-mobile-list {
    display: none;
  }

  /* ── Ultra-Compact Toolbar Styling ── */
  .fcc-compact-toolbar {
    padding: 8px 16px;
    margin-bottom: 20px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    border-radius: 14px;
    box-shadow: 0 4px 16px rgba(19, 18, 24, 0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    position: relative;
    box-sizing: border-box;
  }
  .fcc-toolbar-filter-form {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    flex: 1;
    min-width: 0;
    margin: 0;
  }
  .fcc-toolbar-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    background: #FFC81A;
    border: 1.5px solid #131218;
    border-radius: 8px;
    font-size: 11.5px;
    font-weight: 900;
    color: #131218;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .fcc-select-slim {
    height: 36px;
    box-sizing: border-box;
    background: #F8FAFC !important;
    border: 1.5px solid #CBD5E1 !important;
    color: #131218 !important;
    border-radius: 8px !important;
    padding: 6px 28px 6px 10px !important;
    font-size: 12.5px !important;
    font-weight: 700 !important;
    cursor: pointer !important;
    outline: none !important;
    appearance: none !important;
    -webkit-appearance: none !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 9px center !important;
    transition: all 0.15s ease !important;
  }
  .fcc-select-slim:hover,
  .fcc-select-slim:focus {
    border-color: #131218 !important;
    background-color: #FFFFFF !important;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.12) !important;
  }
  .fcc-btn-reset-slim {
    height: 34px;
    padding: 0 10px;
    font-size: 11.5px;
    font-weight: 800;
    color: #DC2626;
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
    transition: all 0.15s;
  }
  .fcc-btn-reset-slim:hover {
    background: #FEE2E2;
  }
  .fcc-toolbar-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
    position: relative;
  }
  .fcc-btn-tool {
    height: 36px;
    padding: 0 14px;
    font-size: 12px;
    font-weight: 900;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    box-sizing: border-box;
    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .fcc-btn-tool-gold {
    background: #FFC81A;
    color: #131218;
    border: 1.5px solid #131218;
    box-shadow: 0 2px 8px rgba(255, 200, 26, 0.25);
  }
  .fcc-btn-tool-gold:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 200, 26, 0.35);
  }
  .fcc-btn-tool-emerald {
    background: #10B981;
    color: #FFFFFF;
    border: 1.5px solid #059669;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.22);
  }
  .fcc-btn-tool-emerald:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.32);
  }
  .fcc-excel-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(19, 18, 24, 0.4);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
    z-index: 998;
  }
  .fcc-excel-popover {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 380px;
    max-width: calc(100vw - 32px);
    background: #FFFFFF;
    border: 2px solid #131218;
    border-radius: 14px;
    padding: 16px 18px;
    box-shadow: 0 14px 40px rgba(19, 18, 24, 0.18);
    z-index: 1000;
    animation: popoverFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .fcc-excel-popover::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 32px;
    width: 14px;
    height: 14px;
    background: #FFFFFF;
    border-top: 2px solid #131218;
    border-left: 2px solid #131218;
    transform: rotate(45deg);
  }
  @keyframes popoverFadeIn {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .fcc-popover-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #F1F5F9;
  }
  .fcc-popover-close-btn {
    border: none;
    background: #F1F5F9;
    color: #64748B;
    width: 24px;
    height: 24px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
  }
  .fcc-popover-close-btn:hover {
    background: #E2E8F0;
    color: #0F172A;
  }
  .fcc-popover-label {
    font-size: 11px;
    font-weight: 800;
    color: #475569;
    display: block;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
  }

  /* ── Breakpoints ── */
  @media (max-width: 1199px) {
    .fcc-laporan-kpi-grid {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 14px !important;
    }
  }

  @media (max-width: 1023px) {
    .laporan-container {
      padding: 20px 16px !important;
    }
    .fcc-compact-toolbar {
      flex-wrap: wrap !important;
      padding: 10px 14px !important;
      gap: 10px !important;
    }
    .fcc-toolbar-filter-form {
      flex: 1 1 100% !important;
      justify-content: flex-start !important;
    }
    .fcc-toolbar-actions {
      flex: 1 1 100% !important;
      justify-content: flex-end !important;
      border-top: 1px dashed #E2E8F0;
      padding-top: 8px;
    }
    .fcc-laporan-main-grid {
      grid-template-columns: 1fr !important;
      gap: 20px !important;
    }
  }

  @media (max-width: 767px) {
    .fcc-transaksi-desktop-table {
      display: none !important;
    }
    .fcc-transaksi-mobile-list {
      display: flex !important;
      flex-direction: column !important;
      gap: 10px !important;
      padding: 12px !important;
    }
    .fcc-compact-toolbar {
      flex-direction: column !important;
      align-items: stretch !important;
      padding: 12px 14px !important;
      gap: 10px !important;
    }
    .fcc-toolbar-filter-form {
      flex-direction: column !important;
      align-items: stretch !important;
      width: 100% !important;
      gap: 8px !important;
    }
    .fcc-toolbar-tag {
      width: fit-content !important;
    }
    .fcc-select-slim {
      width: 100% !important;
      min-height: 40px !important;
    }
    .fcc-toolbar-actions {
      display: flex !important;
      width: 100% !important;
      gap: 8px !important;
      border-top: 1px dashed #E2E8F0;
      padding-top: 10px;
    }
    .fcc-btn-tool {
      flex: 1 !important;
      justify-content: center !important;
      min-height: 40px !important;
    }
    .fcc-excel-popover,
    .fcc-csv-popover {
      position: fixed !important;
      top: 50% !important;
      left: 50% !important;
      right: auto !important;
      transform: translate(-50%, -50%) !important;
      width: calc(100vw - 32px) !important;
      max-width: 380px !important;
      box-shadow: 0 24px 60px rgba(19, 18, 24, 0.35) !important;
      z-index: 1000 !important;
    }
    .fcc-excel-popover::before,
    .fcc-csv-popover::before {
      display: none !important;
    }
  }

  @media (max-width: 639px) {
    .laporan-container {
      padding: 14px 12px !important;
    }
    .fcc-laporan-kpi-grid {
      grid-template-columns: 1fr !important;
      gap: 12px !important;
    }
    .fcc-chart-header-row {
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: 10px !important;
    }
    .fcc-chart-legend-wrap {
      width: 100% !important;
      justify-content: space-between !important;
    }
    .fcc-chart-main-card {
      padding: 16px 14px !important;
    }
  }

  @media (max-width: 419px) {
    .laporan-container {
      padding: 12px 10px !important;
    }
    .fcc-transaksi-mobile-list {
      padding: 8px !important;
      gap: 8px !important;
    }
    .fcc-transaksi-card-item {
      padding: 12px 10px !important;
    }
  }

  /* ── Print Media Query ── */
  @media print {
    body { background: #fff !important; color: #000 !important; }
    .no-print, header, sidebar, .fcc-sidebar, .fcc-header, #filter-bar, .fcc-compact-toolbar, .fcc-excel-popover, .fcc-csv-popover { display: none !important; }
    .laporan-container { padding: 0 !important; width: 100% !important; max-width: 100% !important; }
    .fcc-card { border: 1px solid #ddd !important; box-shadow: none !important; margin-bottom: 20px !important; page-break-inside: avoid; }
    .print-header { display: block !important; margin-bottom: 24px; border-bottom: 2px solid #131218; padding-bottom: 12px; }
    .grid-print-2 { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 16px !important; }
    .fcc-laporan-kpi-grid { display: grid !important; grid-template-columns: repeat(4, 1fr) !important; gap: 12px !important; }
    .fcc-laporan-main-grid { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 16px !important; }
  }
  .print-header { display: none; }
</style>
@endpush

@section('page-content')
<div class="laporan-container" style="position:relative;">

  {{-- ═══ LAPORAN SKELETON LOADING OVERLAY ═════════════════════════ --}}
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
    #laporan-skeleton-overlay {
      transition: opacity 0.35s ease, visibility 0.35s ease;
    }
  </style>

  <div id="laporan-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:inherit;box-sizing:border-box;pointer-events:none;">
    {{-- Ultra-Compact Toolbar Skeleton --}}
    <div style="padding:10px 18px;margin-bottom:20px;border-radius:14px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;justify-content:space-between;gap:12px;height:54px;box-sizing:border-box;">
      <div style="display:flex;align-items:center;gap:10px;flex:1;">
        <div class="fcc-skeleton-box" style="width:70px;height:32px;border-radius:8px;"></div>
        <div class="fcc-skeleton-box" style="width:110px;height:34px;border-radius:8px;"></div>
        <div class="fcc-skeleton-box" style="width:130px;height:34px;border-radius:8px;"></div>
        <div class="fcc-skeleton-box" style="width:140px;height:34px;border-radius:8px;"></div>
      </div>
      <div style="display:flex;align-items:center;gap:8px;">
        <div class="fcc-skeleton-box" style="width:155px;height:34px;border-radius:8px;"></div>
      </div>
    </div>

    {{-- 4 Stat Cards Skeleton --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
      @for($s=0;$s<4;$s++)
      <div style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
          <div class="fcc-skeleton-box" style="width:60%;height:12px;"></div>
          <div class="fcc-skeleton-box" style="width:48px;height:48px;border-radius:14px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:80%;height:26px;margin-bottom:6px;"></div>
        <div class="fcc-skeleton-box" style="width:40%;height:10px;"></div>
      </div>
      @endfor
    </div>

    {{-- Main Structured Skeleton --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:24px;align-items:start;">
      <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:220px;border-radius:14px;"></div>
      </div>
      <div style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:220px;border-radius:14px;"></div>
      </div>
    </div>
  </div>

  <script>
    (function() {
      setTimeout(function() {
        var sk = document.getElementById('laporan-skeleton-overlay');
        if (sk) {
          sk.style.opacity = '0';
          sk.style.visibility = 'hidden';
          setTimeout(function() { sk.style.display = 'none'; }, 350);
        }
      }, 450);
    })();
  </script>

  {{-- Print Only Header --}}
  <div class="print-header">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:6px;">
      <h2 style="font-size:22px;font-weight:900;margin:0;color:#131218;">FIKOM CERTIFICATION CENTER (FCC)</h2>
    </div>
    <p style="margin:0;font-size:14px;color:#475569;font-weight:600;">Laporan Finansial &amp; Statistik Program — Periode {{ $bulan ? 'Bulan ' . $bulan . ' ' : '' }}Tahun {{ $tahun }}</p>
  </div>

  {{-- ═══ ULTRA-COMPACT SLIM TOOLBAR ═══════════════════════════ --}}
  <div id="filter-bar" class="fcc-card fcc-compact-toolbar no-print">
    {{-- Left: Filter Form (Tahun, Bulan, Jenis, Reset) --}}
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="fcc-toolbar-filter-form">
      <div class="fcc-toolbar-tag">
        @include('components.icon',['name'=>'filter','size'=>14,'style'=>'color:#131218;'])
        <span>Filter:</span>
      </div>

      {{-- Tahun --}}
      <select name="tahun" onchange="this.form.submit()" class="fcc-select-slim" title="Filter Tahun">
        @foreach($availableYears as $y)
          <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
        @endforeach
      </select>

      {{-- Bulan --}}
      <select name="bulan" onchange="this.form.submit()" class="fcc-select-slim" title="Filter Bulan">
        <option value="">Semua Bulan</option>
        @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $v=>$l)
          <option value="{{ $v }}" {{ $bulan == $v ? 'selected' : '' }}>{{ $l }}</option>
        @endforeach
      </select>

      {{-- Jenis Kegiatan --}}
      <select name="jenis_kegiatan" onchange="this.form.submit()" class="fcc-select-slim" title="Filter Jenis Kegiatan">
        <option value="">Semua Jenis</option>
        <option value="pelatihan" {{ $jenisKegiatan == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
        <option value="sertifikasi" {{ $jenisKegiatan == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
      </select>

      @if($bulan || $jenisKegiatan || $tahun != date('Y'))
        <a href="{{ route('admin.laporan.index') }}" class="fcc-btn-reset-slim" title="Reset filter ke default">
          ✕ Reset
        </a>
      @endif
    </form>

    {{-- Right: Export Action Buttons --}}
    <div class="fcc-toolbar-actions">
      {{-- Single Unified Export Excel (.xlsx) Trigger --}}
      <button type="button"
              id="fcc-excel-trigger"
              onclick="toggleExcelPopover()"
              class="fcc-btn-tool fcc-btn-tool-emerald"
              title="Pilih tipe laporan & unduh berkas Excel (.xlsx)">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        <span>Export Excel (.xlsx)</span>
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
      </button>

      {{-- Unified Popover Dropdown for Excel Export (4 Tipe Laporan) --}}
      <div id="fcc-excel-popover" class="fcc-excel-popover" style="display:none;">
        <div class="fcc-popover-head">
          <div style="display:flex;align-items:center;gap:8px;">
            <div style="width:26px;height:26px;border-radius:6px;background:#ECFDF5;border:1px solid #10B981;display:flex;align-items:center;justify-content:center;">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
            </div>
            <div>
              <h4 style="margin:0;font-size:13px;font-weight:900;color:#131218;">Export Laporan Excel</h4>
              <p style="margin:0;font-size:11px;color:#64748B;">Pilih tipe laporan &amp; filter kriteria data</p>
            </div>
          </div>
          <button type="button" onclick="toggleExcelPopover(false)" class="fcc-popover-close-btn" title="Tutup">✕</button>
        </div>

        <form action="{{ route('admin.laporan.export-csv') }}" method="GET" style="display:flex;flex-direction:column;gap:10px;margin:0;">
          {{-- 1. Pilihan 4 Tipe Laporan --}}
          <div>
            <label class="fcc-popover-label">1. Tipe Laporan</label>
            <select name="tipe_laporan" id="select-tipe-laporan" onchange="onTipeLaporanChange(this.value)" class="fcc-select-slim" style="width:100% !important;">
              <option value="per_kegiatan" selected>1. Rincian Pembayaran Per Kegiatan / Batch</option>
              <option value="keuangan">2. Buku Kas / Mutasi Transaksi Global</option>
              <option value="rekap_program">3. Rekapitulasi Kinerja per Program</option>
              <option value="peserta_kelulusan">4. Data Peserta &amp; Kelulusan Sertifikat</option>
            </select>
            <div id="excel-tipe-hint" style="font-size:11px;color:#475569;line-height:1.45;margin-top:6px;padding:7px 10px;background:#F8FAFC;border-radius:8px;border:1px solid #E2E8F0;">
              <strong style="color:#0F172A;display:block;margin-bottom:2px;">Rincian Pembayaran Per Kegiatan:</strong>
              Rekap lengkap peserta &amp; verifikasi bukti bayar multi-sheet per jadwal/batch kegiatan.
            </div>
          </div>

          {{-- GROUP B: Filter Program & Batch (untuk Tipe 1 - Per Kegiatan, Default) --}}
          <div id="group-filter-kegiatan" style="display:flex;flex-direction:column;gap:10px;">
            <div>
              <label class="fcc-popover-label">2. Program Kegiatan</label>
              <select id="select-program" name="program_key" required onchange="onProgramChange(this.value)" class="fcc-select-slim" style="width:100% !important;">
                <option value="">-- Pilih Program Kegiatan --</option>
                @foreach($programGroupList as $key => $group)
                  <option value="{{ $key }}">{{ $group['program_name'] }} ({{ $group['jenis'] }})</option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="fcc-popover-label">3. Jadwal Pelaksanaan</label>
              <select id="select-jadwal" name="kegiatan_id" disabled class="fcc-select-slim" style="width:100% !important;">
                <option value="all">-- Semua Jadwal (Multi-Sheet) --</option>
              </select>
            </div>
          </div>

          {{-- GROUP A: Filter Periodik (untuk Tipe 2, 3, 4) --}}
          <div id="group-filter-periodik" style="display:none;flex-direction:column;gap:10px;">
            {{-- 2. Periode Laporan --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
              <div>
                <label class="fcc-popover-label">2. Tahun</label>
                <select name="tahun" class="fcc-select-slim" style="width:100% !important;">
                  @foreach($availableYears as $y)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="fcc-popover-label">Bulan</label>
                <select name="bulan" class="fcc-select-slim" style="width:100% !important;">
                  <option value="">Semua Bulan</option>
                  @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $v=>$l)
                    <option value="{{ $v }}" {{ $bulan == $v ? 'selected' : '' }}>{{ $l }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- 3. Filter Jenis Kegiatan --}}
            <div>
              <label class="fcc-popover-label">3. Jenis Kegiatan</label>
              <select name="jenis_kegiatan" class="fcc-select-slim" style="width:100% !important;">
                <option value="">Semua Jenis (Pelatihan &amp; Sertifikasi)</option>
                <option value="pelatihan" {{ $jenisKegiatan == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                <option value="sertifikasi" {{ $jenisKegiatan == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
              </select>
            </div>

            {{-- 4. Dynamic Filter: Status Pembayaran --}}
            <div id="group-status-bayar">
              <label class="fcc-popover-label">4. Status Pembayaran</label>
              <select name="status_pembayaran" class="fcc-select-slim" style="width:100% !important;">
                <option value="terverifikasi" selected>Khusus Terverifikasi (Lunas)</option>
                <option value="semua">Semua Status Pembayaran</option>
                <option value="pending">Pending / Belum Bayar</option>
                <option value="ditolak">Ditolak</option>
              </select>
            </div>

            {{-- 5. Dynamic Filter: Status Sertifikat --}}
            <div id="group-status-sertifikat" style="display:none;">
              <label class="fcc-popover-label">5. Status Sertifikat</label>
              <select name="status_sertifikat" class="fcc-select-slim" style="width:100% !important;">
                <option value="semua" selected>Semua (Terbit &amp; Belum)</option>
                <option value="terbit">Hanya yang Sudah Terbit</option>
                <option value="belum">Belum Terbit Sertifikat</option>
              </select>
            </div>
          </div>

          <button type="submit" class="fcc-btn-tool fcc-btn-tool-emerald" style="width:100%;height:38px;justify-content:center;margin-top:4px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            <span>Unduh File Excel (.xlsx)</span>
          </button>
        </form>
      </div>

    </div>
  </div>

  {{-- Backdrop for Popover Modals --}}
  <div id="fcc-excel-backdrop" class="fcc-excel-backdrop" onclick="closeAllPopovers()"></div>

  <script>
    const programGroupData = @json($programGroupList);

    function onProgramChange(selectedKey) {
      const selectJadwal = document.getElementById('select-jadwal');
      if (!selectJadwal) return;
      selectJadwal.innerHTML = '<option value="all">-- Semua Jadwal (Multi-Sheet) --</option>';

      if (!selectedKey || !programGroupData[selectedKey]) {
        selectJadwal.disabled = true;
        return;
      }

      const group = programGroupData[selectedKey];
      if (group.jadwal_list && group.jadwal_list.length > 0) {
        group.jadwal_list.forEach(j => {
          const opt = document.createElement('option');
          opt.value = j.id;
          if (j.nama_jadwal && j.nama_jadwal.trim() !== '') {
            opt.textContent = `${j.nama_jadwal} (${j.tgl_pelaksanaan})`;
          } else {
            opt.textContent = `Pelaksanaan: ${j.tgl_pelaksanaan}`;
          }
          selectJadwal.appendChild(opt);
        });
        selectJadwal.disabled = false;
      } else {
        selectJadwal.disabled = false;
      }
    }

    function onTipeLaporanChange(val) {
      const groupPeriodik = document.getElementById('group-filter-periodik');
      const groupKegiatan = document.getElementById('group-filter-kegiatan');
      const groupBayar = document.getElementById('group-status-bayar');
      const groupSertifikat = document.getElementById('group-status-sertifikat');
      const selectProgram = document.getElementById('select-program');
      const hint = document.getElementById('excel-tipe-hint');

      if (val === 'per_kegiatan') {
        if (groupPeriodik) groupPeriodik.style.display = 'none';
        if (groupKegiatan) groupKegiatan.style.display = 'flex';
        if (selectProgram) selectProgram.required = true;
        if (hint) {
          hint.innerHTML = '<strong style="color:#0F172A;display:block;margin-bottom:2px;">Rincian Pembayaran Per Kegiatan:</strong>Rekap lengkap peserta &amp; verifikasi bukti bayar multi-sheet per jadwal/batch kegiatan.';
        }
      } else {
        if (groupPeriodik) groupPeriodik.style.display = 'flex';
        if (groupKegiatan) groupKegiatan.style.display = 'none';
        if (selectProgram) selectProgram.required = false;

        if (val === 'keuangan') {
          if (groupBayar) groupBayar.style.display = 'block';
          if (groupSertifikat) groupSertifikat.style.display = 'none';
          if (hint) {
            hint.innerHTML = '<strong style="color:#0F172A;display:block;margin-bottom:2px;">Buku Kas Transaksi Global:</strong>Rekap seluruh mutasi arus kas masuk FCC secara periodik (buku besar).';
          }
        } else if (val === 'rekap_program') {
          if (groupBayar) groupBayar.style.display = 'none';
          if (groupSertifikat) groupSertifikat.style.display = 'none';
          if (hint) {
            hint.innerHTML = '<strong style="color:#0F172A;display:block;margin-bottom:2px;">Kinerja &amp; Partisipasi Program:</strong>Ringkasan eksekutif 1 baris per program (jumlah batch, total pendaftar, rasio kelulusan %, dan pendapatan).';
          }
        } else if (val === 'peserta_kelulusan') {
          if (groupBayar) groupBayar.style.display = 'block';
          if (groupSertifikat) groupSertifikat.style.display = 'block';
          if (hint) {
            hint.innerHTML = '<strong style="color:#0F172A;display:block;margin-bottom:2px;">Data Peserta &amp; Kelulusan:</strong>Daftar operasional nama peserta, nomor registrasi sertifikat resmi, dan tautan verifikasi keabsahan.';
          }
        }
      }
    }

    function toggleExcelPopover(forceState) {
      const popover = document.getElementById('fcc-excel-popover');
      const backdrop = document.getElementById('fcc-excel-backdrop');
      if (!popover) return;
      const isVisible = popover.style.display === 'block';
      const nextState = forceState !== undefined ? forceState : !isVisible;

      popover.style.display = nextState ? 'block' : 'none';
      if (backdrop) {
        backdrop.style.display = nextState ? 'block' : 'none';
      }
    }

    function closeAllPopovers() {
      toggleExcelPopover(false);
    }

    document.addEventListener('click', function(e) {
      const excelPopover = document.getElementById('fcc-excel-popover');
      const excelTrigger = document.getElementById('fcc-excel-trigger');

      if (excelPopover && excelPopover.style.display === 'block') {
        if (!excelPopover.contains(e.target) && !excelTrigger?.contains(e.target)) {
          toggleExcelPopover(false);
        }
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeAllPopovers();
      }
    });
  </script>

  {{-- 4 Main KPI Stat Cards Grid --}}
  <div class="fcc-laporan-kpi-grid">
    
    {{-- Card 1: Total Pendapatan --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.8px;">Total Pendapatan</p>
        <div style="width:46px;height:46px;border-radius:14px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 14px rgba(255,200,26,0.3);">
          @include('components.icon',['name'=>'credit-card','size'=>22,'style'=>'color:#131218'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:22px;font-weight:900;color:#131218;letter-spacing:-.5px;word-break:break-word;">
        Rp {{ number_format($summary['total_pendapatan'],0,',','.') }}
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        Rata-rata: Rp {{ number_format($summary['avg_transaksi'],0,',','.') }}/tx
      </p>
    </div>

    {{-- Card 2: Total Pendaftaran --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.8px;">Pendaftaran Masuk</p>
        <div style="width:46px;height:46px;border-radius:14px;background:#131218;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 14px rgba(19,18,24,0.25);">
          @include('components.icon',['name'=>'clipboard-list','size'=>22,'style'=>'color:#FFC81A'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:22px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        {{ number_format($summary['total_pendaftaran']) }} <span style="font-size:13px;font-weight:700;color:#6B7280;">Siswa/i</span>
      </h3>
      <p style="margin:0;font-size:11px;color:#10B981;font-weight:700;">
        Rate Sukses: {{ $summary['rate_verifikasi'] }}%
      </p>
    </div>

    {{-- Card 3: Sertifikat Diterbitkan --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.8px;">Sertifikat Terbit</p>
        <div style="width:46px;height:46px;border-radius:14px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 14px rgba(255,200,26,0.2);">
          @include('components.icon',['name'=>'award','size'=>22,'style'=>'color:#B38F00'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:22px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        {{ number_format($summary['total_sertifikat']) }} <span style="font-size:13px;font-weight:700;color:#6B7280;">Berkas</span>
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        Rasio Terbit: {{ $summary['rate_sertifikat'] }}%
      </p>
    </div>

    {{-- Card 4: Keterisian Kuota --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.8px;">Keterisian Kuota</p>
        <div style="width:46px;height:46px;border-radius:14px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          @include('components.icon',['name'=>'users','size'=>22,'style'=>'color:#6366F1'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:22px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        {{ $summary['rate_kuota'] }}% <span style="font-size:13px;font-weight:700;color:#6B7280;">Terisi</span>
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        {{ number_format($summary['total_terisi']) }} / {{ number_format($summary['total_kuota']) }} Peserta
      </p>
    </div>

  </div>

  {{-- 2-Column Structured Layout (Left Main ~70% + Right Side ~30%) --}}
  <div class="fcc-laporan-main-grid">

    {{-- LEFT MAIN AREA (~70%) --}}
    <div style="display:flex;flex-direction:column;gap:24px;min-width:0;">

      {{-- Chart 1: Tren Pendapatan & Pendaftaran Bulanan --}}
      <div class="fcc-card fcc-chart-main-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);min-width:0;">
        <div class="fcc-chart-header-row" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
          <div>
            <h4 style="margin:0;font-size:16px;font-weight:900;color:#131218;">{{ $chartTitle }}</h4>
            <p style="margin:2px 0 0;font-size:12px;color:#6B7280;">Perbandingan pendapatan (Rp) dan pendaftaran {{ $bulan ? 'harian pada bulan terpilih' : 'bulanan pada tahun ' . $tahun }}</p>
          </div>
          <div class="fcc-chart-legend-wrap" style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:12px;font-size:12px;font-weight:700;">
              <span style="display:inline-flex;align-items:center;gap:6px;color:#131218;">
                <span style="width:12px;height:12px;border-radius:3px;background:#FFC81A;border:1px solid #131218;"></span> Pendapatan
              </span>
              <span style="display:inline-flex;align-items:center;gap:6px;color:#3B82F6;">
                <span style="width:12px;height:12px;border-radius:3px;background:#3B82F6;"></span> Pendaftaran
              </span>
            </div>
            <select id="laporan-chart-metric" class="fcc-input" style="width:auto;font-size:12px;font-weight:800;padding:6px 14px;border-radius:10px;border:1.5px solid #E5E7EB;background:#F8FAFC;cursor:pointer;outline:none;">
              <option value="semua" selected>Semua</option>
              <option value="pendapatan">Pendapatan</option>
              <option value="pendaftaran">Pendaftaran</option>
            </select>
          </div>
        </div>

        <div style="position:relative;height:260px;width:100%;">
          <canvas id="chartLaporanBulanan"></canvas>
        </div>
      </div>

      {{-- Tabel Ringkasan Transaksi Terbaru --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="padding:16px 20px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
          <div>
            <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Rincian Transaksi Pendaftaran Terbaru</h4>
            <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">10 Transaksi terakhir sesuai filter periode</p>
          </div>
          <span style="font-size:11px;font-weight:800;color:#131218;background:#FFC81A;padding:3px 10px;border-radius:14px;border:1px solid #131218;">
            Terbaru
          </span>
        </div>

        {{-- Desktop Table View (>= 768px) --}}
        <div class="fcc-transaksi-desktop-table" style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
          <table style="width:100%;border-collapse:collapse;text-align:left;">
            <thead>
              <tr style="background:#F8FAFC;border-bottom:1.5px solid #E5E7EB;">
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Peserta &amp; Instansi</th>
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Nominal</th>
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Status</th>
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transaksiTerbaru as $t)
                @php
                  $statusBayar = $t->pembayaran->status_pembayaran ?? 'belum_bayar';
                  $badgeClass = match($statusBayar) {
                    'terverifikasi' => 'badge-terverifikasi',
                    'menunggu_verifikasi', 'menunggu_pembayaran' => 'badge-menunggu',
                    'ditolak' => 'badge-ditolak',
                    default => 'badge-kadaluarsa'
                  };
                @endphp
                <tr style="border-bottom:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                  <td style="padding:12px 16px;">
                    <p style="margin:0;font-size:13px;font-weight:900;color:#131218;">{{ $t->peserta->nama ?? '-' }}</p>
                    <p style="margin:0;font-size:11px;color:#6B7280;">{{ $t->peserta->instansi ?? 'Umum' }}</p>
                  </td>
                  <td style="padding:12px 16px;">
                    <p style="margin:0;font-size:12.5px;font-weight:800;color:#131218;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                      {{ $t->kegiatan->judul ?? '-' }}
                    </p>
                    <span style="font-size:10px;font-weight:800;color:#6B7280;text-transform:uppercase;">{{ ucfirst($t->kegiatan->jenis_kegiatan ?? '') }}</span>
                  </td>
                  <td style="padding:12px 16px;font-size:13px;font-weight:900;color:#131218;white-space:nowrap;">
                    Rp {{ number_format($t->pembayaran->jumlah_bayar ?? $t->biaya->nominal ?? 0, 0, ',', '.') }}
                  </td>
                  <td style="padding:12px 16px;white-space:nowrap;">
                    <span class="badge-status {{ $badgeClass }}">
                      {{ ucfirst(str_replace('_', ' ', $statusBayar)) }}
                    </span>
                  </td>
                  <td style="padding:12px 16px;font-size:11.5px;color:#6B7280;font-weight:600;white-space:nowrap;">
                    {{ $t->tgl_daftar?->format('d/m/Y H:i') ?? '-' }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" style="padding:28px 16px;text-align:center;color:#9CA3B0;font-size:13px;">
                    Tidak ada transaksi pendaftaran ditemukan.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Mobile Cards List View (< 768px) --}}
        <div class="fcc-transaksi-mobile-list">
          @forelse($transaksiTerbaru as $t)
            @php
              $statusBayar = $t->pembayaran->status_pembayaran ?? 'belum_bayar';
              $badgeClass = match($statusBayar) {
                'terverifikasi' => 'badge-terverifikasi',
                'menunggu_verifikasi', 'menunggu_pembayaran' => 'badge-menunggu',
                'ditolak' => 'badge-ditolak',
                default => 'badge-kadaluarsa'
              };
            @endphp
            <div class="fcc-transaksi-card-item" style="background:#FFFFFF;border:1.5px solid #E2E8F0;border-radius:14px;padding:14px;display:flex;flex-direction:column;gap:10px;">
              <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                <div style="min-width:0;flex:1;">
                  <h5 style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;word-break:break-word;">{{ $t->peserta->nama ?? '-' }}</h5>
                  <p style="margin:0;font-size:11px;color:#64748B;font-weight:500;">{{ $t->peserta->instansi ?? 'Umum' }}</p>
                </div>
                <span class="badge-status {{ $badgeClass }}" style="flex-shrink:0;">
                  {{ ucfirst(str_replace('_', ' ', $statusBayar)) }}
                </span>
              </div>

              <div style="padding:8px 10px;background:#F8FAFC;border-radius:8px;border:1px solid #E2E8F0;">
                <p style="margin:0 0 2px;font-size:12px;font-weight:800;color:#131218;line-height:1.3;word-break:break-word;">{{ $t->kegiatan->judul ?? '-' }}</p>
                <span style="font-size:10px;font-weight:800;color:#6B7280;text-transform:uppercase;">{{ ucfirst($t->kegiatan->jenis_kegiatan ?? '') }}</span>
              </div>

              <div style="display:flex;justify-content:space-between;align-items:center;padding-top:4px;border-top:1px dashed #E2E8F0;font-size:11.5px;">
                <span style="color:#64748B;font-weight:600;">📅 {{ $t->tgl_daftar?->format('d/m/Y H:i') ?? '-' }}</span>
                <span style="font-size:13px;font-weight:900;color:#131218;">
                  Rp {{ number_format($t->pembayaran->jumlah_bayar ?? $t->biaya->nominal ?? 0, 0, ',', '.') }}
                </span>
              </div>
            </div>
          @empty
            <div style="padding:24px 12px;text-align:center;color:#9CA3B0;font-size:13px;">
              Tidak ada transaksi pendaftaran ditemukan.
            </div>
          @endforelse
        </div>
      </div>

    </div>

    {{-- RIGHT SIDE AREA (~30%) --}}
    <div style="display:flex;flex-direction:column;gap:24px;min-width:0;">

      {{-- Demografi & Asal Instansi Peserta Widget --}}
      <div class="fcc-card" style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
          <div>
            <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Demografi Peserta</h4>
            <p style="margin:2px 0 0;font-size:11px;color:#94A3B8;font-weight:600;">Berdasarkan instansi terbanyak</p>
          </div>
          <span style="font-size:10.5px;font-weight:800;color:#131218;background:#FFC81A;padding:3px 8px;border-radius:6px;border:1px solid #131218;">Top Instansi</span>
        </div>

        <div style="display:flex;flex-direction:column;gap:10px;">
          @php
            $colors = ['#FFC81A', '#131218', '#3B82F6', '#10B981', '#8B5CF6', '#94A3B8'];
            $totalDemo = max(1, collect($summary['demografi'] ?? [])->sum('total'));
          @endphp
          @forelse($summary['demografi'] ?? [] as $idx => $demo)
          @php
            $cnt = $demo['total'] ?? 0;
            $lbl = $demo['label'] ?? '-';
            $bgColor = $colors[$idx % count($colors)];
            $pct = round(($cnt / $totalDemo) * 100);
          @endphp
          <div style="background:#F8FAFC;padding:9px 12px;border-radius:10px;border:1px solid #F1F5F9;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;font-size:12px;">
              <span style="font-weight:700;color:#131218;max-width:68%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $lbl }}">{{ $lbl }}</span>
              <span style="font-weight:900;color:#131218;">{{ $cnt }} <span style="font-size:10.5px;color:#64748B;font-weight:600;">({{ $pct }}%)</span></span>
            </div>
            <div style="height:5px;background:#E5E7EB;border-radius:3px;overflow:hidden;">
              <div style="height:100%;background:{{ $bgColor }};width:{{ $pct }}%;"></div>
            </div>
          </div>
          @empty
          <div style="text-align:center;padding:20px 10px;color:#94A3B8;font-size:12px;font-weight:600;">
            Belum ada data pendaftaran pada periode ini.
          </div>
          @endforelse
        </div>
      </div>

      {{-- Doughnut Status Pembayaran Widget --}}
      <div class="fcc-card" style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <h4 style="margin:0 0 14px;font-size:15px;font-weight:900;color:#131218;">Status Pembayaran</h4>
        <div style="position:relative;height:160px;">
          <canvas id="chartStatusPembayaran"></canvas>
        </div>
      </div>

      {{-- Doughnut Jenis Kegiatan Widget --}}
      <div class="fcc-card" style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <h4 style="margin:0 0 14px;font-size:15px;font-weight:900;color:#131218;">Proporsi Kegiatan</h4>
        <div style="position:relative;height:160px;">
          <canvas id="chartJenisKegiatan"></canvas>
        </div>
      </div>

      {{-- Top Kegiatan Terfavorit Widget --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="padding:16px 20px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;">
          <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;">10 Kegiatan Terfavorit</h4>
          <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">Berdasarkan total peminat pendaftar</p>
        </div>
        <div style="max-height:380px;overflow-y:auto;-webkit-overflow-scrolling:touch;">
          @forelse($perKegiatan as $i => $k)
            @php
              $maxCount = max(1, $perKegiatan->first()?->pendaftaran_count ?? 1);
              $percentage = round(($k->pendaftaran_count / $maxCount) * 100);
            @endphp
            <div style="padding:11px 16px;border-bottom:1px solid #F1F5F9;display:flex;align-items:center;gap:10px;">
              <div style="width:26px;height:26px;border-radius:8px;flex-shrink:0;
                background:{{ $i===0?'#FFC81A':($i===1?'#131218':($i===2?'#475569':'#F1F5F9')) }};
                border:{{ $i===0?'1px solid #131218':'none' }};
                display:flex;align-items:center;justify-content:center;
                font-size:11px;font-weight:900;color:{{ $i===0?'#131218':($i<3?'#FFF':'#6B7280') }};">
                {{ $i + 1 }}
              </div>
              <div style="flex:1;min-width:0;">
                <p style="margin:0;font-size:12px;font-weight:800;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  {{ $k->judul }}
                </p>
                <div style="display:flex;align-items:center;gap:6px;margin-top:3px;">
                  <span style="font-size:9px;font-weight:900;color:{{ $k->jenis_kegiatan === 'pelatihan' ? '#131218' : '#64748B' }};text-transform:uppercase;">
                    {{ $k->jenis_kegiatan }}
                  </span>
                  <div style="flex:1;height:4px;background:#E5E7EB;border-radius:2px;overflow:hidden;">
                    <div style="height:100%;background:{{ $i===0?'#FFC81A':'#131218' }};width:{{ $percentage }}%;"></div>
                  </div>
                </div>
              </div>
              <div style="text-align:right;flex-shrink:0;">
                <span style="font-size:13px;font-weight:900;color:#131218;">{{ $k->pendaftaran_count }}</span>
                <span style="display:block;font-size:9.5px;color:#9CA3B0;font-weight:600;">pendaftar</span>
              </div>
            </div>
          @empty
            <div style="padding:24px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada data kegiatan.</div>
          @endforelse
        </div>
      </div>

    </div>

  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
  let chartBulananInstance, chartStatusInstance, chartJenisInstance;

  function initLaporanCharts() {
    if (typeof Chart === 'undefined') {
      setTimeout(initLaporanCharts, 100);
      return;
    }

    // Data dari Server (Dynamic Harian / Bulanan)
    const bulanLabels = {!! json_encode($chartLabels) !!};
    const dataPendapatan = {!! json_encode($pendapatanChartData) !!};
    const dataPendaftaran = {!! json_encode($pendaftaranChartData) !!};
    const statusCounts = {!! json_encode($statusPembayaranCounts) !!};
    const jenisCounts = {!! json_encode($jenisCounts) !!};

    const isMobile = window.innerWidth < 640;

    // 1. Chart Main Laporan (Pendapatan & Pendaftaran)
    function renderMainChart() {
      const ctxBulanan = document.getElementById('chartLaporanBulanan');
      if (!ctxBulanan) return;

      const metric = document.getElementById('laporan-chart-metric')?.value || 'semua';
      if (chartBulananInstance) chartBulananInstance.destroy();

      const datasets = [];
      const isMobileView = window.matchMedia('(max-width: 639px)').matches;
      const scales = {
        x: { 
          grid: { display: false }, 
          ticks: { 
            font: { size: isMobileView ? 10 : 12 },
            autoSkip: true,
            maxTicksLimit: isMobileView ? 8 : 31
          } 
        }
      };

      if (metric === 'semua' || metric === 'pendapatan') {
        datasets.push({
          label: 'Pendapatan (Rp)',
          data: dataPendapatan,
          type: 'line',
          borderColor: '#FFC81A',
          backgroundColor: 'rgba(255, 200, 26, 0.18)',
          borderWidth: 3,
          pointBackgroundColor: '#FFC81A',
          pointBorderColor: '#131218',
          pointBorderWidth: 2,
          pointRadius: isMobileView ? 3 : 5,
          tension: 0.35,
          fill: true,
          yAxisID: metric === 'semua' ? 'yPendapatan' : 'y',
          order: 1
        });

        scales[metric === 'semua' ? 'yPendapatan' : 'y'] = {
          type: 'linear',
          position: 'left',
          grid: { color: '#F0F1F5' },
          ticks: {
            font: { size: isMobileView ? 10 : 11, weight: '700' },
            callback: function(val) {
              const isMob = window.matchMedia('(max-width: 639px)').matches;
              if (val === 0) return isMob ? '0' : 'Rp 0';

              if (isMob) {
                // Tampilan mobile ringkas (contoh: 25jt, 500rb) agar grafik tetap proporsional & lebar
                if (val >= 1e9) {
                  const b = val / 1e9;
                  return (b % 1 === 0 ? b.toFixed(0) : b.toFixed(1)) + 'M';
                }
                if (val >= 1e6) {
                  const m = val / 1e6;
                  return (m % 1 === 0 ? m.toFixed(0) : m.toFixed(1)) + 'jt';
                }
                if (val >= 1e3) {
                  const k = val / 1e3;
                  return (k % 1 === 0 ? k.toFixed(0) : k.toFixed(1)) + 'rb';
                }
                return val;
              }

              // Tampilan desktop format standar Indonesia (Rp 25jt, Rp 500rb, atau Rp 1M jika milyar)
              if (val >= 1e9) {
                const b = val / 1e9;
                return 'Rp ' + (b % 1 === 0 ? b.toFixed(0) : b.toFixed(1)) + 'M';
              }
              if (val >= 1e6) {
                const m = val / 1e6;
                return 'Rp ' + (m % 1 === 0 ? m.toFixed(0) : m.toFixed(1)) + 'jt';
              }
              if (val >= 1e3) {
                const k = val / 1e3;
                return 'Rp ' + (k % 1 === 0 ? k.toFixed(0) : k.toFixed(1)) + 'rb';
              }
              return 'Rp ' + val;
            }
          }
        };
      }

      if (metric === 'semua' || metric === 'pendaftaran') {
        datasets.push({
          label: 'Jumlah Pendaftaran',
          data: dataPendaftaran,
          type: 'bar',
          backgroundColor: '#3B82F6',
          hoverBackgroundColor: '#2563EB',
          borderRadius: isMobileView ? 4 : 6,
          yAxisID: metric === 'semua' ? 'yPendaftaran' : 'y',
          order: 2
        });

        scales[metric === 'semua' ? 'yPendaftaran' : 'y'] = {
          type: 'linear',
          position: metric === 'semua' ? 'right' : 'left',
          grid: metric === 'pendaftaran' ? { color: '#F0F1F5' } : { drawOnChartArea: false },
          ticks: { 
            precision: 0, 
            font: { size: isMobileView ? 10 : 11, weight: '700' },
            callback: function(val) {
              const isMob = window.matchMedia('(max-width: 639px)').matches;
              if (isMob) return val;
              return metric === 'pendaftaran' ? val + ' Siswa' : val;
            }
          }
        };
      }

      chartBulananInstance = new Chart(ctxBulanan, {
        type: 'bar',
        data: {
          labels: bulanLabels,
          datasets: datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { mode: 'index', intersect: false },
          plugins: {
            legend: { display: false },
            tooltip: {
              padding: 12,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  if (label) label += ': ';
                  if (context.dataset.label.includes('Pendapatan')) {
                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                  } else {
                    label += context.raw + ' Pendaftaran';
                  }
                  return label;
                }
              }
            }
          },
          scales: scales
        }
      });
    }

    renderMainChart();
    document.getElementById('laporan-chart-metric')?.removeEventListener('change', renderMainChart);
    document.getElementById('laporan-chart-metric')?.addEventListener('change', renderMainChart);

    // 2. Chart Doughnut Status Pembayaran
    const ctxStatus = document.getElementById('chartStatusPembayaran');
    if (ctxStatus) {
      if (chartStatusInstance) chartStatusInstance.destroy();
      chartStatusInstance = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
          labels: ['Terverifikasi', 'Menunggu', 'Ditolak', 'Kadaluarsa'],
          datasets: [{
            data: [
              statusCounts['terverifikasi'] || 0,
              (statusCounts['menunggu_verifikasi'] || 0) + (statusCounts['menunggu_pembayaran'] || 0),
              statusCounts['ditolak'] || 0,
              statusCounts['kadaluarsa'] || 0
            ],
            backgroundColor: ['#10B981', '#FFC81A', '#EF4444', '#9CA3B0'],
            borderWidth: 0,
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { 
              position: window.innerWidth < 640 ? 'bottom' : 'right', 
              labels: { boxWidth: 12, font: { size: 10.5, weight: 'bold' } } 
            }
          },
          cutout: '68%'
        }
      });
    }

    // 3. Chart Doughnut Jenis Kegiatan
    const ctxJenis = document.getElementById('chartJenisKegiatan');
    if (ctxJenis) {
      if (chartJenisInstance) chartJenisInstance.destroy();
      chartJenisInstance = new Chart(ctxJenis, {
        type: 'doughnut',
        data: {
          labels: ['Pelatihan', 'Sertifikasi'],
          datasets: [{
            data: [
              jenisCounts['pelatihan'] || 0,
              jenisCounts['sertifikasi'] || 0
            ],
            backgroundColor: ['#3B82F6', '#8B5CF6'],
            borderWidth: 0,
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { 
              position: window.innerWidth < 640 ? 'bottom' : 'right', 
              labels: { boxWidth: 12, font: { size: 10.5, weight: 'bold' } } 
            }
          },
          cutout: '68%'
        }
      });
    }
  }

  document.addEventListener('DOMContentLoaded', initLaporanCharts);
  document.addEventListener('livewire:navigated', initLaporanCharts);
})();
</script>
@endpush
