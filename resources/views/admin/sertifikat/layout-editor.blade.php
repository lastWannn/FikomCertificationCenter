@extends('layouts.admin')
@section('title', 'Editor Layout Sertifikat - ' . $kegiatan->judul)
@section('page-title', 'Studio Editor Layout Sertifikat')
@section('page-breadcrumb', 'Sertifikat / Layout Editor / ' . $kegiatan->judul)

@section('page-content')
<style>
  @font-face { font-family: 'Great Vibes'; src: url('{{ asset("fonts/great_vibes.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Alex Brush'; src: url('{{ asset("fonts/alex_brush.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Allura'; src: url('{{ asset("fonts/allura.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Dancing Script'; src: url('{{ asset("fonts/dancing_script.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Cinzel'; src: url('{{ asset("fonts/cinzel.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Playfair Display'; src: url('{{ asset("fonts/playfair_display.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Poppins'; src: url('{{ asset("fonts/poppins.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Montserrat'; src: url('{{ asset("fonts/montserrat.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Roboto'; src: url('{{ asset("fonts/roboto.ttf") }}') format('truetype'); }
  @font-face { font-family: 'Inter'; src: url('{{ asset("fonts/inter.ttf") }}') format('truetype'); }
  @import url('https://fonts.googleapis.com/css2?family=Alex+Brush&family=Allura&family=Cinzel:wght@600;800;900&family=Dancing+Script:wght@700&family=Great+Vibes&family=Inter:wght@500;700;900&family=Montserrat:wght@600;800;900&family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Poppins:wght@400;500;600;700;800;900&family=Roboto:wght@500;700;900&display=swap');

  /* ═══ STUDIO WRAPPER & GRID ══════════════════════════════════ */
  .editor-wrapper {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 24px;
    align-items: start;
  }
  @media (max-width: 1180px) {
    .editor-wrapper {
      grid-template-columns: 1fr;
    }
  }

  /* Header Banner */
  .editor-header-card {
    background: #131218;
    border: 1px solid rgba(255, 200, 26, 0.18);
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }

  /* Studio Canvas Environment */
  .canvas-card {
    background: #0D0C11;
    background-image: 
      radial-gradient(rgba(255, 200, 26, 0.08) 1px, transparent 1px),
      linear-gradient(to right, rgba(255,255,255,0.02) 1px, transparent 1px),
      linear-gradient(to bottom, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 20px 20px, 40px 40px, 40px 40px;
    border: 1px solid rgba(255, 200, 26, 0.15);
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    overflow: hidden;
  }

  .canvas-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    max-width: 760px;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    flex-wrap: wrap;
    gap: 12px;
  }

  .canvas-hud {
    background: rgba(255, 200, 26, 0.08);
    border: 1px solid rgba(255, 200, 26, 0.25);
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 700;
    color: #FFC81A;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .canvas-wrapper-outer {
    width: 100%;
    max-width: 760px;
    margin: 0 auto;
    position: relative;
    aspect-ratio: 297 / 210;
    transition: max-width .25s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Aspect Ratio A4 Landscape 297mm x 210mm = 1.41428 */
  .cert-canvas-container {
    position: relative;
    position: absolute;
    top: 0;
    left: 0;
    width: 297mm;
    height: 210mm;
    transform-origin: top left;
    background: #FFFFFF;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
    user-select: none;
  }

  /* Match object-fit cover with DomPDF / Cetak PDF */
  .cert-bg-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    background: #FFFFFF;
    pointer-events: none;
    z-index: 0;
  }

  /* Center alignment vertical guide line */
  .center-guide-line {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 1px;
    border-left: 1px dashed rgba(239, 68, 68, 0.45);
    z-index: 1;
    pointer-events: none;
    display: none;
  }

  .cert-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
  }

  /* Draggable Element Boxes - Minimalist non-intrusive outline */
  .drag-element {
    position: absolute;
    cursor: grab;
    border: 1px dashed transparent;
    border-radius: 4px;
    padding: 0;
    transition: border-color .15s, box-shadow .15s, background .15s;
    box-sizing: border-box;
  }

  .drag-element:hover {
    border-color: rgba(255, 200, 26, 0.6);
    background: rgba(255, 200, 26, 0.05);
  }

  .drag-element.active {
    border: 1.5px solid #FFC81A;
    background: rgba(255, 200, 26, 0.08);
    box-shadow: 0 0 14px rgba(255, 200, 26, 0.35);
    cursor: grabbing;
  }

  /* Corner Handles for active drag-element */
  .drag-element.active::before,
  .drag-element.active::after {
    content: '';
    position: absolute;
    width: 6px;
    height: 6px;
    background: #FFC81A;
    border-radius: 50%;
    box-shadow: 0 0 4px rgba(0,0,0,0.5);
  }
  .drag-element.active::before { top: -3px; left: -3px; }
  .drag-element.active::after { bottom: -3px; right: -3px; }

  /* Badges are HIDDEN by default and when selected, so they don't block text */
  .drag-badge {
    position: absolute;
    top: -16px;
    left: 50%;
    transform: translateX(-50%);
    background: #FFC81A;
    color: #131218;
    font-size: 9px;
    font-weight: 900;
    padding: 1px 6px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: .4px;
    pointer-events: none;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    white-space: nowrap;
    z-index: 20;
    opacity: 0;
    visibility: hidden;
    transition: opacity .15s ease, visibility .15s ease;
  }

  /* Show badge ONLY when element is being hovered (di-sorot) */
  .drag-element:hover .drag-badge {
    opacity: 1;
    visibility: visible;
  }

  /* Badge Mode Overrides */
  .cert-canvas-container.show-all-badges .drag-badge {
    opacity: 1 !important;
    visibility: visible !important;
  }

  .cert-canvas-container.hide-all-badges .drag-badge {
    opacity: 0 !important;
    visibility: hidden !important;
  }

  /* Zoom Control Buttons */
  .zoom-btn {
    padding: 5px 12px;
    font-size: 11.5px;
    font-weight: 800;
    background: rgba(255,255,255,0.06);
    color: rgba(255,255,255,0.7);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 20px;
    cursor: pointer;
    transition: all .18s ease;
  }
  .zoom-btn.active, .zoom-btn:hover {
    background: #FFC81A;
    color: #131218;
    border-color: #FFC81A;
  }

  /* ═══ CONTROL PANEL CARDS ════════════════════════════════════ */
  .control-card {
    background: #FFFFFF;
    border: 1px solid #E2E4EB;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  }

  .ctrl-group {
    margin-bottom: 18px;
  }
  .ctrl-label {
    font-size: 12px;
    font-weight: 800;
    color: #475569;
    margin-bottom: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  /* Nudge D-Pad Buttons */
  .nudge-btn {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    border: 1.5px solid #CBD5E1;
    background: #F8FAFC;
    color: #131218;
    font-size: 15px;
    font-weight: 900;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .15s cubic-bezier(0.4, 0, 0.2, 1);
    user-select: none;
  }
  .nudge-btn:hover {
    background: #FFC81A;
    border-color: #131218;
    transform: scale(1.06);
    box-shadow: 0 4px 12px rgba(255, 200, 26, 0.35);
  }
  .nudge-btn:active {
    transform: scale(0.95);
  }

  /* Step selector pills */
  .step-pill {
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 800;
    border-radius: 14px;
    border: 1px solid #CBD5E1;
    background: #F8FAFC;
    color: #64748B;
    cursor: pointer;
    transition: all .15s;
  }
  .step-pill.active {
    background: #131218;
    color: #FFC81A;
    border-color: #131218;
  }

  /* Custom Toast Container */
  #fcc-toast-container {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 10000;
    display: flex;
    flex-direction: column;
    gap: 10px;
    pointer-events: none;
  }
  .fcc-toast {
    background: #131218;
    color: #FFF;
    border: 1px solid rgba(255, 200, 26, 0.3);
    padding: 12px 20px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    font-size: 13px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: toastIn .25s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: auto;
  }
  @keyframes toastIn {
    from { opacity: 0; transform: translateY(20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
  }

  .cert-overlay #text-title,
  .cert-overlay #text-label,
  .cert-overlay #text-name,
  .cert-overlay #text-date,
  .cert-overlay #sig1-name,
  .cert-overlay #sig1-role,
  .cert-overlay #sig2-name,
  .cert-overlay #sig2-role {
    line-height: 1 !important;
    white-space: nowrap !important;
  }

  .cert-overlay #sig1-role,
  .cert-overlay #sig2-role {
    margin-top: 0 !important;
  }

  .cert-overlay #text-desc-line1,
  .cert-overlay #text-desc-title,
  .cert-overlay #text-desc-line2,
  .cert-overlay #text-desc-date {
    line-height: var(--desc-line-height, 0.9) !important;
    white-space: nowrap !important;
    margin-top: 0 !important;
  }

  .cert-overlay #text-desc-line1,
  .cert-overlay #text-desc-title,
  .cert-overlay #text-desc-line2 {
    margin-bottom: var(--desc-line-gap, 0mm) !important;
  }
</style>

<div style="padding: 24px;">

  {{-- ═══ HEADER BANNER ═════════════════════════════════════════ --}}
  <div class="editor-header-card">
    <div style="display:flex;align-items:center;gap:14px;">
      <a href="{{ route('admin.sertifikat.index') }}" class="fcc-btn-outline-light" style="padding:8px 14px;font-size:12.5px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali
      </a>
      <div>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:2px;">
          <span style="background:rgba(255,200,26,0.15);color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;text-transform:uppercase;letter-spacing:0.5px;">
            STUDIO LAYOUT EDITOR
          </span>
          <span style="color:rgba(255,255,255,0.4);font-size:12px;">•</span>
          <span style="color:rgba(255,255,255,0.7);font-size:12px;font-weight:600;">
            {{ $kegiatan->judul }}
          </span>
        </div>
        <h2 style="font-size:20px;font-weight:900;color:#FFF;margin:0;letter-spacing:-0.3px;">
          Atur Koordinat Posisi Teks Sertifikat
        </h2>
      </div>
    </div>

    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
      <button type="button" onclick="openCopyLayoutModal()" class="fcc-btn-outline-light" style="padding:9.5px 18px;font-size:13px;background:rgba(255,200,26,0.12);border:1.5px solid rgba(255,200,26,0.35);color:#FFC81A;display:inline-flex;align-items:center;gap:6px;transition:all .15s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='rgba(255,200,26,0.12)';this.style.color='#FFC81A';">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
        Salin Layout Kegiatan Lain
      </button>

      <a href="{{ route('admin.sertifikat.preview-sample', $kegiatan->id) }}" target="_blank" class="fcc-btn-outline-light" style="padding:9.5px 18px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        Live PDF Sample
      </a>

      <button onclick="resetToDefault()" class="fcc-btn-outline-light" style="padding:9.5px 18px;font-size:13px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
        Reset Standar
      </button>

      <button onclick="saveLayout()" id="btn-save-layout" class="fcc-btn-gold" style="padding:9.5px 22px;font-size:13px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Simpan Koordinat
      </button>
    </div>
  </div>

  {{-- ═══ MAIN STUDIO GRID ═══════════════════════════════════════ --}}
  <div class="editor-wrapper">

    {{-- LEFT CANVAS AREA --}}
    <div class="canvas-card">
      <div class="canvas-toolbar">
        <div style="display:flex;align-items:center;gap:10px;">
          <span style="font-size:12px;font-weight:800;color:#FFC81A;display:flex;align-items:center;gap:6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
            A4 LANDSCAPE (297 × 210 mm)
          </span>

          {{-- Label visibility mode switch --}}
          <button onclick="cycleBadgeMode()" id="btn-badge-toggle" style="background:rgba(255,200,26,0.12);border:1px solid rgba(255,200,26,0.3);color:#FFC81A;font-size:11px;font-weight:700;padding:4px 10px;border-radius:14px;cursor:pointer;transition:all .15s;">
            🏷️ Label: Saat Disorot
          </button>

          <button onclick="toggleCenterGuide()" id="btn-guide-toggle" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:rgba(255,255,255,0.7);font-size:11px;font-weight:700;padding:4px 10px;border-radius:14px;cursor:pointer;transition:all .15s;">
            Garis Tengah: OFF
          </button>
        </div>

        <div style="display:flex;align-items:center;gap:12px;">
          <div class="canvas-hud" id="hud-display">
            <span>ELEMEN: <strong id="hud-name" style="color:#FFF;">1. JUDUL</strong></span>
            <span>|</span>
            <span>TOP: <strong id="hud-top" style="color:#FFF;">40 mm</strong></span>
            <span id="hud-offset-wrapper" style="display:none;">| <span id="hud-offset-label">RIGHT</span>: <strong id="hud-offset-val" style="color:#FFF;">46 mm</strong></span>
            <span>|</span>
            <span>FONT: <strong id="hud-font" style="color:#FFF;">32 pt</strong></span>
          </div>

          <div style="display:flex;align-items:center;gap:4px;">
            <button class="zoom-btn" onclick="setCanvasZoom('620px', this)">620px</button>
            <button class="zoom-btn active" onclick="setCanvasZoom('760px', this)">760px</button>
            <button class="zoom-btn" onclick="setCanvasZoom('880px', this)">880px</button>
          </div>
        </div>
      </div>

      <div class="canvas-wrapper-outer" id="canvas-outer">
        <div class="cert-canvas-container" id="cert-canvas">
          
          {{-- Center alignment dashed guide line --}}
          <div class="center-guide-line" id="center-guide"></div>

          @if($bgSrc)
            <img src="{{ $bgSrc }}" class="cert-bg-img" alt="Background Template">
          @else
            <div class="cert-bg-img" style="background:#FFF;"></div>
          @endif

          <div class="cert-overlay" id="canvas-overlay">

            {{-- 1. TITLE (SERTIFIKAT) --}}
            <div class="drag-element" id="el-title" onclick="selectElement('title')" style="width:100%;text-align:center;">
              <div class="drag-badge" id="badge-title">1. Judul</div>
              <div id="text-title" style="font-family:'Times New Roman', Georgia, serif;font-weight:bold;letter-spacing:5px;color:#000;text-transform:uppercase;line-height:1;">
                SERTIFIKAT
              </div>
            </div>

            {{-- 2. SUBTITLE (PENGHARGAAN) --}}
            <div class="drag-element" id="el-subtitle" onclick="selectElement('subtitle')" style="width:100%;text-align:center;">
              <div class="drag-badge" id="badge-subtitle">2. Sub-Judul</div>
              <div id="text-subtitle" style="font-family:'Montserrat', Arial, sans-serif;font-weight:900;letter-spacing:6px;color:#B45309;text-transform:uppercase;line-height:1;">
                PENGHARGAAN
              </div>
            </div>

            {{-- 2. LABEL (DIBERIKAN KEPADA) --}}
            <div class="drag-element" id="el-label" onclick="selectElement('label')" style="width:100%;text-align:center;">
              <div class="drag-badge" id="badge-label">2. Label Subtitle</div>
              <div id="text-label" style="font-family:Arial, Helvetica, sans-serif;font-weight:800;letter-spacing:1px;color:#333;text-transform:uppercase;">
                DIBERIKAN KEPADA
              </div>
            </div>

            {{-- 3. NAME (NAMA PESERTA) --}}
            <div class="drag-element" id="el-name" onclick="selectElement('name')" style="width:100%;text-align:center;">
              <div class="drag-badge" id="badge-name">3. Nama Peserta</div>
              <div id="text-name" style="font-family:'Great Vibes', 'Brush Script MT', cursive, serif;color:#0F172A;line-height:1.1;">
                {{ $dummySertifikat->pendaftaran->peserta->nama ?? 'M. Rizwan.' }}
              </div>
            </div>

            {{-- 4. DESC (DESKRIPSI KEGIATAN) --}}
            <div class="drag-element" id="el-desc" onclick="selectElement('desc')" style="width:100%;text-align:center;">
              <div class="drag-badge" id="badge-desc">4. Deskripsi &amp; Kegiatan</div>
              <div id="text-desc-line1" style="font-family:Arial, Helvetica, sans-serif;color:#475569;font-weight:500;">
                atas partisipasi sebagai peserta dalam kegiatan
              </div>
              <div id="text-desc-title" style="font-family:Arial, Helvetica, sans-serif;font-weight:900;color:#B45309;">
                “{{ $kegiatan->judul }}”
              </div>
              <div id="text-desc-line2" style="font-family:Arial, Helvetica, sans-serif;color:#475569;font-weight:500;">
                yang dilaksanakan pada
              </div>
              <div id="text-desc-date" style="font-family:Arial, Helvetica, sans-serif;font-weight:800;color:#0F172A;">
                {{ $kegiatan->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? '12 September 2026' }}
              </div>
            </div>

            {{-- 5. DATE (LOKASI & TANGGAL TERBIT) --}}
            <div class="drag-element" id="el-date" onclick="selectElement('date')" style="text-align:center;">
              <div class="drag-badge" id="badge-date">5. Lokasi &amp; Tgl</div>
              <div id="text-date" style="font-family:Arial, Helvetica, sans-serif;font-weight:700;color:#0F172A;line-height:1.35;">
                Makassar,<br>
                <strong>12 September 2026</strong>
              </div>
            </div>

            @php
              $editorTtd = \App\Models\TandaTangan::getAktif();
            @endphp
            {{-- 6. SIG 1 (DEKAN - KIRI) --}}
            <div class="drag-element" id="el-sig1" onclick="selectElement('sig1')" style="text-align:center;">
              <div class="drag-badge" id="badge-sig1">6. Dekan (Kiri)</div>
              <div style="height: 44px; display: flex; align-items: flex-end; justify-content: center; margin-bottom: 4px;">
                @if($editorTtd->dekan_ttd_url)
                  <img src="{{ $editorTtd->dekan_ttd_url }}" style="height: 42px; max-width: 100%; object-fit: contain; pointer-events: none;">
                @else
                  <div style="font-size: 10px; font-style: italic; color: #94A3B8; border: 1px dashed #CBD5E1; padding: 2px 10px; border-radius: 4px; background: rgba(241,245,249,0.7); pointer-events: none;">
                    [ Tanda Tangan Dekan ]
                  </div>
                @endif
              </div>
              <div style="font-family:Arial, Helvetica, sans-serif;font-weight:900;color:#0F172A;" id="sig1-name">{{ $editorTtd->dekan_nama }}</div>
              <div style="font-family:Arial, Helvetica, sans-serif;font-weight:900;color:#B45309;letter-spacing:1.5px;margin-top:1px;" id="sig1-role">{{ $editorTtd->dekan_jabatan }}</div>
            </div>

            {{-- 7. SIG 2 (KETUA UNIT - KANAN) --}}
            <div class="drag-element" id="el-sig2" onclick="selectElement('sig2')" style="text-align:center;">
              <div class="drag-badge" id="badge-sig2">7. Ketua Unit (Kanan)</div>
              <div style="height: 44px; display: flex; align-items: flex-end; justify-content: center; margin-bottom: 4px;">
                @if($editorTtd->ketua_ttd_url)
                  <img src="{{ $editorTtd->ketua_ttd_url }}" style="height: 42px; max-width: 100%; object-fit: contain; pointer-events: none;">
                @else
                  <div style="font-size: 10px; font-style: italic; color: #94A3B8; border: 1px dashed #CBD5E1; padding: 2px 10px; border-radius: 4px; background: rgba(241,245,249,0.7); pointer-events: none;">
                    [ Tanda Tangan Ketua ]
                  </div>
                @endif
              </div>
              <div style="font-family:Arial, Helvetica, sans-serif;font-weight:900;color:#0F172A;" id="sig2-name">{{ $editorTtd->ketua_nama }}</div>
              <div style="font-family:Arial, Helvetica, sans-serif;font-weight:900;color:#B45309;letter-spacing:1.5px;margin-top:1px;" id="sig2-role">{{ $editorTtd->ketua_jabatan }}</div>
            </div>

          </div>
        </div>
      </div>
    </div>

    {{-- RIGHT CONTROL PANEL --}}
    <div class="control-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;padding-bottom:12px;border-bottom:1.5px solid #F1F5F9;">
        <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0;display:flex;align-items:center;gap:8px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          Panel Pengaturan Teks
        </h3>
        <span style="font-size:10.5px;font-weight:800;color:#64748B;background:#F1F5F9;padding:2px 8px;border-radius:10px;">PRO</span>
      </div>

      {{-- 1. SELECT ELEMENT --}}
      <div class="ctrl-group">
        <label class="ctrl-label">Pilih Elemen Teks Active</label>
        <select id="select-element" onchange="selectElement(this.value)" class="fcc-input" style="width:100%;background:#F8FAFC;font-size:13px;font-weight:800;border-color:#CBD5E1;">
          <option value="title">1. Judul Sertifikat (SERTIFIKAT)</option>
          <option value="subtitle">2. Sub-Judul (PENGHARGAAN)</option>
          <option value="label">3. Label Subtitle (DIBERIKAN KEPADA)</option>
          <option value="name">4. Nama Peserta Penerima</option>
          <option value="desc">5. Deskripsi &amp; Nama Kegiatan</option>
          <option value="date">6. Lokasi &amp; Tanggal Terbit</option>
          <option value="sig1">7. Tanda Tangan Kiri (Dekan)</option>
          <option value="sig2">8. Tanda Tangan Kanan (Ketua Unit)</option>
        </select>
      </div>

      {{-- FONT FAMILY SELECTOR --}}
      <div class="ctrl-group">
        <label class="ctrl-label">Gaya Font (Font Family)</label>
        <select id="select-font-family" onchange="updateActiveElementFromInputs()" class="fcc-input" style="width:100%;background:#F8FAFC;font-size:13px;font-weight:800;border-color:#CBD5E1;">
          <optgroup label="Kaligrafi / Cursive (Sertifikat & Nama)">
            <option value="Great Vibes">Great Vibes (Kaligrafi Klasik)</option>
            <option value="Allura">Allura (Kaligrafi Handdrawn)</option>
            <option value="Alex Brush">Alex Brush (Kaligrafi Elegan)</option>
            <option value="Dancing Script">Dancing Script (Kaligrafi Casual)</option>
          </optgroup>
          <optgroup label="Serif (Formal & Mewah)">
            <option value="Times New Roman">Times New Roman (Formal Standard)</option>
            <option value="Georgia">Georgia (Serif Anggun)</option>
            <option value="Cinzel">Cinzel (Luxury / Sertifikat Resmi)</option>
            <option value="Playfair Display">Playfair Display (Serif Modern)</option>
          </optgroup>
          <optgroup label="Sans-Serif (Modern & Bersih)">
            <option value="Poppins">Poppins (Modern Geometric)</option>
            <option value="Arial">Arial (Standard Clean)</option>
            <option value="Inter">Inter (Modern Clean)</option>
            <option value="Montserrat">Montserrat (Modern Bold)</option>
            <option value="Roboto">Roboto (Universal Clean)</option>
          </optgroup>
        </select>
      </div>

      {{-- 2. TOP SLIDER + NUMBER INPUT --}}
      <div class="ctrl-group">
        <div class="ctrl-label">
          <span>Posisi Vertikal (Top Y)</span>
          <div style="display:flex;align-items:center;gap:4px;">
            <input type="number" id="num-top" min="0" max="195" step="0.5" onchange="onNumInputChange('top', this.value)" style="width:64px;padding:2px 6px;font-size:11.5px;font-weight:900;color:#B45309;background:#FEF3C7;border:1px solid #FDE68A;border-radius:6px;text-align:right;">
            <span style="font-size:11px;font-weight:800;color:#B45309;">mm</span>
          </div>
        </div>
        <input type="range" id="input-top" min="0" max="195" step="0.5" oninput="updateActiveElementFromInputs()" style="width:100%;accent-color:#FFC81A;">
      </div>

      {{-- 3. OFFSET SLIDER + NUMBER INPUT --}}
      <div class="ctrl-group" id="group-offset">
        <div class="ctrl-label">
          <span id="label-offset-name">Posisi Horizontal</span>
          <div style="display:flex;align-items:center;gap:4px;">
            <button id="btn-center-offset" onclick="resetCenterOffset()" style="display:none;background:#F1F5F9;border:1px solid #CBD5E1;color:#475569;font-size:10px;font-weight:800;padding:1px 6px;border-radius:4px;cursor:pointer;" title="Kembalikan ke posisi pas di tengah">🎯 Rata Tengah</button>
            <input type="number" id="num-offset" min="-100" max="220" step="0.5" onchange="onNumInputChange('offset', this.value)" style="width:64px;padding:2px 6px;font-size:11.5px;font-weight:900;color:#B45309;background:#FEF3C7;border:1px solid #FDE68A;border-radius:6px;text-align:right;">
            <span style="font-size:11px;font-weight:800;color:#B45309;">mm</span>
          </div>
        </div>
        <input type="range" id="input-offset" min="-100" max="220" step="0.5" oninput="updateActiveElementFromInputs()" style="width:100%;accent-color:#FFC81A;">
      </div>

      {{-- 4. FONT SIZE SLIDER + NUMBER INPUT --}}
      <div class="ctrl-group">
        <div class="ctrl-label">
          <span>Ukuran Font Utama</span>
          <div style="display:flex;align-items:center;gap:4px;">
            <input type="number" id="num-font" min="6" max="60" step="0.5" onchange="onNumInputChange('font', this.value)" style="width:64px;padding:2px 6px;font-size:11.5px;font-weight:900;color:#B45309;background:#FEF3C7;border:1px solid #FDE68A;border-radius:6px;text-align:right;">
            <span style="font-size:11px;font-weight:800;color:#B45309;">pt</span>
          </div>
        </div>
        <input type="range" id="input-font" min="6" max="60" step="0.5" oninput="updateActiveElementFromInputs()" style="width:100%;accent-color:#FFC81A;">
      </div>



      {{-- 5. TITLE FONT SIZE FOR DESC --}}
      <div class="ctrl-group" id="group-title-font" style="display:none;">
        <div class="ctrl-label">
          <span>Ukuran Font Judul Kegiatan</span>
          <div style="display:flex;align-items:center;gap:4px;">
            <input type="number" id="num-title-font" min="8" max="30" step="0.5" onchange="onNumInputChange('title_font', this.value)" style="width:64px;padding:2px 6px;font-size:11.5px;font-weight:900;color:#B45309;background:#FEF3C7;border:1px solid #FDE68A;border-radius:6px;text-align:right;">
            <span style="font-size:11px;font-weight:800;color:#B45309;">pt</span>
          </div>
        </div>
        <input type="range" id="input-title-font" min="8" max="30" step="0.5" oninput="updateActiveElementFromInputs()" style="width:100%;accent-color:#FFC81A;">
      </div>

      <div class="ctrl-group" id="group-line-height" style="display:none;">
        <div class="ctrl-label">
          <span>Jarak Spasi Antarbaris</span>
          <div style="display:flex;align-items:center;gap:4px;">
            <input type="number" id="num-line-height" min="0" max="15" step="0.5" onchange="onNumInputChange('line_gap', this.value)" style="width:64px;padding:2px 6px;font-size:11.5px;font-weight:900;color:#B45309;background:#FEF3C7;border:1px solid #FDE68A;border-radius:6px;text-align:right;">
            <span style="font-size:11px;font-weight:800;color:#B45309;">mm</span>
          </div>
        </div>
        <input type="range" id="input-line-height" min="0" max="15" step="0.5" oninput="updateActiveElementFromInputs()" style="width:100%;accent-color:#FFC81A;">
      </div>
    </div>

  </div>
</div>

{{-- Toast Container --}}
<div id="fcc-toast-container"></div>

<script>
  const defaultLayout = {
    title:    { top: 36, left: 0, font_size: 32, font_family: 'Times New Roman' },
    subtitle: { top: 48, left: 0, font_size: 11, font_family: 'Montserrat' },
    label:    { top: 63, left: 0, font_size: 8.5, font_family: 'Arial' },
    name:     { top: 71, left: 0, font_size: 36, font_family: 'Allura' },
    desc:     { top: 109, left: 0, font_size: 10, title_font_size: 14, line_height: 0.9, line_gap: 0, font_family: 'Poppins' },
    date:     { top: 146, right: 46, font_size: 9.5, font_family: 'Arial' },
    sig1:     { top: 167.5, left: 60, font_size: 10, font_family: 'Arial' },
    sig2:     { top: 167.5, right: 46, font_size: 10, font_family: 'Arial' }
  };

  let currentLayout = JSON.parse(JSON.stringify(@json($layout))) || defaultLayout;
  if (!currentLayout.title)    currentLayout.title    = { top: 36, left: 0, font_size: 32, font_family: 'Times New Roman' };
  if (!currentLayout.subtitle) currentLayout.subtitle = { top: 48, left: 0, font_size: 11, font_family: 'Montserrat' };
  if (!currentLayout.label)    currentLayout.label    = { top: 63, left: 0, font_size: 8.5, font_family: 'Arial' };
  if (!currentLayout.name)     currentLayout.name     = { top: 71, left: 0, font_size: 36, font_family: 'Allura' };
  if (!currentLayout.desc)     currentLayout.desc     = { top: 109, left: 0, font_size: 10, title_font_size: 14, line_height: 0.9, line_gap: 0, font_family: 'Poppins' };
  if (!currentLayout.desc.line_height) currentLayout.desc.line_height = 0.9;
  if (currentLayout.desc.line_gap === undefined || currentLayout.desc.line_gap < 0) currentLayout.desc.line_gap = 0;
  if (!currentLayout.sig1)     currentLayout.sig1     = { top: 167.5, left: 60, font_size: 10, font_family: 'Arial' };
  if (!currentLayout.sig2)     currentLayout.sig2     = { top: 167.5, right: 46, font_size: 10, font_family: 'Arial' };

  let activeElementKey = 'title';
  let currentStep = 0.5;
  let showGuide = false;
  let badgeMode = 'auto'; // 'auto', 'all', 'none'

  const TOTAL_HEIGHT_MM = 210;
  const TOTAL_WIDTH_MM = 297;

  const elementNames = {
    title:    '1. JUDUL (SERTIFIKAT)',
    subtitle: '2. SUB-JUDUL (PENGHARGAAN)',
    label:    '3. LABEL SUBTITLE',
    name:     '4. NAMA PESERTA',
    desc:     '5. DESKRIPSI & KEGIATAN',
    date:     '6. LOKASI & TANGGAL',
    sig1:     '7. DEKAN (KIRI)',
    sig2:     '8. KETUA UNIT (KANAN)'
  };

  function getFontCss(fontName) {
    if (fontName === 'Great Vibes') return "'Great Vibes', 'Brush Script MT', cursive, serif";
    if (fontName === 'Allura') return "'Allura', 'Great Vibes', cursive, serif";
    if (fontName === 'Alex Brush') return "'Alex Brush', 'Brush Script MT', cursive, serif";
    if (fontName === 'Dancing Script') return "'Dancing Script', cursive, serif";
    if (fontName === 'Cinzel') return "'Cinzel', Georgia, serif";
    if (fontName === 'Playfair Display') return "'Playfair Display', Georgia, serif";
    if (fontName === 'Times New Roman') return "'Times New Roman', Georgia, serif";
    if (fontName === 'Georgia') return "Georgia, 'Times New Roman', serif";
    if (fontName === 'Poppins') return "'Poppins', Arial, sans-serif";
    if (fontName === 'Montserrat') return "'Montserrat', Arial, sans-serif";
    if (fontName === 'Roboto') return "'Roboto', Arial, sans-serif";
    if (fontName === 'Inter') return "'Inter', Arial, sans-serif";
    return "Arial, Helvetica, sans-serif";
  }

  function getDefaultFontForKey(key) {
    if (key === 'title') return 'Times New Roman';
    if (key === 'name') return 'Allura';
    if (key === 'desc') return 'Poppins';
    return 'Arial';
  }

  function showToast(msg, type = 'success') {
    const container = document.getElementById('fcc-toast-container');
    const toast = document.createElement('div');
    toast.className = 'fcc-toast';
    const icon = type === 'success' 
      ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
      : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>';
    toast.innerHTML = `${icon} <span>${msg}</span>`;
    container.appendChild(toast);
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(10px)';
      toast.style.transition = 'all .25s ease';
      setTimeout(() => toast.remove(), 250);
    }, 3200);
  }

  function cycleBadgeMode() {
    const container = document.getElementById('cert-canvas');
    const btn = document.getElementById('btn-badge-toggle');
    container.classList.remove('show-all-badges', 'hide-all-badges');

    if (badgeMode === 'auto') {
      badgeMode = 'all';
      container.classList.add('show-all-badges');
      btn.textContent = '🏷️ Label: Tampilkan Semua';
    } else if (badgeMode === 'all') {
      badgeMode = 'none';
      container.classList.add('hide-all-badges');
      btn.textContent = '🏷️ Label: Sembunyikan Semua';
    } else {
      badgeMode = 'auto';
      btn.textContent = '🏷️ Label: Saat Disorot';
    }
  }

  function toggleCenterGuide() {
    showGuide = !showGuide;
    const guide = document.getElementById('center-guide');
    const btn = document.getElementById('btn-guide-toggle');
    if (showGuide) {
      guide.style.display = 'block';
      btn.textContent = 'Garis Tengah: ON';
      btn.style.background = '#FFC81A';
      btn.style.color = '#131218';
      btn.style.borderColor = '#FFC81A';
    } else {
      guide.style.display = 'none';
      btn.textContent = 'Garis Tengah: OFF';
      btn.style.background = 'rgba(255,255,255,0.06)';
      btn.style.color = 'rgba(255,255,255,0.7)';
      btn.style.borderColor = 'rgba(255,255,255,0.12)';
    }
  }

  function setNudgeStep(step) {
    currentStep = step;
    document.querySelectorAll('.step-pill').forEach(el => el.classList.remove('active'));
    const activePill = document.getElementById('step-' + step.toFixed(1));
    if (activePill) activePill.classList.add('active');
  }

  function setCanvasZoom(sizePx, btnEl) {
    document.getElementById('canvas-outer').style.maxWidth = sizePx;
    document.querySelectorAll('.zoom-btn').forEach(b => b.classList.remove('active'));
    btnEl.classList.add('active');
    setTimeout(renderLayoutOnCanvas, 120);
  }

  function renderLayoutOnCanvas() {
    const canvas = document.getElementById('cert-canvas');
    if (!canvas) return;

    const viewport = canvas.parentElement;
    const cssPxPerMm = 96 / 25.4;
    const canvasScale = viewport.clientWidth / (TOTAL_WIDTH_MM * cssPxPerMm);
    canvas.style.transform = `scale(${canvasScale})`;

    // 1. Title
    const titleEl = document.getElementById('el-title');
    titleEl.style.top = currentLayout.title.top + 'mm';
    titleEl.style.left = (currentLayout.title.left || 0) + 'mm';
    titleEl.style.width = TOTAL_WIDTH_MM + 'mm';
    titleEl.style.marginLeft = '0px';
    const titleText = document.getElementById('text-title');
    titleText.style.fontSize = currentLayout.title.font_size + 'pt';
    titleText.style.fontFamily = getFontCss(currentLayout.title.font_family || 'Times New Roman');

    // 2. Subtitle (PENGHARGAAN)
    const subtitleEl = document.getElementById('el-subtitle');
    if (subtitleEl) {
      subtitleEl.style.top = (currentLayout.subtitle?.top || 48) + 'mm';
      subtitleEl.style.left = (currentLayout.subtitle?.left || 0) + 'mm';
      subtitleEl.style.width = TOTAL_WIDTH_MM + 'mm';
      subtitleEl.style.marginLeft = '0px';
      const subtitleText = document.getElementById('text-subtitle');
      if (subtitleText) {
        subtitleText.style.fontSize = (currentLayout.subtitle?.font_size || 11) + 'pt';
        subtitleText.style.fontFamily = getFontCss(currentLayout.subtitle?.font_family || 'Montserrat');
      }
    }

    // 2. Label
    const labelEl = document.getElementById('el-label');
    labelEl.style.top = currentLayout.label.top + 'mm';
    labelEl.style.left = (currentLayout.label.left || 0) + 'mm';
    labelEl.style.width = TOTAL_WIDTH_MM + 'mm';
    labelEl.style.marginLeft = '0px';
    const labelText = document.getElementById('text-label');
    labelText.style.fontSize = currentLayout.label.font_size + 'pt';
    labelText.style.fontFamily = getFontCss(currentLayout.label.font_family || 'Arial');

    // 3. Name
    const nameEl = document.getElementById('el-name');
    nameEl.style.top = currentLayout.name.top + 'mm';
    nameEl.style.left = (currentLayout.name.left || 0) + 'mm';
    nameEl.style.width = TOTAL_WIDTH_MM + 'mm';
    nameEl.style.marginLeft = '0px';
    const nameText = document.getElementById('text-name');
    nameText.style.fontSize = currentLayout.name.font_size + 'pt';
    nameText.style.fontFamily = getFontCss(currentLayout.name.font_family || 'Allura');

    // 4. Desc
    const descEl = document.getElementById('el-desc');
    descEl.style.top = currentLayout.desc.top + 'mm';
    descEl.style.left = (currentLayout.desc.left || 0) + 'mm';
    descEl.style.width = TOTAL_WIDTH_MM + 'mm';
    descEl.style.marginLeft = '0px';
    const descFont = getFontCss(currentLayout.desc.font_family || 'Arial');
    const descLineHeight = currentLayout.desc.line_height || 0.9;
    descEl.style.setProperty('--desc-line-height', descLineHeight);
    descEl.style.setProperty('--desc-line-gap', (currentLayout.desc.line_gap || 0) + 'mm');
    document.getElementById('text-desc-line1').style.fontSize = currentLayout.desc.font_size + 'pt';
    document.getElementById('text-desc-line1').style.fontFamily = descFont;
    document.getElementById('text-desc-line2').style.fontSize = currentLayout.desc.font_size + 'pt';
    document.getElementById('text-desc-line2').style.fontFamily = descFont;
    document.getElementById('text-desc-title').style.fontSize = currentLayout.desc.title_font_size + 'pt';
    document.getElementById('text-desc-title').style.fontFamily = descFont;
    document.getElementById('text-desc-date').style.fontSize = '11pt';
    document.getElementById('text-desc-date').style.fontFamily = descFont;

    // 5. Date (matching 68mm width in PDF)
    const dateEl = document.getElementById('el-date');
    dateEl.style.top = currentLayout.date.top + 'mm';
    dateEl.style.right = currentLayout.date.right + 'mm';
    dateEl.style.width = '68mm';
    const dateText = document.getElementById('text-date');
    dateText.style.fontSize = currentLayout.date.font_size + 'pt';
    dateText.style.fontFamily = getFontCss(currentLayout.date.font_family || 'Arial');

    // 6. Sig1 (Dekan Kiri - matching 68mm width in PDF)
    const sig1El = document.getElementById('el-sig1');
    sig1El.style.top = currentLayout.sig1.top + 'mm';
    sig1El.style.left = currentLayout.sig1.left + 'mm';
    sig1El.style.width = '68mm';
    const sig1Font = getFontCss(currentLayout.sig1.font_family || 'Arial');
    const sig1Name = document.getElementById('sig1-name');
    sig1Name.style.fontSize = currentLayout.sig1.font_size + 'pt';
    sig1Name.style.fontFamily = sig1Font;
    const sig1Role = document.getElementById('sig1-role');
    sig1Role.style.fontSize = '8.5pt';
    sig1Role.style.fontFamily = sig1Font;

    // 7. Sig2 (Ketua Unit Kanan - matching 68mm width in PDF)
    const sig2El = document.getElementById('el-sig2');
    sig2El.style.top = currentLayout.sig2.top + 'mm';
    sig2El.style.right = currentLayout.sig2.right + 'mm';
    sig2El.style.width = '68mm';
    const sig2Font = getFontCss(currentLayout.sig2.font_family || 'Arial');
    const sig2Name = document.getElementById('sig2-name');
    sig2Name.style.fontSize = currentLayout.sig2.font_size + 'pt';
    sig2Name.style.fontFamily = sig2Font;
    const sig2Role = document.getElementById('sig2-role');
    sig2Role.style.fontSize = '8.5pt';
    sig2Role.style.fontFamily = sig2Font;

    updateHUD();
  }

  function updateHUD() {
    const data = currentLayout[activeElementKey];
    document.getElementById('hud-name').textContent = elementNames[activeElementKey] || activeElementKey.toUpperCase();
    document.getElementById('hud-top').textContent = data.top + ' mm';
    document.getElementById('hud-font').textContent = data.font_size + ' pt';

    const offsetWrap = document.getElementById('hud-offset-wrapper');
    offsetWrap.style.display = 'inline';

    if (activeElementKey === 'date' || activeElementKey === 'sig2') {
      document.getElementById('hud-offset-label').textContent = 'RIGHT';
      document.getElementById('hud-offset-val').textContent = (data.right || 46) + ' mm';
    } else if (activeElementKey === 'sig1') {
      document.getElementById('hud-offset-label').textContent = 'LEFT';
      document.getElementById('hud-offset-val').textContent = (data.left || 60) + ' mm';
    } else {
      const offX = data.left || 0;
      document.getElementById('hud-offset-label').textContent = 'OFFSET X';
      document.getElementById('hud-offset-val').textContent = (offX === 0 ? '0 mm (Tengah)' : (offX > 0 ? '+' + offX : offX) + ' mm');
    }
  }

  function selectElement(key) {
    activeElementKey = key;
    document.querySelectorAll('.drag-element').forEach(el => el.classList.remove('active'));
    const targetEl = document.getElementById('el-' + key);
    if (targetEl) targetEl.classList.add('active');
    document.getElementById('select-element').value = key;

    const data = currentLayout[key];
    document.getElementById('select-font-family').value = data.font_family || getDefaultFontForKey(key);
    document.getElementById('input-top').value = data.top;
    document.getElementById('num-top').value = data.top;

    document.getElementById('input-font').value = data.font_size;
    document.getElementById('num-font').value = data.font_size;

    const groupOffset = document.getElementById('group-offset');
    const labelOffsetName = document.getElementById('label-offset-name');
    const inputOffset = document.getElementById('input-offset');
    const numOffset = document.getElementById('num-offset');
    const btnCenterOffset = document.getElementById('btn-center-offset');

    groupOffset.style.display = 'block';

    if (key === 'date' || key === 'sig2') {
      labelOffsetName.textContent = 'Posisi Horizontal (Kanan)';
      inputOffset.min = 0; inputOffset.max = 220;
      numOffset.min = 0; numOffset.max = 220;
      const val = data.right || 46;
      inputOffset.value = val;
      numOffset.value = val;
      if (btnCenterOffset) btnCenterOffset.style.display = 'none';
    } else if (key === 'sig1') {
      labelOffsetName.textContent = 'Posisi Horizontal (Kiri)';
      inputOffset.min = 0; inputOffset.max = 220;
      numOffset.min = 0; numOffset.max = 220;
      const val = data.left || 60;
      inputOffset.value = val;
      numOffset.value = val;
      if (btnCenterOffset) btnCenterOffset.style.display = 'none';
    } else {
      labelOffsetName.textContent = 'Geser Horizontal (Offset dari Tengah)';
      inputOffset.min = -100; inputOffset.max = 100;
      numOffset.min = -100; numOffset.max = 100;
      const val = data.left || 0;
      inputOffset.value = val;
      numOffset.value = val;
      if (btnCenterOffset) btnCenterOffset.style.display = 'inline-block';
    }

    const groupTitleFont = document.getElementById('group-title-font');
    const groupLineHeight = document.getElementById('group-line-height');
    if (key === 'desc') {
      groupTitleFont.style.display = 'block';
      if (groupLineHeight) groupLineHeight.style.display = 'block';
      const val = data.title_font_size || 14;
      document.getElementById('input-title-font').value = val;
      document.getElementById('num-title-font').value = val;
      const lineGapVal = data.line_gap || 0;
      document.getElementById('input-line-height').value = lineGapVal;
      document.getElementById('num-line-height').value = lineGapVal;
    } else {
      groupTitleFont.style.display = 'none';
      if (groupLineHeight) groupLineHeight.style.display = 'none';
    }

    updateHUD();
  }

  function resetCenterOffset() {
    currentLayout[activeElementKey].left = 0;
    selectElement(activeElementKey);
    renderLayoutOnCanvas();
    showToast('Elemen ' + elementNames[activeElementKey] + ' berhasil diratakan ke tengah.', 'success');
  }

  function updateActiveElementFromInputs() {
    const data = currentLayout[activeElementKey];
    const topVal = parseFloat(document.getElementById('input-top').value);
    const fontVal = parseFloat(document.getElementById('input-font').value);
    const fontFamVal = document.getElementById('select-font-family').value;

    data.top = topVal;
    data.font_size = fontVal;
    data.font_family = fontFamVal;

    document.getElementById('num-top').value = topVal;
    document.getElementById('num-font').value = fontVal;

    const offsetVal = parseFloat(document.getElementById('input-offset').value);
    if (activeElementKey === 'date' || activeElementKey === 'sig2') {
      data.right = offsetVal;
    } else {
      data.left = offsetVal;
    }
    document.getElementById('num-offset').value = offsetVal;

    if (activeElementKey === 'desc') {
      const titleFontVal = parseFloat(document.getElementById('input-title-font').value);
      data.title_font_size = titleFontVal;
      document.getElementById('num-title-font').value = titleFontVal;

      const lineGapVal = parseFloat(document.getElementById('input-line-height').value);
      data.line_gap = lineGapVal;
      document.getElementById('num-line-height').value = lineGapVal;
      data.line_height = 0.9;
    }

    renderLayoutOnCanvas();
  }

  function onNumInputChange(type, valStr) {
    let val = parseFloat(valStr);
    if (isNaN(val)) return;

    if (type === 'top') {
      document.getElementById('input-top').value = val;
    } else if (type === 'font') {
      document.getElementById('input-font').value = val;
    } else if (type === 'offset') {
      document.getElementById('input-offset').value = val;
    } else if (type === 'title_font') {
      document.getElementById('input-title-font').value = val;
    } else if (type === 'subtitle_font') {
      document.getElementById('input-subtitle-font').value = val;
    } else if (type === 'line_gap') {
      document.getElementById('input-line-height').value = val;
    }
    updateActiveElementFromInputs();
  }

  function nudge(dx, dy) {
    const data = currentLayout[activeElementKey];
    data.top = Math.max(0, Math.min(195, Math.round((data.top + dy) * 10) / 10));

    if (activeElementKey === 'date' || activeElementKey === 'sig2') {
      data.right = Math.max(0, Math.min(220, Math.round(((data.right || 46) - dx) * 10) / 10));
    } else if (activeElementKey === 'sig1') {
      data.left = Math.max(0, Math.min(220, Math.round(((data.left || 60) + dx) * 10) / 10));
    } else {
      data.left = Math.max(-100, Math.min(100, Math.round(((data.left || 0) + dx) * 10) / 10));
    }

    selectElement(activeElementKey);
    renderLayoutOnCanvas();
  }

  function resetToDefault() {
    if (confirm('Apakah Anda yakin ingin mengembalikan seluruh posisi koordinat ke baseline standar?')) {
      currentLayout = JSON.parse(JSON.stringify(defaultLayout));
      selectElement(activeElementKey);
      renderLayoutOnCanvas();
      showToast('Baseline koordinat berhasil di-reset.', 'success');
    }
  }

  function saveLayout() {
    const btn = document.getElementById('btn-save-layout');
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 1 1-10 10" stroke-opacity="1"/></svg> Menyimpan...';

    fetch("{{ route('admin.sertifikat.save-layout', $kegiatan->id) }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ layout: currentLayout })
    })
    .then(res => res.json())
    .then(data => {
      btn.disabled = false;
      btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Simpan Koordinat';
      if (data.success) {
        showToast(data.message, 'success');
      } else {
        showToast('Gagal menyimpan koordinat.', 'error');
      }
    })
    .catch(err => {
      btn.disabled = false;
      btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Simpan Koordinat';
      showToast('Terjadi kesalahan koneksi.', 'error');
    });
  }

  // Mouse Dragging Logic
  let isDragging = false;
  let dragStartY = 0;
  let dragStartX = 0;
  let elementStartTop = 0;
  let elementStartRight = 0;
  let elementStartLeft = 0;

  function initMouseDrag() {
    document.querySelectorAll('.drag-element').forEach(el => {
      el.addEventListener('mousedown', (e) => {
        isDragging = true;
        const key = el.id.replace('el-', '');
        selectElement(key);

        dragStartY = e.clientY;
        dragStartX = e.clientX;
        elementStartTop = currentLayout[key].top;
        elementStartRight = currentLayout[key].right || 46;
        elementStartLeft = currentLayout[key].left || 0;

        el.classList.add('active');
        e.preventDefault();
      });
    });

    document.addEventListener('mousemove', (e) => {
      if (!isDragging) return;
      const canvas = document.getElementById('cert-canvas');
      const canvasRect = canvas.getBoundingClientRect();
      const mmToPxY = canvasRect.height / TOTAL_HEIGHT_MM;
      const mmToPxX = canvasRect.width / TOTAL_WIDTH_MM;

      const deltaYPx = e.clientY - dragStartY;
      const deltaXPx = e.clientX - dragStartX;

      const deltaYMm = deltaYPx / mmToPxY;
      const deltaXMm = deltaXPx / mmToPxX;

      const data = currentLayout[activeElementKey];
      data.top = Math.max(0, Math.min(195, Math.round((elementStartTop + deltaYMm) * 10) / 10));

      if (activeElementKey === 'date' || activeElementKey === 'sig2') {
        data.right = Math.max(0, Math.min(220, Math.round((elementStartRight - deltaXMm) * 10) / 10));
      } else if (activeElementKey === 'sig1') {
        data.left = Math.max(0, Math.min(220, Math.round((elementStartLeft + deltaXMm) * 10) / 10));
      } else {
        data.left = Math.max(-100, Math.min(100, Math.round((elementStartLeft + deltaXMm) * 10) / 10));
      }

      selectElement(activeElementKey);
      renderLayoutOnCanvas();
    });

    document.addEventListener('mouseup', () => {
      if (isDragging) {
        isDragging = false;
      }
    });
  }

  // Keyboard Arrow Listener for Nudge
  document.addEventListener('keydown', (e) => {
    // Skip if focus is inside input/select
    if (['INPUT', 'SELECT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;

    let mult = e.shiftKey ? 5 : 1;
    let step = currentStep * mult;

    if (e.key === 'ArrowUp') {
      e.preventDefault();
      nudge(0, -step);
    } else if (e.key === 'ArrowDown') {
      e.preventDefault();
      nudge(0, step);
    } else if (e.key === 'ArrowLeft') {
      e.preventDefault();
      nudge(-step, 0);
    } else if (e.key === 'ArrowRight') {
      e.preventDefault();
      nudge(step, 0);
    }
  });

  function openCopyLayoutModal() {
    const modal = document.getElementById('copy-layout-modal');
    if (modal) {
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }
  }

  function closeCopyLayoutModal() {
    const modal = document.getElementById('copy-layout-modal');
    if (modal) {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }
  }

  function applyCopiedLayout(sourceLayout, sourceTitle) {
    if (!sourceLayout || typeof sourceLayout !== 'object') return;

    currentLayout = JSON.parse(JSON.stringify(sourceLayout));

    if (currentLayout.desc && parseFloat(currentLayout.desc.line_gap) < 0) {
      currentLayout.desc.line_gap = 0;
    }

    renderLayoutOnCanvas();
    selectElement(activeElementKey);

    closeCopyLayoutModal();

    if (typeof window.fccToast === 'function') {
      window.fccToast({
        type: 'success',
        title: 'Layout Berhasil Disalin!',
        msg: 'Koordinat & font dari "' + sourceTitle + '" telah diterapkan. Klik "Simpan Koordinat" untuk menyimpan.'
      });
    } else {
      alert('Layout dari "' + sourceTitle + '" berhasil diterapkan! Klik "Simpan Koordinat" untuk menyimpan.');
    }
  }

  window.addEventListener('resize', renderLayoutOnCanvas);
  document.addEventListener('DOMContentLoaded', () => {
    selectElement('title');
    renderLayoutOnCanvas();
    initMouseDrag();
  });
</script>

{{-- ═══ MODAL SALIN LAYOUT KEGIATAN LAIN ════════════════════════ --}}
<div id="copy-layout-modal" style="display:none;position:fixed;inset:0;z-index:999999;background:rgba(19,18,24,0.75);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:20px;">
  <div style="background:#131218;border:2px solid #FFC81A;border-radius:20px;padding:28px;max-width:560px;width:100%;color:#FFF;box-shadow:0 24px 64px rgba(0,0,0,0.5);position:relative;">
    
    <div style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,0.1);padding-bottom:16px;margin-bottom:20px;">
      <div style="display:flex;align-items:center;gap:12px;">
        <div style="width:42px;height:42px;background:#FFC81A;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
        </div>
        <div>
          <h3 style="margin:0;font-size:18px;font-weight:900;font-family:'Outfit',sans-serif;color:#FFF;">Salin Layout Sertifikat</h3>
          <p style="margin:0;font-size:12px;color:rgba(255,255,255,0.6);">Pilih kegiatan asal untuk menerapkan posisi koordinat & font</p>
        </div>
      </div>
      <button type="button" onclick="closeCopyLayoutModal()" style="background:none;border:none;color:rgba(255,255,255,0.5);font-size:24px;cursor:pointer;" onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">&times;</button>
    </div>

    @if(!empty($otherKegiatans) && count($otherKegiatans) > 0)
      <div style="max-height:360px;overflow-y:auto;padding-right:6px;display:flex;flex-direction:column;gap:10px;" id="other-kegiatan-list">
        @foreach($otherKegiatans as $other)
          <div style="background:rgba(255,255,255,0.04);border:1.5px solid rgba(255,255,255,0.08);border-radius:12px;padding:14px 16px;display:flex;align-items:center;justify-content:space-between;gap:14px;transition:all .15s;" onmouseover="this.style.borderColor='#FFC81A';this.style.background='rgba(255,200,26,0.06)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)';this.style.background='rgba(255,255,255,0.04)'">
            <div style="min-width:0;flex:1;">
              <div style="font-size:13.5px;font-weight:800;color:#FFF;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $other['judul'] }}
              </div>
              <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                @if($other['has_latar'])
                  <span style="background:rgba(16,185,129,0.2);color:#34D399;border:1px solid rgba(52,211,153,0.3);font-size:10.5px;font-weight:800;padding:2px 8px;border-radius:10px;">✔ Tersedia Latar</span>
                @else
                  <span style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.6);font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:10px;">Latar Standar</span>
                @endif
                <span style="font-size:11px;color:rgba(255,255,255,0.5);">Judul Y: {{ $other['layout']['title']['top'] ?? 36 }}mm</span>
              </div>
            </div>

            <button type="button" onclick="applyCopiedLayout({{ json_encode($other['layout']) }}, '{{ addslashes($other['judul']) }}')" style="background:#FFC81A;color:#131218;border:none;border-radius:10px;padding:8px 16px;font-size:12px;font-weight:900;cursor:pointer;white-space:nowrap;box-shadow:0 4px 12px rgba(255,200,26,0.3);transition:transform .15s;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
              Gunakan Layout
            </button>
          </div>
        @endforeach
      </div>
    @else
      <div style="text-align:center;padding:36px 16px;color:rgba(255,255,255,0.5);">
        <div style="font-size:14px;font-weight:700;">Belum ada kegiatan lain untuk disalin layout-nya.</div>
      </div>
    @endif

    <div style="margin-top:20px;padding-top:14px;border-top:1px solid rgba(255,255,255,0.1);display:flex;justify-content:flex-end;">
      <button type="button" onclick="closeCopyLayoutModal()" class="fcc-btn-outline-light" style="padding:8px 18px;font-size:12.5px;">Tutup</button>
    </div>
  </div>
</div>
@endsection




