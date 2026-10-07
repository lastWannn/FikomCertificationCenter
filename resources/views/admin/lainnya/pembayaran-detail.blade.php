@extends('layouts.admin')
@section('title','Detail Pembayaran - ' . $pembayaran->kode_pembayaran)

@section('page-content')
<style>
  /* ── FCC PEMBAYARAN DETAIL MULTI-TIER RESPONSIVE STYLES ───────────── */
  .fcc-pembayaran-detail-container {
    padding: 24px;
    position: relative;
    box-sizing: border-box;
    max-width: 100%;
  }
  @media (max-width: 1023px) {
    .fcc-pembayaran-detail-container {
      padding: 18px 16px;
    }
  }
  @media (max-width: 639px) {
    .fcc-pembayaran-detail-container {
      padding: 14px 12px;
    }
  }
  @media (max-width: 420px) {
    .fcc-pembayaran-detail-container {
      padding: 12px 8px;
    }
  }

  /* ── MAIN LAYOUT GRID ─────────────────────────────────────────────── */
  /* Di Desktop Widescreen (>= 1240px): 2 Kolom (Kiri: Bukti Bayar, Kanan: Sidebar Detail 360px) */
  .admin-detail-pembayaran-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 20px;
    align-items: start;
  }

  /* DI IPAD / TABLET & LAPTOP (< 1240px):
     Karena sidebar admin menyita ~260px, lebar konten yang tersisa adalah 750px - 950px.
     Maka layout utama bertransisi menjadi 1 Kolom penuh (stack),
     sehingga Foto Bukti & Data Pengirim TIDAK AKAN PERNAH bertabrakan dengan Ringkasan Pembayaran! */
  @media (max-width: 1239px) {
    .admin-detail-pembayaran-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }
  }

  /* Overflow Guard: Mencegah komponen meluap dari batas kolom grid */
  .admin-detail-pembayaran-grid > *,
  .proof-split-grid > *,
  .sender-info-panel,
  .fcc-detail-card,
  .fcc-detail-sidebar-wrap {
    min-width: 0;
    max-width: 100%;
    box-sizing: border-box;
  }

  /* ── SIDEBAR CONTAINER (INFORMASI PESERTA & RINGKASAN PEMBAYARAN) ─── */
  /* Di Desktop (>= 1240px): Kolom vertikal bertumpuk di sebelah kanan */
  .fcc-detail-sidebar-wrap {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }
  /* Di iPad & Tablet (640px – 1239px): Berjejer 2 Kolom berdampingan (seimbang & rapi di bawah foto bukti!) */
  @media (min-width: 640px) and (max-width: 1239px) {
    .fcc-detail-sidebar-wrap {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      align-items: start;
    }
  }
  /* Di Mobile (< 640px): Kembali bertumpuk 1 kolom */
  @media (max-width: 639px) {
    .fcc-detail-sidebar-wrap {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
  }

  /* ── PROOF BAYAR SPLIT GRID ───────────────────────────────────────── */
  /* Split layout pada card bukti bayar: Kiri Gambar, Kanan Informasi Pengirim */
  .proof-split-grid {
    display: grid;
    grid-template-columns: 310px minmax(0, 1fr);
    gap: 24px;
    align-items: stretch;
  }
  @media (max-width: 860px) {
    .proof-split-grid {
      grid-template-columns: 1fr;
      gap: 18px;
    }
  }

  /* Frame Foto Bukti Transfer: Bersih, Rapi & Proporsional */
  .proof-photo-box {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    background: #F8FAFC;
    cursor: zoom-in;
    width: 100%;
    max-width: 310px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
  }
  .proof-photo-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.09);
    border-color: #CBD5E1;
  }
  @media (max-width: 860px) {
    .proof-photo-box {
      max-width: 100%;
    }
  }
  .proof-img-natural {
    width: 100%;
    max-height: 440px;
    height: auto;
    display: block;
    object-fit: contain;
  }

  /* Panel Informasi Pengirim Transfer (Kanan) */
  .sender-info-panel {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    box-sizing: border-box;
  }
  @media (max-width: 639px) {
    .sender-info-panel {
      padding: 14px 12px;
      height: auto;
    }
  }
  .sender-field-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-top: 1px solid #EEF2F6;
    font-size: 13px;
    gap: 12px;
  }
  .sender-field-row:first-of-type {
    border-top: none;
    padding-top: 2px;
  }
  .sender-field-label {
    color: #64748B;
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
  }
  .sender-field-val {
    color: #0F172A;
    font-weight: 700;
    text-align: right;
    word-break: break-word;
    overflow-wrap: anywhere;
  }

  /* Card Base Style */
  .fcc-detail-card {
    padding: 22px 24px;
    border-radius: 16px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    box-sizing: border-box;
  }
  @media (max-width: 639px) {
    .fcc-detail-card {
      padding: 16px 14px;
      border-radius: 14px;
    }
  }
  @media (max-width: 420px) {
    .fcc-detail-card {
      padding: 14px 10px;
    }
  }

  /* Header Layout */
  .fcc-detail-header-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 20px;
  }
  .fcc-detail-header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
  }
  .fcc-verif-form {
    display: flex;
    gap: 8px;
    align-items: center;
  }
  .fcc-verif-input {
    width: 210px;
    font-size: 12.5px;
  }
  .fcc-verif-btn {
    padding: 9px 18px;
    font-size: 13px;
    white-space: nowrap;
  }
  .fcc-tolak-btn {
    padding: 9px 16px;
    border-radius: 10px;
    border: 1.5px solid rgba(239,68,68,.3);
    background: rgba(239,68,68,.07);
    color: #EF4444;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .15s;
  }
  .fcc-tolak-btn:hover {
    background: rgba(239,68,68,.15);
  }

  @media (max-width: 900px) {
    .fcc-detail-header-wrap {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
    }
    .fcc-detail-header-actions {
      width: 100%;
      flex-wrap: wrap;
    }
  }

  @media (max-width: 639px) {
    .fcc-detail-header-actions {
      flex-direction: column;
      align-items: stretch;
      gap: 8px;
    }
    .fcc-verif-form {
      width: 100%;
      flex-direction: column;
      align-items: stretch;
      gap: 8px;
    }
    .fcc-verif-input {
      width: 100% !important;
      box-sizing: border-box;
    }
    .fcc-verif-btn {
      width: 100%;
      justify-content: center;
      box-sizing: border-box;
    }
    .fcc-tolak-btn {
      width: 100%;
      justify-content: center;
      box-sizing: border-box;
    }
    .fcc-perpanjang-btn {
      width: 100% !important;
      justify-content: center;
      box-sizing: border-box;
    }
  }

  /* Form Penolakan Inline Permintaan Perpanjangan */
  .fcc-tolak-perpanjangan-form {
    background: #FFF;
    border: 1px solid #FCA5A5;
    border-radius: 12px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  @media (max-width: 639px) {
    .fcc-perpanjang-actions {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }
    .fcc-perpanjang-actions form {
      width: 100%;
    }
    .fcc-perpanjang-actions button {
      width: 100%;
      justify-content: center;
    }
    .fcc-tolak-perpanjangan-form {
      flex-direction: column;
      align-items: stretch;
      width: 100%;
      box-sizing: border-box;
    }
    .fcc-tolak-perpanjangan-form input {
      width: 100% !important;
      box-sizing: border-box;
    }
    .fcc-tolak-perpanjangan-form button {
      width: 100% !important;
      justify-content: center;
      box-sizing: border-box;
    }
  }

  /* Row data helper untuk informasi peserta & ringkasan */
  .fcc-info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 9px 0;
    border-top: 1px solid #F0F1F5;
    gap: 12px;
  }
  .fcc-info-row:first-of-type {
    border-top: none;
    padding-top: 2px;
  }
  .fcc-info-label {
    color: #9CA3B0;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    flex-shrink: 0;
  }
  .fcc-info-val {
    color: #131218;
    font-size: 13px;
    font-weight: 700;
    text-align: right;
    word-break: break-word;
    overflow-wrap: anywhere;
  }

  /* Lightbox Modal Minimalis */
  .fcc-lightbox-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 999999;
    background: rgba(10, 11, 16, 0.94);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    flex-direction: column;
    padding: 16px;
    box-sizing: border-box;
    overflow: hidden;
  }
  .lightbox-topbar {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    color: #FFFFFF;
    flex-shrink: 0;
  }
  @media (max-width: 639px) {
    .lightbox-topbar {
      gap: 8px;
    }
    .lightbox-topbar h4 {
      font-size: 12.5px !important;
    }
    .lightbox-topbar p {
      max-width: 150px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }
  .lb-ctrl-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
    height: 34px;
    padding: 0 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
  }
  .lb-ctrl-btn:hover {
    background: rgba(255, 200, 26, 0.2);
    border-color: #FFC81A;
    color: #FFC81A;
  }
  .lb-close-btn {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: #EF4444;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    font-size: 17px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    transition: all 0.15s;
    flex-shrink: 0;
  }
  .lb-close-btn:hover {
    background: #EF4444;
    color: #FFFFFF;
    border-color: #EF4444;
  }
  .lightbox-viewport {
    flex: 1;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: auto;
    position: relative;
    user-select: none;
  }
  .lightbox-image-target {
    max-width: 92vw;
    max-height: 84vh;
    border-radius: 10px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.9), 0 0 30px rgba(255, 200, 26, 0.15);
    object-fit: contain;
  }
</style>

<div class="fcc-pembayaran-detail-container">

    {{-- ── 1. HEADER + AKSI ─────────────────────────────────────── --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.pembayaran.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <div class="fcc-detail-header-wrap">
            <div>
                <h1 style="font-size:20px;font-weight:900;color:#131218;margin:0 0 4px">Detail Pembayaran</h1>
                <p style="color:#FFC81A;font-size:14px;font-weight:700;font-family:monospace;margin:0">
                    {{ $pembayaran->kode_pembayaran }}
                </p>
            </div>

            {{-- AKSI berdasarkan status --}}
            <div class="fcc-detail-header-actions">

                @if($pembayaran->status_pembayaran === 'menunggu_verifikasi')
                {{-- Verifikasi --}}
                <form action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}"
                      method="POST" class="fcc-verif-form">
                    @csrf
                    <input type="text" name="no_kwitansi" placeholder="No. Kwitansi (Auto Generate)"
                           class="fcc-input fcc-verif-input">
                    <button type="button" class="fcc-btn-gold fcc-verif-btn"
                            onclick="fccConfirmAction(this, 'Verifikasi Pembayaran?', 'Pembayaran akan ditandai terverifikasi dan peserta diberitahu via email.', 'Ya, Verifikasi', false)">
                        @include('components.icon',['name'=>'check','size'=>14]) Verifikasi
                    </button>
                </form>
                {{-- Tolak --}}
                <button type="button" onclick="document.getElementById('form-tolak').style.display='block'"
                        class="fcc-tolak-btn">
                    @include('components.icon',['name'=>'x','size'=>14]) Tolak
                </button>

                @elseif($pembayaran->status_perpanjangan === 'menunggu')
                {{-- Badge permintaan perpanjangan pending --}}
                <div style="background:rgba(245,158,11,.1);border:1.5px solid rgba(245,158,11,.3);
                            border-radius:10px;padding:8px 14px;display:inline-flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'clock','size'=>15,'style'=>'color:#F59E0B'])
                    <span style="font-size:13px;font-weight:700;color:#B45309">
                        Ada Permintaan Perpanjangan
                    </span>
                </div>

                @elseif($pembayaran->status_pembayaran === 'kadaluarsa')
                <form action="{{ route('admin.pembayaran.perpanjang', $pembayaran) }}" method="POST" style="width:100%;">
                    @csrf
                    <button type="submit" class="fcc-perpanjang-btn" style="padding:9px 16px;border-radius:10px;border:1.5px solid rgba(255,200,26,.3);
                                                background:rgba(255,200,26,.08);color:#B38F00;font-size:13px;
                                                font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                        @include('components.icon',['name'=>'refresh-cw','size'=>13]) Perpanjang +2 Jam
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    {{-- ── FORM TOLAK PEMBAYARAN (tersembunyi) ─────────────────── --}}
    <div id="form-tolak" style="display:none;background:#FFF8F8;border:1.5px solid rgba(239,68,68,.2);
                                border-radius:12px;padding:18px 20px;margin-bottom:18px;">
        <p style="font-size:14px;font-weight:800;color:#DC2626;margin:0 0 12px">Tolak Pembayaran</p>
        <form action="{{ route('admin.pembayaran.tolak', $pembayaran) }}" method="POST">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px">
                    Alasan Penolakan (opsional)
                </label>
                <textarea name="alasan" rows="2" placeholder="Jelaskan alasan penolakan (misal: bukti tidak jelas, nominal tidak sesuai)..."
                          class="fcc-input" style="resize:none;font-size:13px;width:100%"></textarea>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button type="submit" style="padding:8px 18px;border-radius:8px;border:none;background:#EF4444;color:#FFF;font-size:13px;font-weight:700;cursor:pointer">
                    Konfirmasi Tolak
                </button>
                <button type="button" onclick="document.getElementById('form-tolak').style.display='none'"
                        class="fcc-btn-outline-dark" style="padding:8px 16px;font-size:13px">
                    Batal
                </button>
            </div>
        </form>
    </div>

    {{-- ── PANEL PERPANJANGAN WAKTU (jika ada request) ─────────── --}}
    @if($pembayaran->status_perpanjangan === 'menunggu')
    <div style="background:#FFFDF5;border:1.5px solid #FCD34D;border-radius:14px;padding:18px 20px;margin-bottom:20px;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:14px;">
            <div>
                <div style="display:flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'clock','size'=>18,'style'=>'color:#D97706'])
                    <span style="font-size:15px;font-weight:900;color:#92400E">Permintaan Perpanjangan Waktu (+2 Jam)</span>
                </div>
                <p style="font-size:12.5px;color:#78350F;margin:4px 0 0 26px">
                    Diajukan pada: <strong>{{ $pembayaran->request_perpanjangan_at?->format('d M Y H:i') }}</strong>
                    ({{ $pembayaran->request_perpanjangan_at?->diffForHumans() }})
                </p>
            </div>
        </div>

        <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:10px;padding:12px 16px;margin-bottom:14px;">
            <span style="font-size:11px;font-weight:700;color:#B45309;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:3px">Alasan Peserta:</span>
            <p style="font-size:13.5px;color:#1E293B;margin:0;font-weight:600">
                "{{ $pembayaran->alasan_perpanjangan ?: 'Tidak ada alasan khusus.' }}"
            </p>
        </div>

        <div class="fcc-perpanjang-actions" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            {{-- Setujui form --}}
            <form action="{{ route('admin.pembayaran.approve-perpanjangan', $pembayaran) }}" method="POST">
                @csrf
                <input type="hidden" name="jam_tambah" value="2">
                <button type="submit" style="background:#10B981;color:#FFF;border:none;padding:8px 20px;font-size:13px;font-weight:800;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                    ✓ Setujui (+2 Jam)
                </button>
            </form>

            {{-- Tolak Inline Form --}}
            <form action="{{ route('admin.pembayaran.tolak-perpanjangan', $pembayaran) }}" method="POST" class="fcc-tolak-perpanjangan-form">
                @csrf
                <input type="text" name="catatan" placeholder="Alasan penolakan..." class="fcc-input" required style="flex:1;padding:6px 10px;font-size:12px;min-width:0;">
                <button type="submit" style="background:#EF4444;color:#FFF;border:none;padding:7px 16px;font-size:12px;font-weight:800;border-radius:8px;cursor:pointer;white-space:nowrap;flex-shrink:0;display:inline-flex;align-items:center;gap:4px;">
                    ✕ Tolak
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- ── 2. KONTEN UTAMA (GRID 2 KOLOM) ─────────────────────────── --}}
    <div class="admin-detail-pembayaran-grid">

        {{-- ── KOLOM KIRI (LEBAR: FOTO BUKTI & INFORMASI PENGIRIM) ── --}}
        <div>

            {{-- Card 2: Foto Bukti Transfer --}}
            @if($pembayaran->bukti_bayar)
            <div class="fcc-detail-card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:8px;">
                    <h3 style="font-size:15px;font-weight:800;color:#131218;margin:0;display:flex;align-items:center;gap:6px;">
                        @include('components.icon',['name'=>'image','size'=>15,'style'=>'color:#FFC81A'])
                        Foto Bukti &amp; Data Pengirim Transfer
                    </h3>
                    <div style="display:flex;gap:6px;">
                        <button type="button" onclick="openPaymentLightbox('{{ asset('storage/'.$pembayaran->bukti_bayar) }}')"
                                style="background:#F7F8FA;border:1px solid #E2E4EB;color:#334155;padding:5px 12px;font-size:12px;font-weight:700;border-radius:6px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'eye','size'=>12]) Perbesar
                        </button>
                        <a href="{{ asset('storage/'.$pembayaran->bukti_bayar) }}" target="_blank"
                           style="background:#F7F8FA;border:1px solid #E2E4EB;color:#334155;padding:5px 12px;font-size:12px;font-weight:700;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'download','size'=>12]) Tab Baru
                        </a>
                    </div>
                </div>

                {{-- Dua Section: Kiri Gambar Bukti, Kanan Informasi Pengirim --}}
                <div class="proof-split-grid">
                    {{-- Section Kiri: Gambar Bukti Bayar --}}
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div class="proof-photo-box" onclick="openPaymentLightbox('{{ asset('storage/'.$pembayaran->bukti_bayar) }}')" title="Klik untuk membuka ukuran penuh">
                            <img src="{{ asset('storage/'.$pembayaran->bukti_bayar) }}"
                                 alt="Bukti Transfer {{ $pembayaran->kode_pembayaran }}"
                                 class="proof-img-natural">
                        </div>
                        <span style="font-size:11px;color:#94A3B8;margin-top:8px;font-weight:600;display:flex;align-items:center;gap:4px;">
                            @include('components.icon',['name'=>'check-circle','size'=>12,'style'=>'color:#10B981'])
                            Struk Asli &bull; Resolusi Penuh di Lightbox
                        </span>
                    </div>

                    {{-- Section Kanan: Panel Informasi Pengirim Transfer --}}
                    <div class="sender-info-panel">
                        <div>
                            <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:10px;margin-bottom:6px;border-bottom:1px solid #E2E8F0;">
                                <span style="font-size:11.5px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;display:flex;align-items:center;gap:6px;">
                                    @include('components.icon',['name'=>'user-check','size'=>13,'style'=>'color:#FFC81A'])
                                    Informasi Pengirim
                                </span>
                                <span style="font-size:10.5px;font-weight:800;color:#059669;background:#ECFDF5;padding:2px 8px;border-radius:6px;border:1px solid #A7F3D0;">
                                    Sesuai Struk
                                </span>
                            </div>

                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'user','size'=>12]) Nama Pengirim
                                </span>
                                <span class="sender-field-val" style="font-size:13.5px;color:#0F172A;">
                                    {{ $pembayaran->nama_pengirim ?: '-' }}
                                </span>
                            </div>

                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'calendar','size'=>12]) Waktu Transfer
                                </span>
                                <span class="sender-field-val">
                                    {{ optional($pembayaran->tgl_transfer)->format('d M Y') ?: '-' }}
                                    @if($pembayaran->jam_transfer)
                                        <span style="color:#64748B;font-weight:600;font-size:12px;margin-left:3px;">({{ $pembayaran->jam_transfer }})</span>
                                    @endif
                                </span>
                            </div>

                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'credit-card','size'=>12]) Jenis Pembayaran
                                </span>
                                <span class="sender-field-val">
                                    <span style="background:rgba(255,200,26,0.18);border:1px solid rgba(255,200,26,0.5);color:#92400E;padding:2px 9px;border-radius:6px;font-size:11px;font-weight:800;text-transform:uppercase;">
                                        {{ $pembayaran->metode_pembayaran ?: '-' }}
                                    </span>
                                </span>
                            </div>

                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'building','size'=>12]) Layanan / Bank
                                </span>
                                <span class="sender-field-val">
                                    {{ $pembayaran->nama_layanan_bank ?: '-' }}
                                </span>
                            </div>

                            @if($pembayaran->no_referensi)
                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'tag','size'=>12]) No. Referensi
                                </span>
                                <span class="sender-field-val" style="font-family:'SF Mono', Monaco, monospace;font-size:12px;">
                                    {{ $pembayaran->no_referensi }}
                                </span>
                            </div>
                            @endif

                            @if($pembayaran->berita_transaksi)
                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'file-text','size'=>12]) Catatan / Berita
                                </span>
                                <span class="sender-field-val" style="font-size:12px;color:#475569;font-weight:600;">
                                    {{ $pembayaran->berita_transaksi }}
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Box kecocokan nominal untuk menyeimbangkan tinggi kolom kanan dengan foto di kiri --}}
                        <div style="background:#FFFFFF;border:1px solid #E2E8F0;border-radius:10px;padding:11px 13px;margin-top:14px;box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
                                <span style="font-size:10.5px;font-weight:700;color:#64748B;text-transform:uppercase;letter-spacing:0.4px;">Total Ditagihkan:</span>
                                <span style="font-size:13.5px;font-weight:900;color:#B45309;font-family:'SF Mono',Monaco,monospace;">
                                    {{ $pembayaran->nominal_transfer_format }}
                                </span>
                            </div>
                            <p style="margin:0;font-size:11px;color:#64748B;line-height:1.4;">
                                Pastikan nominal pada foto struk di sebelah kiri cocok dengan mutasi bank Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="fcc-card fcc-detail-card" style="text-align:center;color:#9CA3B0;">
                @include('components.icon',['name'=>'image','size'=>32])
                <p style="margin:8px 0 0;font-size:13px;font-weight:600">Belum ada bukti transfer yang diunggah.</p>
            </div>
            @endif
        </div>

        {{-- ── KOLOM KANAN (SIDEBAR: INFORMASI PESERTA & RINGKASAN PEMBAYARAN) ── --}}
        <div class="fcc-detail-sidebar-wrap">
            {{-- Card 1: Informasi Peserta & Kegiatan --}}
            <div class="fcc-card fcc-detail-card">
                <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'user-check','size'=>15,'style'=>'color:#FFC81A'])
                    Informasi Peserta &amp; Kegiatan
                </h3>

                @foreach([
                    ['Nama Peserta',  $pembayaran->pendaftaran->peserta->nama],
                    ['Email',         $pembayaran->pendaftaran->peserta->email],
                    ['No. HP',        $pembayaran->pendaftaran->peserta->no_hp ?: '-'],
                    ['Kegiatan',      Str::limit($pembayaran->pendaftaran->kegiatan->judul, 35)],
                    ['Jenis Kegiatan',ucfirst($pembayaran->pendaftaran->kegiatan->jenis_kegiatan ?? '-')],
                    ['Jenis Biaya',   $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Gratis'],
                ] as [$l,$v])
                <div class="fcc-info-row">
                    <span class="fcc-info-label">{{ $l }}</span>
                    <span class="fcc-info-val" title="{{ $l === 'Kegiatan' ? $pembayaran->pendaftaran->kegiatan->judul : '' }}">{{ $v }}</span>
                </div>
                @endforeach
            </div>

            {{-- Item 2: Ringkasan Pembayaran & Cetak PDF --}}
            <div style="display:flex;flex-direction:column;gap:14px;">
                {{-- Card 2: Ringkasan Pembayaran --}}
                <div class="fcc-card fcc-detail-card">
                    <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                        @include('components.icon',['name'=>'credit-card','size'=>15,'style'=>'color:#FFC81A'])
                        Ringkasan Pembayaran
                    </h3>

                    @foreach([
                        ['Nominal Biaya',     $pembayaran->jumlah_bayar_format],
                        ['Kode Unik',         $pembayaran->kode_unik ?? '-'],
                        ['Total Transfer',    $pembayaran->nominal_transfer_format],
                        ['Jenis Pembayaran',  $pembayaran->metode_pembayaran ?? '-'],
                        ['Layanan / Bank',    $pembayaran->nama_layanan_bank ?? '-'],
                        ['Batas Bayar',       $pembayaran->tgl_kadaluarsa?->format('d M Y H:i')],
                    ] as [$l,$v])
                    <div class="fcc-info-row">
                        <span class="fcc-info-label">{{ $l }}</span>
                        <span class="fcc-info-val">{{ $v }}</span>
                    </div>
                    @endforeach

                    {{-- Status badge --}}
                    @php
                    $sc = match(true) {
                        $pembayaran->status_perpanjangan === 'menunggu' => ['#D97706', 'Req. Perpanjangan'],
                        $pembayaran->status_pembayaran === 'terverifikasi'       => ['#10B981','Terverifikasi'],
                        $pembayaran->status_pembayaran === 'menunggu_verifikasi' => ['#F59E0B','Menunggu Verifikasi'],
                        $pembayaran->status_pembayaran === 'ditolak'             => ['#EF4444','Ditolak'],
                        $pembayaran->status_pembayaran === 'kadaluarsa'          => ['#6B7280','Kadaluarsa'],
                        default               => ['#3B82F6','Menunggu Bayar'],
                    };
                    @endphp
                    <div style="margin-top:14px;background:{{ $sc[0] }}12;border:1px solid {{ $sc[0] }}30;
                                border-radius:10px;padding:12px;text-align:center;">
                        <p style="color:{{ $sc[0] }};font-size:14px;font-weight:800;margin:0">
                            {{ $sc[1] }}
                        </p>
                    </div>
                </div>

                {{-- Cetak PDF --}}
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('admin.cetak.invoice', $pembayaran) }}" target="_blank"
                       style="display:flex;align-items:center;justify-content:center;gap:6px;
                              padding:11px;min-height:42px;width:100%;box-sizing:border-box;border-radius:10px;border:1.5px solid #E2E4EB;
                              background:#F7F8FA;color:#6B7280;font-size:13px;font-weight:700;
                              text-decoration:none;transition:all .18s;"
                       onmouseover="this.style.borderColor='#FFC81A';this.style.color='#131218'"
                       onmouseout="this.style.borderColor='#E2E4EB';this.style.color='#6B7280'">
                        @include('components.icon',['name'=>'printer','size'=>13]) Cetak Invoice
                    </a>
                    @if($pembayaran->status_pembayaran === 'terverifikasi')
                    <a href="{{ route('admin.cetak.bukti', $pembayaran) }}" target="_blank"
                       class="fcc-btn-gold"
                       style="display:flex;align-items:center;justify-content:center;gap:6px;
                              padding:11px;min-height:42px;width:100%;box-sizing:border-box;font-size:13px;text-decoration:none;">
                        @include('components.icon',['name'=>'file-check','size'=>13]) Cetak Bukti Lunas
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── 3. LIGHTBOX MODAL MINIMALIS ─────────────────────────────── --}}
<div id="fcc-payment-lightbox" class="fcc-lightbox-modal" onclick="handleLightboxBackdropClick(event)">
    <div class="lightbox-topbar" onclick="event.stopPropagation()">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:30px;height:30px;border-radius:7px;background:rgba(255,200,26,0.15);border:1px solid rgba(255,200,26,0.4);display:flex;align-items:center;justify-content:center;color:#FFC81A;">
                @include('components.icon',['name'=>'image','size'=>14])
            </div>
            <div>
                <h4 style="font-size:13.5px;font-weight:800;margin:0;color:#FFFFFF;">Foto Bukti Transfer</h4>
                <p style="font-size:11px;color:#94A3B8;margin:0;">{{ $pembayaran->kode_pembayaran }} &bull; {{ $pembayaran->nama_pengirim ?: $pembayaran->pendaftaran->peserta->nama }}</p>
            </div>
        </div>

        <div style="display:flex;align-items:center;gap:8px;">
            <a id="lightbox-tab-link" href="#" target="_blank" class="lb-ctrl-btn" title="Buka di Tab Baru">
                @include('components.icon',['name'=>'download','size'=>12]) Buka Ukuran Asli
            </a>
            <button type="button" class="lb-close-btn" onclick="closePaymentLightbox()" title="Tutup (ESC)">
                &times;
            </button>
        </div>
    </div>

    <div class="lightbox-viewport" id="lb-viewport">
        <img id="lightbox-preview-img" src="" class="lightbox-image-target" alt="Bukti Transfer Perbesar" onclick="event.stopPropagation()">
    </div>
</div>

<script>
  /* Lightbox Logic */
  function openPaymentLightbox(src) {
    const modal = document.getElementById('fcc-payment-lightbox');
    const img = document.getElementById('lightbox-preview-img');
    const tabLink = document.getElementById('lightbox-tab-link');
    if (!modal || !img) return;

    img.src = src;
    if (tabLink) tabLink.href = src;

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function closePaymentLightbox() {
    const modal = document.getElementById('fcc-payment-lightbox');
    if (!modal) return;
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }

  function handleLightboxBackdropClick(e) {
    if (e.target.id === 'fcc-payment-lightbox' || e.target.id === 'lb-viewport') {
      closePaymentLightbox();
    }
  }

  // Keyboard shortcut: ESC to close
  document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('fcc-payment-lightbox');
    if (!modal || modal.style.display !== 'flex') return;

    if (e.key === 'Escape') {
      closePaymentLightbox();
    }
  });
</script>
@endsection
