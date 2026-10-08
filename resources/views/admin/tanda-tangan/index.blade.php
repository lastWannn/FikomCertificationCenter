@extends('layouts.admin')

@section('title', 'Kelola Tanda Tangan Digital')
@section('page-title', 'Pengaturan Tanda Tangan Digital')
@section('page-breadcrumb', 'Konten / Kelola Tanda Tangan')

@section('page-content')
<style>
  /* ── Base Container & Typography ── */
  .fcc-ttd-container {
    padding: 24px 28px;
    max-width: 1300px;
    margin: 0 auto;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
  }

  /* ── Header Banner ── */
  .fcc-ttd-header {
    background: linear-gradient(135deg, #131218 0%, #24222E 100%);
    border: 2.5px solid #131218;
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 22px;
    color: #FFF;
    box-shadow: 4px 4px 0px #131218;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 18px;
    box-sizing: border-box;
  }
  .fcc-ttd-title-group {
    flex: 1;
    min-width: 0;
  }
  .fcc-ttd-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 6px;
    flex-wrap: wrap;
  }
  .fcc-ttd-badge-pill {
    background: #FFC81A;
    color: #131218;
    font-weight: 900;
    font-size: 11px;
    padding: 3px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1.5px solid #131218;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
  }
  .fcc-ttd-main-title {
    margin: 0;
    font-size: 22px;
    font-weight: 900;
    font-family: 'Outfit', sans-serif;
    color: #FFFFFF;
    word-break: break-word;
  }
  .fcc-ttd-desc {
    margin: 0;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.75);
    max-width: 720px;
    line-height: 1.5;
  }
  .fcc-ttd-btn-save {
    background: #FFC81A;
    color: #131218;
    border: 2px solid #131218;
    border-radius: 12px;
    padding: 12px 24px;
    font-size: 13.5px;
    font-weight: 900;
    cursor: pointer;
    box-shadow: 3px 3px 0px #FFFFFF;
    transition: all .16s ease-in-out;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-shrink: 0;
    text-decoration: none;
    box-sizing: border-box;
  }
  .fcc-ttd-btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 4px 4px 0px #FFFFFF;
    background: #FFD447;
  }
  .fcc-ttd-btn-save:active {
    transform: translateY(1px);
    box-shadow: 1px 1px 0px #FFFFFF;
  }

  /* ── Category Filter Navigation ── */
  .fcc-ttd-nav {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 16px;
    padding: 12px 18px;
    margin-bottom: 24px;
    box-shadow: 4px 4px 0px #131218;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    box-sizing: border-box;
  }
  .fcc-ttd-nav-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 900;
    color: #1E293B;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .fcc-ttd-pills-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    flex: 1;
    min-width: 0;
    padding: 2px;
  }
  .fcc-ttd-pills-wrap::-webkit-scrollbar {
    display: none;
  }
  .fcc-ttd-pill-btn {
    border: 1.5px solid #CBD5E1;
    background: #F8FAFC;
    color: #475569;
    border-radius: 10px;
    padding: 8px 14px;
    font-size: 12.5px;
    font-weight: 800;
    cursor: pointer;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease-in-out;
    outline: none;
    box-sizing: border-box;
  }
  .fcc-ttd-pill-btn:hover {
    background: #F1F5F9;
    border-color: #94A3B8;
    color: #0F172A;
  }
  .fcc-ttd-pill-btn.active {
    background: #FFC81A !important;
    border-color: #131218 !important;
    color: #131218 !important;
    box-shadow: 2px 2px 0px #131218 !important;
    transform: translateY(-1px);
  }
  .fcc-ttd-pill-count {
    background: rgba(0, 0, 0, 0.08);
    color: inherit;
    font-size: 10.5px;
    font-weight: 900;
    padding: 1px 6px;
    border-radius: 12px;
  }
  .fcc-ttd-pill-btn.active .fcc-ttd-pill-count {
    background: #131218;
    color: #FFC81A;
  }

  /* ── Cards Grid ── */
  .fcc-ttd-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    margin-bottom: 28px;
    box-sizing: border-box;
  }

  /* ── TTD Card ── */
  .fcc-ttd-card {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 16px;
    padding: 22px;
    box-shadow: 4px 4px 0px #131218;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box;
    transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    min-width: 0;
  }
  .fcc-ttd-card:hover {
    transform: translateY(-2px);
  }

  /* ── Card Head ── */
  .fcc-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid #F1F5F9;
    padding-bottom: 14px;
    margin-bottom: 16px;
    gap: 10px;
    flex-wrap: wrap;
  }
  .fcc-card-head-left {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
  }
  .fcc-card-number {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 14px;
    flex-shrink: 0;
  }
  .fcc-card-title {
    margin: 0;
    font-size: 15.5px;
    font-weight: 900;
    color: #131218;
    line-height: 1.3;
    word-break: break-word;
  }
  .fcc-card-sub {
    font-size: 11.5px;
    color: #64748B;
    font-weight: 600;
    display: block;
    margin-top: 2px;
  }
  .fcc-card-badge {
    font-size: 11px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 6px;
    white-space: nowrap;
    border: 1px solid;
    flex-shrink: 0;
  }

  /* ── Form Elements ── */
  .fcc-form-group {
    margin-bottom: 14px;
  }
  .fcc-form-label {
    display: block;
    font-size: 12px;
    font-weight: 800;
    color: #334155;
    margin-bottom: 6px;
  }
  .fcc-form-input {
    width: 100%;
    padding: 10px 14px;
    border: 2px solid #CBD5E1;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    color: #0F172A;
    background: #FFFFFF;
    outline: none;
    box-sizing: border-box;
    transition: all 0.15s;
  }
  .fcc-form-input:focus {
    border-color: #131218;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.2);
  }

  /* ── Dropzone ── */
  .fcc-dropzone-wrap {
    margin-bottom: 10px;
  }
  .fcc-dropzone-label-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    font-weight: 800;
    color: #334155;
    margin-bottom: 8px;
    gap: 6px;
    flex-wrap: wrap;
  }
  .fcc-dropzone-badge {
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 10px;
    white-space: nowrap;
  }
  .fcc-dropzone-box {
    position: relative;
    background: #F8FAFC;
    border: 2.5px dashed #CBD5E1;
    border-radius: 14px;
    padding: 20px 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    overflow: hidden;
    box-sizing: border-box;
  }
  .fcc-dropzone-box:hover {
    border-color: #FFC81A;
    background: #FFFDF5;
  }
  .fcc-dropzone-preview-wrap {
    margin-bottom: 12px;
    background: repeating-conic-gradient(#E2E8F0 0% 25%, #FFF 0% 50%) 50% / 16px 16px;
    border-radius: 10px;
    padding: 14px;
    border: 1.5px solid #CBD5E1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 140px;
    max-width: 100%;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    box-sizing: border-box;
  }
  .fcc-btn-del-ttd {
    background: #FEE2E2;
    color: #DC2626;
    border: 1.5px solid #FCA5A5;
    font-size: 11.5px;
    font-weight: 800;
    padding: 7px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .fcc-btn-del-ttd:hover {
    background: #FEE2E2;
    border-color: #DC2626;
  }

  /* ── Sticky Mobile Action Bar ── */
  .fcc-sticky-mobile-save {
    display: none;
  }

  /* ── Responsive Breakpoints ── */
  @media (max-width: 1199px) {
    .fcc-ttd-container {
      padding: 20px 20px;
    }
    .fcc-ttd-grid {
      gap: 18px;
    }
  }

  @media (max-width: 1023px) {
    .fcc-ttd-container {
      padding: 18px 16px;
    }
    .fcc-ttd-grid {
      grid-template-columns: 1fr;
      gap: 18px;
    }
  }

  @media (max-width: 767px) {
    .fcc-ttd-container {
      padding: 14px 12px 90px 12px; /* Bottom space for sticky bar */
    }
    .fcc-ttd-header {
      flex-direction: column;
      align-items: stretch;
      padding: 18px 16px;
      gap: 14px;
      border-radius: 14px;
      box-shadow: 3px 3px 0px #131218;
    }
    .fcc-ttd-btn-save {
      width: 100%;
      min-height: 44px;
      box-shadow: 2px 2px 0px #FFF;
    }
    .fcc-ttd-main-title {
      font-size: 19px;
    }
    .fcc-ttd-desc {
      font-size: 12px;
    }
    .fcc-ttd-nav {
      flex-direction: column;
      align-items: stretch;
      padding: 12px 14px;
      gap: 10px;
      border-radius: 14px;
      box-shadow: 3px 3px 0px #131218;
    }
    .fcc-ttd-pills-wrap {
      width: 100%;
      padding-bottom: 4px;
    }
    .fcc-ttd-pill-btn {
      padding: 7px 12px;
      font-size: 12px;
    }
    .fcc-ttd-card {
      padding: 16px 14px;
      border-radius: 14px;
      box-shadow: 3px 3px 0px #131218;
    }
    .fcc-card-title {
      font-size: 14.5px;
    }
    .fcc-dropzone-box {
      padding: 16px 12px;
    }
    .fcc-btn-del-ttd {
      width: 100%;
      justify-content: center;
      min-height: 38px;
    }

    /* Sticky Mobile Save Floating Bar */
    .fcc-sticky-mobile-save {
      display: block;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      padding: 12px 16px;
      background: #FFFFFF;
      border-top: 2px solid #131218;
      box-shadow: 0 -4px 16px rgba(19, 18, 24, 0.12);
      z-index: 90;
      box-sizing: border-box;
    }
    .fcc-sticky-mobile-save-btn {
      width: 100%;
      background: #FFC81A;
      color: #131218;
      border: 2px solid #131218;
      border-radius: 12px;
      padding: 12px 18px;
      font-size: 14px;
      font-weight: 900;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 3px 3px 0px #131218;
      cursor: pointer;
    }
  }

  @media (max-width: 479px) {
    .fcc-ttd-container {
      padding: 10px 8px 90px 8px;
    }
    .fcc-ttd-header {
      padding: 14px 12px;
    }
    .fcc-ttd-card {
      padding: 14px 12px;
    }
    .fcc-form-input {
      padding: 9px 12px;
      font-size: 13px;
    }
  }
</style>

<div class="fcc-ttd-container">

  {{-- ═══ FORM UPLOAD TANDA TANGAN ═══════════════════════════════ --}}
  <form id="ttd-main-form" action="{{ route('admin.tanda-tangan.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ═══ HEADER BANNER ═════════════════════════════════════════ --}}
    <div class="fcc-ttd-header">
      <div class="fcc-ttd-title-group">
        <div class="fcc-ttd-title-row">
          <span class="fcc-ttd-badge-pill">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Dokumen Resmi
          </span>
          <h1 class="fcc-ttd-main-title">Pengaturan Tanda Tangan Digital</h1>
        </div>
        <p class="fcc-ttd-desc">
          Upload file tanda tangan (foto/scan kertas putih atau PNG/WebP transparan) dan sesuaikan nama penandatangan. <strong>Sistem otomatis memproses latar belakang</strong> agar tanda tangan menyatu sempurna pada Sertifikat, Invoice, dan Presensi.
        </p>
      </div>

      <button type="submit" class="fcc-ttd-btn-save">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        <span>Simpan Pengaturan</span>
      </button>
    </div>

    {{-- ═══ FLASH MESSAGES ═════════════════════════════════════════ --}}
    @if(session('success'))
      <div style="background: #DEF7EC; border: 2px solid #0E9F6E; color: #03543F; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; justify-content: space-between; box-shadow: 3px 3px 0px #0E9F6E;">
        <div style="display: flex; align-items: center; gap: 10px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; cursor: pointer; color: #03543F;">&times;</button>
      </div>
    @endif

    @if(session('error'))
      <div style="background: #FDE8E8; border: 2px solid #E02424; color: #9B1C1C; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; justify-content: space-between; box-shadow: 3px 3px 0px #E02424;">
        <div style="display: flex; align-items: center; gap: 10px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; cursor: pointer; color: #9B1C1C;">&times;</button>
      </div>
    @endif

    @if($errors->any())
      <div style="background: #FEF08A; border: 2px solid #CA8A04; color: #854D0E; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-weight: 700; font-size: 13px;">
        <ul style="margin: 0; padding-left: 20px;">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- ═══ NAVIGASI KATEGORI TANDA TANGAN (RESPONSIVE PILLS) ═══════ --}}
    <div class="fcc-ttd-nav">
      <div class="fcc-ttd-nav-label">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        <span>Pilih Dokumen:</span>
      </div>

      <div class="fcc-ttd-pills-wrap" id="ttd-pills-container">
        <button type="button" class="fcc-ttd-pill-btn active" data-cat="sertifikat" onclick="switchTtdCategory('sertifikat')">
          <span>🎓 Sertifikat (Dekan &amp; Ketua)</span>
          <span class="fcc-ttd-pill-count">2</span>
        </button>
        <button type="button" class="fcc-ttd-pill-btn" data-cat="invoice" onclick="switchTtdCategory('invoice')">
          <span>🧾 Invoice &amp; Kwitansi</span>
          <span class="fcc-ttd-pill-count">1</span>
        </button>
        <button type="button" class="fcc-ttd-pill-btn" data-cat="presensi" onclick="switchTtdCategory('presensi')">
          <span>📝 Presensi Ujian</span>
          <span class="fcc-ttd-pill-count">1</span>
        </button>
        <button type="button" class="fcc-ttd-pill-btn" data-cat="all" onclick="switchTtdCategory('all')">
          <span>✨ Tampilkan Semua</span>
          <span class="fcc-ttd-pill-count">4</span>
        </button>
      </div>
    </div>

    {{-- ═══ GRID CARDS ═════════════════════════════════════════════ --}}
    <div class="fcc-ttd-grid">

      {{-- 🎓 CARD 1: DEKAN --}}
      <div class="fcc-ttd-card ttd-card-group" data-category="sertifikat">
        <div>
          <div class="fcc-card-head">
            <div class="fcc-card-head-left">
              <div class="fcc-card-number" style="background: #FEF3C7; border: 1.5px solid #F59E0B; color: #B45309;">
                1
              </div>
              <div>
                <h3 class="fcc-card-title">Dekan (Sertifikat Kiri)</h3>
                <span class="fcc-card-sub">Digunakan pada Sertifikat</span>
              </div>
            </div>
            <span class="fcc-card-badge" style="background: #FEF3C7; border-color: #FDE68A; color: #B45309;">Sertifikat Kiri</span>
          </div>

          <div class="fcc-form-group">
            <label class="fcc-form-label">Nama Lengkap &amp; Gelar <span style="color:#DC2626;">*</span></label>
            <input type="text" name="dekan_nama" value="{{ old('dekan_nama', $ttd->dekan_nama) }}" required class="fcc-form-input" placeholder="Contoh: Prof. Dr. John Doe, M.Kom">
          </div>

          <div class="fcc-form-group">
            <label class="fcc-form-label">Jabatan Utama <span style="color:#DC2626;">*</span></label>
            <input type="text" name="dekan_jabatan" value="{{ old('dekan_jabatan', $ttd->dekan_jabatan) }}" required class="fcc-form-input" placeholder="Contoh: Dekan Fakultas Ilmu Komputer">
          </div>

          <div class="fcc-form-group" style="margin-bottom: 16px;">
            <label class="fcc-form-label">NIP / NIDN (Opsional)</label>
            <input type="text" name="dekan_nip" value="{{ old('dekan_nip', $ttd->dekan_nip) }}" placeholder="Contoh: NIP. 19820..." class="fcc-form-input">
          </div>

          {{-- Preview & Upload --}}
          <div class="fcc-dropzone-wrap">
            <div class="fcc-dropzone-label-row">
              <span>Upload Tanda Tangan</span>
              <span class="fcc-dropzone-badge" style="background: #FEF3C7; color: #B45309;">PNG / WebP / JPG</span>
            </div>

            <div class="fcc-dropzone fcc-dropzone-box" id="dropzone-dekan">
              <input type="file" name="dekan_ttd" accept="image/png,image/webp,image/jpeg,image/svg+xml" id="input-dekan" onchange="handleFileSelect(this, 'dekan')" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">

              <div id="dropzone-content-dekan">
                @if($ttd->dekan_ttd)
                  <div class="fcc-dropzone-preview-wrap">
                    <img src="{{ asset('storage/' . $ttd->dekan_ttd) }}" id="preview-img-dekan" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                  </div>
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <div style="font-size: 12px; font-weight: 800; color: #059669; background: #D1FAE5; border: 1px solid #A7F3D0; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                      <span>TTD Dekan Terpasang</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Drag & drop file baru atau <u>klik untuk mengganti</u></span>
                  </div>
                @else
                  <div style="padding: 10px 6px;">
                    <div class="drop-icon" style="width: 44px; height: 44px; background: #FEF3C7; border: 2px solid #F59E0B; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px auto; color: #B45309; transition: transform 0.2s;">
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div style="font-size: 13px; font-weight: 800; color: #1E293B;">Drag &amp; Drop file TTD di sini</div>
                    <div style="font-size: 11.5px; color: #64748B; margin-top: 4px; font-weight: 600;">atau <span style="color: #B45309; text-decoration: underline; font-weight: 800;">klik untuk memilih file</span></div>
                    <div style="font-size: 10.5px; color: #94A3B8; margin-top: 6px; font-weight: 700;">Format: PNG, WebP, JPG (Max 2MB)</div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        @if($ttd->dekan_ttd)
          <div style="margin-top: 14px; text-align: right;">
            <button type="button" onclick="confirmDelete('{{ route('admin.tanda-tangan.destroy', 'dekan') }}', 'TTD Dekan')" class="fcc-btn-del-ttd">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
              <span>Hapus Gambar TTD</span>
            </button>
          </div>
        @endif
      </div>

      {{-- 📜 CARD 2: KETUA UNIT --}}
      <div class="fcc-ttd-card ttd-card-group" data-category="sertifikat">
        <div>
          <div class="fcc-card-head">
            <div class="fcc-card-head-left">
              <div class="fcc-card-number" style="background: #DBEAFE; border: 1.5px solid #2563EB; color: #1D4ED8;">
                2
              </div>
              <div>
                <h3 class="fcc-card-title">Ketua Unit (Sertifikat Kanan)</h3>
                <span class="fcc-card-sub">Digunakan pada Sertifikat</span>
              </div>
            </div>
            <span class="fcc-card-badge" style="background: #DBEAFE; border-color: #BFDBFE; color: #1D4ED8;">Sertifikat Kanan</span>
          </div>

          <div class="fcc-form-group">
            <label class="fcc-form-label">Nama Lengkap &amp; Gelar <span style="color:#DC2626;">*</span></label>
            <input type="text" name="ketua_nama" value="{{ old('ketua_nama', $ttd->ketua_nama) }}" required class="fcc-form-input" placeholder="Contoh: Dr. Jane Doe, M.Cs">
          </div>

          <div class="fcc-form-group">
            <label class="fcc-form-label">Jabatan Utama <span style="color:#DC2626;">*</span></label>
            <input type="text" name="ketua_jabatan" value="{{ old('ketua_jabatan', $ttd->ketua_jabatan) }}" required class="fcc-form-input" placeholder="Contoh: Ketua FIKOM Certification Center">
          </div>

          <div class="fcc-form-group" style="margin-bottom: 16px;">
            <label class="fcc-form-label">NIP / NIDN (Opsional)</label>
            <input type="text" name="ketua_nip" value="{{ old('ketua_nip', $ttd->ketua_nip) }}" placeholder="Contoh: NIP. 19850..." class="fcc-form-input">
          </div>

          {{-- Preview & Upload --}}
          <div class="fcc-dropzone-wrap">
            <div class="fcc-dropzone-label-row">
              <span>Upload Tanda Tangan</span>
              <span class="fcc-dropzone-badge" style="background: #DBEAFE; color: #1D4ED8;">PNG / WebP / JPG</span>
            </div>

            <div class="fcc-dropzone fcc-dropzone-box" id="dropzone-ketua">
              <input type="file" name="ketua_ttd" accept="image/png,image/webp,image/jpeg,image/svg+xml" id="input-ketua" onchange="handleFileSelect(this, 'ketua')" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">

              <div id="dropzone-content-ketua">
                @if($ttd->ketua_ttd)
                  <div class="fcc-dropzone-preview-wrap">
                    <img src="{{ asset('storage/' . $ttd->ketua_ttd) }}" id="preview-img-ketua" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                  </div>
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <div style="font-size: 12px; font-weight: 800; color: #059669; background: #D1FAE5; border: 1px solid #A7F3D0; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                      <span>TTD Ketua Terpasang</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Drag & drop file baru atau <u>klik untuk mengganti</u></span>
                  </div>
                @else
                  <div style="padding: 10px 6px;">
                    <div class="drop-icon" style="width: 44px; height: 44px; background: #DBEAFE; border: 2px solid #2563EB; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px auto; color: #1D4ED8; transition: transform 0.2s;">
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div style="font-size: 13px; font-weight: 800; color: #1E293B;">Drag &amp; Drop file TTD di sini</div>
                    <div style="font-size: 11.5px; color: #64748B; margin-top: 4px; font-weight: 600;">atau <span style="color: #2563EB; text-decoration: underline; font-weight: 800;">klik untuk memilih file</span></div>
                    <div style="font-size: 10.5px; color: #94A3B8; margin-top: 6px; font-weight: 700;">Format: PNG, WebP, JPG (Max 2MB)</div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        @if($ttd->ketua_ttd)
          <div style="margin-top: 14px; text-align: right;">
            <button type="button" onclick="confirmDelete('{{ route('admin.tanda-tangan.destroy', 'ketua') }}', 'TTD Ketua Unit')" class="fcc-btn-del-ttd">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
              <span>Hapus Gambar TTD</span>
            </button>
          </div>
        @endif
      </div>

      {{-- 🧾 CARD 3: BENDAHARA / INVOICE --}}
      <div class="fcc-ttd-card ttd-card-group" data-category="invoice">
        <div>
          <div class="fcc-card-head">
            <div class="fcc-card-head-left">
              <div class="fcc-card-number" style="background: #D1FAE5; border: 1.5px solid #059669; color: #047857;">
                3
              </div>
              <div>
                <h3 class="fcc-card-title">Bendahara (Invoice &amp; Kwitansi)</h3>
                <span class="fcc-card-sub">Digunakan pada Invoice Pembayaran</span>
              </div>
            </div>
            <span class="fcc-card-badge" style="background: #ECFDF5; border-color: #A7F3D0; color: #047857;">Invoice &amp; Bukti</span>
          </div>

          <div class="fcc-form-group">
            <label class="fcc-form-label">Nama Penandatangan Invoice <span style="color:#DC2626;">*</span></label>
            <input type="text" name="bendahara_nama" value="{{ old('bendahara_nama', $ttd->bendahara_nama) }}" required class="fcc-form-input" placeholder="Contoh: Siti Rahma, S.E.">
          </div>

          <div class="fcc-form-group">
            <label class="fcc-form-label">Jabatan Utama <span style="color:#DC2626;">*</span></label>
            <input type="text" name="bendahara_jabatan" value="{{ old('bendahara_jabatan', $ttd->bendahara_jabatan) }}" required class="fcc-form-input" placeholder="Contoh: Bendahara Unit Sertifikasi">
          </div>

          <div class="fcc-form-group" style="margin-bottom: 16px;">
            <label class="fcc-form-label">NIP / Kode Verifikasi (Opsional)</label>
            <input type="text" name="bendahara_nip" value="{{ old('bendahara_nip', $ttd->bendahara_nip) }}" placeholder="Contoh: FCC-ADM-01" class="fcc-form-input">
          </div>

          {{-- Preview & Upload --}}
          <div class="fcc-dropzone-wrap">
            <div class="fcc-dropzone-label-row">
              <span>Upload TTD / Stempel Keuangan</span>
              <span class="fcc-dropzone-badge" style="background: #D1FAE5; color: #047857;">PNG / WebP / JPG</span>
            </div>

            <div class="fcc-dropzone fcc-dropzone-box" id="dropzone-bendahara">
              <input type="file" name="bendahara_ttd" accept="image/png,image/webp,image/jpeg,image/svg+xml" id="input-bendahara" onchange="handleFileSelect(this, 'bendahara')" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">

              <div id="dropzone-content-bendahara">
                @if($ttd->bendahara_ttd)
                  <div class="fcc-dropzone-preview-wrap">
                    <img src="{{ asset('storage/' . $ttd->bendahara_ttd) }}" id="preview-img-bendahara" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                  </div>
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <div style="font-size: 12px; font-weight: 800; color: #059669; background: #D1FAE5; border: 1px solid #A7F3D0; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                      <span>TTD/Stempel Invoice Terpasang</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Drag & drop file baru atau <u>klik untuk mengganti</u></span>
                  </div>
                @else
                  <div style="padding: 10px 6px;">
                    <div class="drop-icon" style="width: 44px; height: 44px; background: #D1FAE5; border: 2px solid #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px auto; color: #047857; transition: transform 0.2s;">
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div style="font-size: 13px; font-weight: 800; color: #1E293B;">Drag &amp; Drop file TTD di sini</div>
                    <div style="font-size: 11.5px; color: #64748B; margin-top: 4px; font-weight: 600;">atau <span style="color: #059669; text-decoration: underline; font-weight: 800;">klik untuk memilih file</span></div>
                    <div style="font-size: 10.5px; color: #94A3B8; margin-top: 6px; font-weight: 700;">Format: PNG, WebP, JPG (Max 2MB)</div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        @if($ttd->bendahara_ttd)
          <div style="margin-top: 14px; text-align: right;">
            <button type="button" onclick="confirmDelete('{{ route('admin.tanda-tangan.destroy', 'bendahara') }}', 'TTD/Stempel Bendahara')" class="fcc-btn-del-ttd">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
              <span>Hapus Gambar TTD</span>
            </button>
          </div>
        @endif
      </div>

      {{-- 📝 CARD 4: PROKTOR UJIAN --}}
      <div class="fcc-ttd-card ttd-card-group" data-category="presensi">
        <div>
          <div class="fcc-card-head">
            <div class="fcc-card-head-left">
              <div class="fcc-card-number" style="background: #F3E8FF; border: 1.5px solid #9333EA; color: #7E22CE;">
                4
              </div>
              <div>
                <h3 class="fcc-card-title">Proktor Ujian (Lembar Presensi)</h3>
                <span class="fcc-card-sub">Digunakan pada Cetakan Presensi Ujian</span>
              </div>
            </div>
            <span class="fcc-card-badge" style="background: #F3E8FF; border-color: #D8B4FE; color: #7E22CE;">Presensi Ujian</span>
          </div>

          <div class="fcc-form-group">
            <label class="fcc-form-label">Nama Lengkap &amp; Gelar <span style="color:#DC2626;">*</span></label>
            <input type="text" name="proktor_nama" value="{{ old('proktor_nama', $ttd->proktor_nama) }}" required class="fcc-form-input" placeholder="Contoh: Ahmad Fauzi, S.Kom">
          </div>

          <div class="fcc-form-group">
            <label class="fcc-form-label">Jabatan Utama <span style="color:#DC2626;">*</span></label>
            <input type="text" name="proktor_jabatan" value="{{ old('proktor_jabatan', $ttd->proktor_jabatan) }}" required class="fcc-form-input" placeholder="Contoh: Proktor Pelaksana Ujian">
          </div>

          <div class="fcc-form-group" style="margin-bottom: 16px;">
            <label class="fcc-form-label">NIP / NIDN / ID Proktor (Opsional)</label>
            <input type="text" name="proktor_nip" value="{{ old('proktor_nip', $ttd->proktor_nip) }}" placeholder="Contoh: NIDN. 0912..." class="fcc-form-input">
          </div>

          {{-- Preview & Upload --}}
          <div class="fcc-dropzone-wrap">
            <div class="fcc-dropzone-label-row">
              <span>Upload Tanda Tangan</span>
              <span class="fcc-dropzone-badge" style="background: #F3E8FF; color: #7E22CE;">PNG / WebP / JPG</span>
            </div>

            <div class="fcc-dropzone fcc-dropzone-box" id="dropzone-proktor">
              <input type="file" name="proktor_ttd" accept="image/png,image/webp,image/jpeg,image/svg+xml" id="input-proktor" onchange="handleFileSelect(this, 'proktor')" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">

              <div id="dropzone-content-proktor">
                @if($ttd->proktor_ttd)
                  <div class="fcc-dropzone-preview-wrap">
                    <img src="{{ asset('storage/' . $ttd->proktor_ttd) }}" id="preview-img-proktor" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                  </div>
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <div style="font-size: 12px; font-weight: 800; color: #7E22CE; background: #F3E8FF; border: 1px solid #D8B4FE; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                      <span>TTD Proktor Terpasang</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Drag & drop file baru atau <u>klik untuk mengganti</u></span>
                  </div>
                @else
                  <div style="padding: 10px 6px;">
                    <div class="drop-icon" style="width: 44px; height: 44px; background: #F3E8FF; border: 2px solid #9333EA; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px auto; color: #7E22CE; transition: transform 0.2s;">
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div style="font-size: 13px; font-weight: 800; color: #1E293B;">Drag &amp; Drop file TTD di sini</div>
                    <div style="font-size: 11.5px; color: #64748B; margin-top: 4px; font-weight: 600;">atau <span style="color: #9333EA; text-decoration: underline; font-weight: 800;">klik untuk memilih file</span></div>
                    <div style="font-size: 10.5px; color: #94A3B8; margin-top: 6px; font-weight: 700;">Format: PNG, WebP, JPG (Max 2MB)</div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        @if($ttd->proktor_ttd)
          <div style="margin-top: 14px; text-align: right;">
            <button type="button" onclick="confirmDelete('{{ route('admin.tanda-tangan.destroy', 'proktor') }}', 'TTD Proktor Ujian')" class="fcc-btn-del-ttd">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
              <span>Hapus Gambar TTD</span>
            </button>
          </div>
        @endif
      </div>

    </div>

    {{-- ═══ STICKY MOBILE SAVE BAR ═════════════════════════════════ --}}
    <div class="fcc-sticky-mobile-save">
      <button type="submit" class="fcc-sticky-mobile-save-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        <span>Simpan Semua Pengaturan</span>
      </button>
    </div>

  </form>
</div>

{{-- FORM DELETE HIDDEN --}}
<form id="delete-ttd-form" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>

<script>
function handleFileSelect(input, key) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
      const contentBox = document.getElementById('dropzone-content-' + key);
      if (contentBox) {
        contentBox.innerHTML = `
          <div class="fcc-dropzone-preview-wrap" style="border: 2px solid #FFC81A; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);">
            <img src="${e.target.result}" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));">
          </div>
          <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; width: 100%;">
            <div style="font-size: 12px; font-weight: 800; color: #B45309; background: #FEF3C7; border: 1px solid #FDE68A; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px; max-width: 100%; word-break: break-all;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
              <span>${escapeHtml(file.name)} (${(file.size / 1024).toFixed(1)} KB)</span>
            </div>
            <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Klik "Simpan Pengaturan" untuk menyimpan</span>
          </div>
        `;
      }
    };
    reader.readAsDataURL(file);
  }
}

function escapeHtml(text) {
  return text.replace(/[&<>"']/g, function(m) {
    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
  });
}

function confirmDelete(url, title) {
  const form = document.getElementById('delete-ttd-form');
  if (!form) return;
  form.action = url;

  if (typeof window.fccConfirm === 'function') {
    window.fccConfirm({
      title: 'Hapus ' + title + '?',
      msg: 'Gambar ' + title + ' akan dihapus secara permanen. Tanda tangan pada dokumen sertifikat/invoice yang belum diterbitkan akan dikosongkan.',
      danger: true,
      btnText: 'Ya, Hapus Gambar',
      onConfirm: function() {
        HTMLFormElement.prototype.submit.call(form);
      }
    });
  } else {
    if (confirm('Apakah Anda yakin ingin menghapus ' + title + '?')) {
      HTMLFormElement.prototype.submit.call(form);
    }
  }
}

// Function to dynamically filter TTD cards by category and sync pill buttons
function switchTtdCategory(cat) {
  const cards = document.querySelectorAll('.ttd-card-group');
  cards.forEach(card => {
    if (cat === 'all' || card.dataset.category === cat) {
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  });

  const buttons = document.querySelectorAll('.fcc-ttd-pill-btn');
  buttons.forEach(btn => {
    if (btn.dataset.cat === cat) {
      btn.classList.add('active');
    } else {
      btn.classList.remove('active');
    }
  });
}

// Drag & Drop event handlers
document.addEventListener('DOMContentLoaded', function() {
  switchTtdCategory('sertifikat');

  document.querySelectorAll('.fcc-dropzone').forEach(dropzone => {
    const input = dropzone.querySelector('input[type="file"]');
    if (!input) return;

    ['dragenter', 'dragover'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.style.borderColor = '#F59E0B';
        dropzone.style.background = '#FFFBEB';
        dropzone.style.transform = 'scale(1.01)';
        const icon = dropzone.querySelector('.drop-icon');
        if (icon) icon.style.transform = 'scale(1.15) rotate(-6deg)';
      }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.style.borderColor = '#CBD5E1';
        dropzone.style.background = '#F8FAFC';
        dropzone.style.transform = 'scale(1)';
        const icon = dropzone.querySelector('.drop-icon');
        if (icon) icon.style.transform = 'scale(1) rotate(0deg)';
      }, false);
    });
  });
});
</script>
@endsection
