@extends('layouts.public')
@section('title', $sertifikat ? 'Verifikasi Sertifikat - ' . $sertifikat->nomor_sertifikat : 'Verifikasi Sertifikat')
@section('meta-description', 'Pemeriksaan keabsahan sertifikat resmi FIKOM Certification Center Universitas Muslim Indonesia.')

@push('styles')
<style>
    /* ═══════════════════════════════════════════════════════════════════════
       VERIFIKASI SERTIFIKAT — MOBILE FIRST & ULTRA RESPONSIVE DESIGN
       ═══════════════════════════════════════════════════════════════════════ */
    .verify-page-wrapper {
        background: #131218;
        min-height: calc(100vh - 70px);
        padding: 48px 16px 80px;
        box-sizing: border-box;
    }
    /* Pastikan ada jarak aman jika info ticker running di bawah navbar aktif */
    #fcc-ticker ~ main .verify-page-wrapper,
    body:has(#fcc-ticker) .verify-page-wrapper {
        padding-top: 54px;
    }
    .verify-container {
        max-width: 860px;
        margin: 0 auto;
        width: 100%;
        box-sizing: border-box;
    }

    /* Page Titles */

    .verify-title {
        color: #FFFFFF;
        font-size: clamp(22px, 4vw, 28px);
        font-weight: 900;
        letter-spacing: -0.5px;
        margin: 0 0 8px 0;
        line-height: 1.25;
    }
    .verify-subtitle {
        color: #94A3B8;
        font-size: clamp(13px, 2.5vw, 14px);
        margin: 0 auto;
        max-width: 560px;
        line-height: 1.55;
    }

    /* Main Card */
    .verify-main-card {
        background: #181720;
        border: 1.5px solid rgba(255, 200, 26, 0.28);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5), 0 0 40px rgba(255,200,26,0.06);
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
    }

    /* Card Header */
    .verify-card-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding-bottom: 22px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        margin-bottom: 24px;
    }
    .verify-cert-num-group {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 260px;
    }
    .verify-cert-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        background: rgba(255,200,26,0.12);
        border: 1px solid rgba(255,200,26,0.3);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFC81A;
    }
    .verify-cert-info {
        flex: 1;
        min-width: 0;
    }
    .verify-cert-label {
        font-size: 11px;
        font-weight: 800;
        color: #94A3B8;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 4px;
    }
    .verify-cert-code-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .verify-cert-code {
        font-size: 17px;
        font-weight: 900;
        color: #FFC81A;
        letter-spacing: 0.5px;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        word-break: break-all;
    }
    .verify-copy-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.16);
        color: #E2E8F0;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: all .2s;
        user-select: none;
    }
    .verify-copy-btn:hover {
        background: rgba(255, 200, 26, 0.2);
        border-color: #FFC81A;
        color: #FFC81A;
    }

    .verify-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(16,185,129,0.15);
        border: 1px solid rgba(16,185,129,0.45);
        color: #10B981;
        font-size: 12px;
        font-weight: 900;
        padding: 8px 16px;
        border-radius: 12px;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    /* Meta Grid */
    .verify-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }
    .verify-meta-box {
        background: #1F1E29;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: border-color .2s, transform .2s;
        box-sizing: border-box;
    }
    .verify-meta-box:hover {
        border-color: rgba(255, 200, 26, 0.3);
    }
    .verify-meta-top {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        color: #94A3B8;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 8px;
    }
    .verify-meta-title {
        font-size: 16px;
        font-weight: 900;
        color: #FFFFFF;
        line-height: 1.35;
        word-break: break-word;
    }
    .verify-meta-sub {
        font-size: 12px;
        color: #64748B;
        margin-top: 6px;
        line-height: 1.4;
    }

    /* Transcript Table & Mobile Cards */
    .verify-section-title {
        font-size: 13.5px;
        font-weight: 900;
        color: #FFF;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 0 0 14px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .verify-desktop-transcript {
        display: block;
    }
    .verify-mobile-transcript {
        display: none;
    }

    .verify-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }
    .verify-table th {
        background: #1F1E29;
        color: #94A3B8;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 12px 16px;
        border-bottom: 1.5px solid rgba(255, 255, 255, 0.1);
    }
    .verify-table td {
        padding: 13px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #E2E8F0;
    }
    .verify-table tr:last-child td {
        border-bottom: none;
    }

    /* Mobile Unit Cards */
    .mobile-unit-card {
        background: #1F1E29;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 12px;
        transition: border-color .2s;
    }
    .mobile-unit-card:last-child {
        margin-bottom: 0;
    }
    .mobile-unit-card:active {
        border-color: rgba(255, 200, 26, 0.35);
    }
    .mobile-unit-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    .mobile-unit-no {
        font-size: 10.5px;
        font-weight: 800;
        color: #94A3B8;
        background: rgba(255,255,255,0.06);
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .mobile-unit-grade {
        font-size: 11px;
        font-weight: 800;
        color: #10B981;
        background: rgba(16,185,129,0.12);
        border: 1px solid rgba(16,185,129,0.3);
        padding: 2px 8px;
        border-radius: 6px;
    }
    .mobile-unit-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #FFFFFF;
        line-height: 1.45;
        margin-bottom: 12px;
    }
    .mobile-unit-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-top: 10px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }
    .mobile-unit-score-wrap {
        display: flex;
        align-items: baseline;
        gap: 4px;
    }
    .mobile-score-val {
        font-size: 15px;
        font-weight: 900;
        color: #FFC81A;
    }
    .mobile-score-max {
        font-size: 11px;
        color: #64748B;
        font-weight: 700;
    }

    /* Signatories */
    .verify-sign-box {
        padding: 20px;
        background: #14131A;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px;
        margin-bottom: 28px;
        box-sizing: border-box;
    }
    .verify-sign-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 8px;
    }
    .verify-sign-label {
        font-size: 11px;
        font-weight: 800;
        color: #94A3B8;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    .verify-sign-verified {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #10B981;
        font-size: 11px;
        font-weight: 700;
    }
    .verify-sign-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .verify-sign-person {
        background: #181720;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.05);
    }

    /* Action Buttons */
    .verify-actions-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding-top: 22px;
        border-top: 1px solid rgba(255,255,255,0.08);
    }
    .btn-verify-primary {
        background: linear-gradient(135deg, #FFC81A 0%, #FFA800 100%);
        color: #131218;
        font-size: 14px;
        font-weight: 900;
        padding: 13px 26px;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 6px 20px rgba(255,200,26,0.35);
        transition: transform .15s, box-shadow .15s;
        min-height: 48px;
        box-sizing: border-box;
    }
    .btn-verify-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(255,200,26,0.45);
    }
    .btn-verify-secondary {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        color: #E2E8F0;
        font-size: 13px;
        font-weight: 700;
        padding: 12px 18px;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all .2s;
        min-height: 48px;
        cursor: pointer;
        box-sizing: border-box;
    }
    .btn-verify-secondary:hover {
        background: rgba(255,255,255,0.1);
        color: #FFF;
        border-color: rgba(255,255,255,0.2);
    }
    .btn-verify-ghost {
        color: #94A3B8;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 4px;
        transition: color .2s;
    }
    .btn-verify-ghost:hover {
        color: #FFC81A;
    }

    /* Security Note */
    .verify-security-note {
        margin-top: 24px;
        text-align: center;
        font-size: 11.5px;
        color: #64748B;
        line-height: 1.5;
        padding: 0 16px;
    }

    /* Toast */
    .verify-toast {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background: #10B981;
        color: #131218;
        font-weight: 800;
        font-size: 13px;
        padding: 10px 22px;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 20px rgba(16,185,129,0.3);
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .verify-toast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    /* ═══════════════════════════════════════════════════════════════════════
       MOBILE RESPONSIVENESS OVERRIDES (max-width: 640px)
       ═══════════════════════════════════════════════════════════════════════ */
    @media (max-width: 640px) {
        .verify-page-wrapper {
            padding: 58px 14px 60px;
        }
        #fcc-ticker ~ main .verify-page-wrapper,
        body:has(#fcc-ticker) .verify-page-wrapper {
            padding-top: 68px;
        }
        .verify-main-card {
            padding: 20px 14px;
            border-radius: 18px;
        }
        .verify-card-header {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            padding-bottom: 18px;
            margin-bottom: 18px;
        }
        .verify-cert-num-group {
            min-width: 0;
            width: 100%;
        }
        .verify-cert-code {
            font-size: 15px;
        }
        .verify-status-badge {
            width: 100%;
            justify-content: center;
            box-sizing: border-box;
            padding: 10px 14px;
            font-size: 12.5px;
        }
        .verify-meta-grid {
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 22px;
        }
        .verify-meta-box {
            padding: 14px 14px;
            border-radius: 14px;
        }
        .verify-desktop-transcript {
            display: none !important;
        }
        .verify-mobile-transcript {
            display: block !important;
        }
        .verify-sign-box {
            padding: 16px 14px;
            border-radius: 14px;
            margin-bottom: 22px;
        }
        .verify-sign-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .verify-actions-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
            padding-top: 18px;
        }
        .btn-verify-primary {
            width: 100%;
            font-size: 14.5px;
        }
        .btn-verify-secondary {
            width: 100%;
            font-size: 13px;
        }
        .btn-verify-ghost {
            justify-content: center;
            width: 100%;
            padding: 10px 0;
        }
    }
</style>
@endpush

@section('page-content')
@php
    $pendaftaran = $sertifikat?->pendaftaran;
    $kegiatan = $pendaftaran?->kegiatan;
    $peserta = $pendaftaran?->peserta;
    $isPel = $kegiatan?->jenis_kegiatan === 'pelatihan';

    if ($isPel) {
        $jadwal = $kegiatan?->kegiatanPelatihan?->jadwalPelatihan;
        $program = $jadwal?->pelatihan;
        $labelProgram = 'Pelatihan Kompetensi';
        $labelMateri = 'Unit Materi Pelatihan';
        $materiList = $program?->materi ?? collect();
    } else {
        $jadwal = $kegiatan?->kegiatanSertifikasi?->jadwalSertifikasi;
        $program = $jadwal?->sertifikasi;
        $labelProgram = 'Sertifikasi Kompetensi';
        $labelMateri = 'Unit Kompetensi / Modul Ujian';
        $materiList = $program?->materi ?? collect();
    }

    $tglPelaksanaan = $jadwal?->tgl_pelaksanaan ? \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d F Y') : '-';
    $tglTerbit = $sertifikat?->tgl_terbit ? \Carbon\Carbon::parse($sertifikat->tgl_terbit)->translatedFormat('d F Y') : '-';

    $avgScore = ($pendaftaran && $pendaftaran->nilai->count() > 0) ? round($pendaftaran->nilai->avg('nilai'), 1) : null;
    $getPredicate = function ($score) {
        if ($score === null) return ['grade' => '-', 'text' => '-', 'status' => '-'];
        $s = (float)$score;
        if ($s >= 85) return ['grade' => 'A', 'text' => 'Sangat Baik', 'status' => 'KOMPETEN'];
        if ($s >= 75) return ['grade' => 'B', 'text' => 'Baik', 'status' => 'KOMPETEN'];
        if ($s >= 65) return ['grade' => 'C', 'text' => 'Cukup', 'status' => 'KOMPETEN'];
        return ['grade' => 'D', 'text' => 'Kurang', 'status' => 'BELUM KOMPETEN'];
    };
    $finalPred = $getPredicate($avgScore);

    $snap = $sertifikat?->ttd_snapshot ?? [];
    $activeTtd = \App\Models\TandaTangan::getAktif();
    $dekanNama = $snap['dekan_nama'] ?? $activeTtd->dekan_nama;
    $dekanJabatan = $snap['dekan_jabatan'] ?? $activeTtd->dekan_jabatan;
    $ketuaNama = $snap['ketua_nama'] ?? $activeTtd->ketua_nama;
    $ketuaJabatan = $snap['ketua_jabatan'] ?? $activeTtd->ketua_jabatan;

    $pdfUrl = $sertifikat ? route('sertifikat.verifikasi.pdf', $sertifikat->hashid ?? $sertifikat->id) : '#';
@endphp

<div class="verify-page-wrapper">
  <div class="verify-container">

    @if($sertifikat)
      {{-- ════════════════════════════════════════════════════════════════ --}}
      {{-- VERIFIED STATE                                                    --}}
      {{-- ════════════════════════════════════════════════════════════════ --}}
      
      {{-- Top Header Status --}}
      <div style="text-align:center;margin-bottom:24px;">
        <h1 class="verify-title">
          Verifikasi Keabsahan Dokumen
        </h1>
        <p class="verify-subtitle">
          Data sertifikat kompetensi ini tercatat secara sah di pangkalan data resmi FIKOM Certification Center, Universitas Muslim Indonesia.
        </p>
      </div>

      {{-- Main Card --}}
      <div class="verify-main-card">
        
        {{-- Header Card: No Sertifikat & Brand --}}
        <div class="verify-card-header">
          <div class="verify-cert-num-group">
            <div class="verify-cert-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
            </div>
            <div class="verify-cert-info">
              <div class="verify-cert-label">Nomor Sertifikat</div>
              <div class="verify-cert-code-wrap">
                <span class="verify-cert-code" id="cert-number-text">{{ $sertifikat->nomor_sertifikat }}</span>
                <button type="button" class="verify-copy-btn" onclick="copyCertNumber()" title="Salin Nomor Sertifikat">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                  <span id="copy-btn-label">Salin</span>
                </button>
              </div>
            </div>
          </div>

          <div class="verify-status-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
            STATUS: DOKUMEN VALID &amp; SAH
          </div>
        </div>

        {{-- Meta Grid (Responsive 2 cols / 1 col on mobile) --}}
        <div class="verify-meta-grid">
          
          {{-- 1. Penerima --}}
          <div class="verify-meta-box">
            <div>
              <div class="verify-meta-top">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Nama Penerima
              </div>
              <div class="verify-meta-title">{{ $peserta->nama ?? '-' }}</div>
            </div>
            <div class="verify-meta-sub">
              Email: {{ $peserta->email ?? '-' }}
            </div>
          </div>

          {{-- 2. Program --}}
          <div class="verify-meta-box">
            <div>
              <div class="verify-meta-top">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                Program / Kegiatan
              </div>
              <div class="verify-meta-title">{{ $kegiatan->judul ?? '-' }}</div>
            </div>
            <div class="verify-meta-sub" style="color:#FFC81A;font-weight:700;">
              {{ $labelProgram }}
            </div>
          </div>

          {{-- 3. Waktu Pelaksanaan --}}
          <div class="verify-meta-box">
            <div>
              <div class="verify-meta-top">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Waktu Pelaksanaan
              </div>
              <div class="verify-meta-title" style="font-size:15px;">{{ $tglPelaksanaan }}</div>
            </div>
            <div class="verify-meta-sub">
              Diterbitkan: {{ $tglTerbit }}
            </div>
          </div>

          {{-- 4. Hasil Capaian --}}
          <div class="verify-meta-box">
            <div>
              <div class="verify-meta-top">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                Hasil Capaian Kelulusan
              </div>
              <div style="display:flex;align-items:baseline;gap:8px;">
                <span style="font-size:22px;font-weight:900;color:#10B981;">{{ $avgScore !== null ? $avgScore : '-' }}</span>
                <span style="font-size:13px;font-weight:800;color:#E2E8F0;">
                  Predikat: {{ $finalPred['text'] }} (Grade {{ $finalPred['grade'] }})
                </span>
              </div>
            </div>
            <div class="verify-meta-sub" style="color:#94A3B8;">
              Kualifikasi: <strong style="color:{{ $finalPred['status'] === 'KOMPETEN' ? '#10B981' : ($finalPred['status'] === '-' ? '#94A3B8' : '#FFC81A') }};">{{ $finalPred['status'] }}</strong>
            </div>
          </div>

        </div>

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- TRANSCRIPT SECTION                                             --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div style="margin-bottom:28px;">
          <h2 class="verify-section-title">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Transkrip Capaian Kompetensi
          </h2>

          {{-- A. DESKTOP VIEW (Table) --}}
          <div class="verify-desktop-transcript" style="background:#1F1E29;border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
            <table class="verify-table">
              <thead>
                <tr>
                  <th style="width:8%;text-align:center;">No</th>
                  <th style="width:62%;text-align:left;">{{ $labelMateri }}</th>
                  <th style="width:15%;text-align:center;">Skor</th>
                  <th style="width:15%;text-align:center;">Predikat</th>
                </tr>
              </thead>
              <tbody>
                @if($materiList->count() > 0)
                  @foreach($materiList as $idx => $mat)
                    @php
                      $nilaiObj = $isPel
                          ? $pendaftaran->nilai->where('materi_pelatihan_id', $mat->id)->first()
                          : $pendaftaran->nilai->where('materi_sertifikasi_id', $mat->id)->first();
                      $nVal = $nilaiObj ? round($nilaiObj->nilai, 1) : null;
                      $pVal = $getPredicate($nVal);
                    @endphp
                    <tr>
                      <td style="text-align:center;color:#64748B;">{{ $idx + 1 }}</td>
                      <td style="font-weight:700;color:#FFF;">{{ $mat->judul_materi }}</td>
                      <td style="text-align:center;font-weight:900;color:#FFC81A;">{{ $nVal !== null ? $nVal : '-' }}</td>
                      <td style="text-align:center;color:#94A3B8;">{{ $pVal['text'] }}</td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="4" style="text-align:center;padding:24px;color:#64748B;">
                      Belum ada rincian unit kompetensi yang tercatat.
                    </td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>

          {{-- B. MOBILE VIEW (Native-like Cards) --}}
          <div class="verify-mobile-transcript">
            @if($materiList->count() > 0)
              @foreach($materiList as $idx => $mat)
                @php
                  $nilaiObj = $isPel
                      ? $pendaftaran->nilai->where('materi_pelatihan_id', $mat->id)->first()
                      : $pendaftaran->nilai->where('materi_sertifikasi_id', $mat->id)->first();
                  $nVal = $nilaiObj ? round($nilaiObj->nilai, 1) : null;
                  $pVal = $getPredicate($nVal);
                @endphp
                <div class="mobile-unit-card">
                  <div class="mobile-unit-header">
                    <span class="mobile-unit-no">Unit #{{ $idx + 1 }}</span>
                    <span class="mobile-unit-grade">Grade {{ $pVal['grade'] }} &bull; {{ $pVal['text'] }}</span>
                  </div>
                  <div class="mobile-unit-title">
                    {{ $mat->judul_materi }}
                  </div>
                  <div class="mobile-unit-footer">
                    <span style="font-size:11.5px;color:#94A3B8;font-weight:600;">Skor Capaian:</span>
                    <div class="mobile-unit-score-wrap">
                      <span class="mobile-score-val">{{ $nVal !== null ? $nVal : '-' }}</span>
                      <span class="mobile-score-max">/ 100</span>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="mobile-unit-card" style="text-align:center;color:#64748B;padding:20px;">
                Belum ada rincian unit kompetensi yang tercatat.
              </div>
            @endif
          </div>
        </div>

        {{-- Signatories Info --}}
        <div class="verify-sign-box">
          <div class="verify-sign-header">
            <span class="verify-sign-label">Pengesahan Dokumen Elektronik</span>
            <span class="verify-sign-verified">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
              Tervalidasi Digital
            </span>
          </div>
          <div class="verify-sign-grid">
            <div class="verify-sign-person">
              <div style="font-size:13.5px;font-weight:900;color:#FFF;">{{ $dekanNama }}</div>
              <div style="font-size:11px;color:#FFC81A;font-weight:700;margin-top:2px;">{{ $dekanJabatan }}</div>
            </div>
            <div class="verify-sign-person">
              <div style="font-size:13.5px;font-weight:900;color:#FFF;">{{ $ketuaNama }}</div>
              <div style="font-size:11px;color:#FFC81A;font-weight:700;margin-top:2px;">{{ $ketuaJabatan }}</div>
            </div>
          </div>
        </div>

        {{-- Action Buttons --}}
        <div class="verify-actions-bar">
          <a href="{{ route('landing.index') }}" class="btn-verify-ghost">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Beranda
          </a>

          <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;" class="verify-right-actions">
            <button type="button" onclick="shareVerification()" class="btn-verify-secondary" title="Bagikan Bukti Verifikasi">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
              <span>Bagikan</span>
            </button>

            <a href="{{ $pdfUrl }}" target="_blank" class="btn-verify-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 18 15 15"/></svg>
              <span>Buka Dokumen PDF Asli</span>
            </a>
          </div>
        </div>

      </div>

      {{-- Security Disclaimer Footer --}}
      <div class="verify-security-note">
        Dokumen ini diterbitkan secara elektronik dan dilindungi dengan QR Code verifikasi terenkripsi.<br>
        Sistem sertifikasi resmi FIKOM Certification Center &copy; {{ date('Y') }} Universitas Muslim Indonesia.
      </div>

    @else
      {{-- ════════════════════════════════════════════════════════════════ --}}
      {{-- NOT FOUND / INVALID STATE                                        --}}
      {{-- ════════════════════════════════════════════════════════════════ --}}
      <div class="verify-main-card" style="text-align:center;padding:48px 20px;">
        <div style="width:68px;height:68px;background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);border-radius:20px;display:inline-flex;align-items:center;justify-content:center;color:#EF4444;margin-bottom:18px;">
          <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        </div>

        <h1 style="color:#FFF;font-size:22px;font-weight:900;margin:0 0 8px 0;">
          Sertifikat Tidak Ditemukan
        </h1>
        <p style="color:#94A3B8;font-size:13.5px;max-width:440px;margin:0 auto 24px;line-height:1.55;">
          Nomor atau token sertifikat <code style="color:#FFC81A;background:rgba(255,200,26,0.1);padding:3px 8px;border-radius:6px;font-weight:700;">{{ $identifier }}</code> tidak ditemukan atau belum tercatat pada pangkalan data kami.
        </p>

        <a href="{{ route('landing.index') }}" class="btn-verify-primary" style="display:inline-flex;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          Kembali ke Beranda
        </a>
      </div>
    @endif

  </div>
</div>

{{-- Toast Notification --}}
<div id="verify-toast" class="verify-toast">
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
  <span id="verify-toast-text">Tersalin ke papan klip!</span>
</div>

@push('scripts')
<script>
  function showVerifyToast(msg) {
    const toast = document.getElementById('verify-toast');
    const toastText = document.getElementById('verify-toast-text');
    if (!toast) return;
    toastText.textContent = msg || 'Tersalin ke papan klip!';
    toast.classList.add('show');
    setTimeout(() => {
      toast.classList.remove('show');
    }, 2400);
  }

  function copyTextToClipboard(text, successMsg) {
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(text).then(() => {
        showVerifyToast(successMsg);
      }).catch(() => {
        fallbackCopyText(text, successMsg);
      });
    } else {
      fallbackCopyText(text, successMsg);
    }
  }

  function fallbackCopyText(text, successMsg) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.left = "-999999px";
    textArea.style.top = "-999999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
      document.execCommand('copy');
      showVerifyToast(successMsg);
    } catch (err) {
      alert("Gagal menyalin: " + text);
    }
    document.body.removeChild(textArea);
  }

  function copyCertNumber() {
    const el = document.getElementById('cert-number-text');
    if (!el) return;
    const num = el.textContent.trim();
    copyTextToClipboard(num, 'Nomor sertifikat berhasil disalin!');
    const btnLabel = document.getElementById('copy-btn-label');
    if (btnLabel) {
      btnLabel.textContent = 'Disalin!';
      setTimeout(() => { btnLabel.textContent = 'Salin'; }, 2000);
    }
  }

  function shareVerification() {
    const pageUrl = window.location.href;
    const certNum = document.getElementById('cert-number-text') ? document.getElementById('cert-number-text').textContent.trim() : '';
    const shareData = {
      title: 'Verifikasi Sertifikat Resmi UMI - ' + certNum,
      text: 'Pemeriksaan keabsahan sertifikat ' + certNum + ' dari FIKOM Certification Center UMI:',
      url: pageUrl
    };

    if (navigator.share) {
      navigator.share(shareData).catch(() => {});
    } else {
      copyTextToClipboard(pageUrl, 'Tautan verifikasi berhasil disalin!');
    }
  }

  // Real-time Top Offset Calculation to ensure content is never covered by ticker
  function adjustVerifyTopOffset() {
    const ticker = document.getElementById('fcc-ticker');
    const wrapper = document.querySelector('.verify-page-wrapper');
    if (!wrapper) return;
    const isTickerVisible = ticker && window.getComputedStyle(ticker).display !== 'none';
    const tickerH = isTickerVisible ? ticker.offsetHeight : 0;
    const extraGap = window.innerWidth <= 640 ? 28 : 34;
    wrapper.style.paddingTop = (tickerH + extraGap) + 'px';
  }
  document.addEventListener('DOMContentLoaded', adjustVerifyTopOffset);
  window.addEventListener('resize', adjustVerifyTopOffset);
  const tickerCloseBtn = document.querySelector('#fcc-ticker button');
  if (tickerCloseBtn) {
    tickerCloseBtn.addEventListener('click', () => {
      setTimeout(adjustVerifyTopOffset, 50);
    });
  }
</script>
@endpush
@endsection
