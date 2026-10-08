@extends('layouts.admin')
@section('title','Informasi & FAQ')
@section('page-title', 'Informasi & FAQ')
@section('page-breadcrumb', 'Konten / Informasi & FAQ')

@section('page-content')
<style>
  /* ── Base Container ── */
  .fcc-info-container {
    padding: 24px 28px;
    max-width: 1300px;
    margin: 0 auto;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
  }

  /* ── Header Area ── */
  .fcc-info-header {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 4px 4px 0px #131218;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    box-sizing: border-box;
    flex-wrap: wrap;
  }
  .fcc-info-title-wrap {
    flex: 1;
    min-width: 240px;
  }
  .fcc-info-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
    flex-wrap: wrap;
  }
  .fcc-info-tag {
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
    white-space: nowrap;
  }
  .fcc-info-main-title {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 0;
    letter-spacing: -0.02em;
    font-family: 'Outfit', sans-serif;
  }
  .fcc-info-sub {
    color: #64748B;
    font-size: 13px;
    margin: 0;
    font-weight: 500;
    line-height: 1.4;
  }

  /* ── Toolbar Actions (Filter + Add) ── */
  .fcc-info-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }
  .fcc-filter-pills {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #F8FAFC;
    border: 1.5px solid #E2E8F0;
    padding: 4px;
    border-radius: 12px;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
  }
  .fcc-filter-pills::-webkit-scrollbar {
    display: none;
  }
  .fcc-filter-pill-link {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    color: #475569;
    white-space: nowrap;
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .fcc-filter-pill-link:hover {
    color: #0F172A;
    background: #EDF2F7;
  }
  .fcc-filter-pill-link.active {
    background: #131218;
    color: #FFC81A;
    box-shadow: 0 2px 6px rgba(19, 18, 24, 0.18);
  }

  .fcc-btn-add {
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 800;
    background: #FFC81A;
    color: #131218;
    border-radius: 12px;
    border: 2px solid #131218;
    box-shadow: 2px 2px 0px #131218;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all .16s ease-in-out;
    white-space: nowrap;
    text-decoration: none;
    box-sizing: border-box;
  }
  .fcc-btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 3px 3px 0px #131218;
    background: #FFD447;
  }
  .fcc-btn-add:active {
    transform: translateY(1px);
    box-shadow: 1px 1px 0px #131218;
  }

  /* ── Content Card Items ── */
  .fcc-info-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }
  .fcc-info-card {
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    border-radius: 16px;
    padding: 20px 22px;
    transition: all .18s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    box-sizing: border-box;
    position: relative;
  }
  .fcc-info-card:hover {
    border-color: #131218;
    transform: translateY(-2px);
    box-shadow: 4px 4px 0px #131218;
  }
  .fcc-card-content {
    flex: 1;
    min-width: 0;
  }
  .fcc-badge-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    flex-wrap: wrap;
  }
  .fcc-badge-type {
    font-size: 11px;
    font-weight: 900;
    padding: 3px 10px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    letter-spacing: 0.3px;
  }
  .fcc-badge-status {
    font-size: 11px;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 8px;
  }
  .fcc-badge-date {
    font-size: 11.5px;
    color: #94A3B8;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .fcc-card-heading {
    font-size: 16px;
    font-weight: 900;
    color: #131218;
    margin: 0 0 6px;
    line-height: 1.4;
    word-break: break-word;
  }
  .fcc-card-body-text {
    color: #475569;
    font-size: 13.5px;
    line-height: 1.6;
    margin: 0;
    font-weight: 500;
    word-break: break-word;
  }
  .fcc-card-timing {
    color: #64748B;
    font-size: 12px;
    margin: 6px 0 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
  }

  /* ── Action Buttons ── */
  .fcc-card-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
    align-items: center;
  }
  .fcc-btn-edit {
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 800;
    background: #FFFFFF;
    color: #131218;
    border-radius: 8px;
    border: 1.5px solid #131218;
    cursor: pointer;
    transition: all .16s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
  }
  .fcc-btn-edit:hover {
    background: #FFC81A;
    transform: translateY(-1px);
    box-shadow: 2px 2px 0px #131218;
  }
  .fcc-btn-delete {
    padding: 7px 11px;
    border-radius: 8px;
    border: 1.5px solid #FCA5A5;
    background: #FEF2F2;
    color: #DC2626;
    font-size: 12px;
    cursor: pointer;
    transition: all .16s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .fcc-btn-delete:hover {
    background: #DC2626;
    color: #FFFFFF;
    border-color: #DC2626;
    transform: translateY(-1px);
  }

  /* ── Modal Dialog System ── */
  @keyframes modalIn {
    from { opacity: 0; transform: scale(.96) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }
  .fcc-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9998;
    background: rgba(19, 18, 24, 0.65);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    align-items: flex-start;
    justify-content: center;
    overflow-y: auto;
    padding: 24px 14px;
    box-sizing: border-box;
  }
  .fcc-modal-box {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 20px;
    padding: 28px 30px;
    max-width: 620px;
    width: 100%;
    box-shadow: 6px 6px 0px #131218;
    animation: modalIn .22s cubic-bezier(0.16, 1, 0.3, 1);
    margin: auto;
    position: relative;
    box-sizing: border-box;
  }
  .fcc-modal-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    border-bottom: 2px solid #F1F5F9;
    padding-bottom: 14px;
    gap: 12px;
  }
  .fcc-modal-close-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1.5px solid #131218;
    background: #FFFFFF;
    color: #131218;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 900;
    transition: all .15s;
    flex-shrink: 0;
  }
  .fcc-modal-close-btn:hover {
    background: #FFC81A;
  }

  .fcc-radio-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }
  .fcc-radio-option {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    padding: 11px 14px;
    border: 1.5px solid #CBD5E1;
    border-radius: 12px;
    transition: all .18s;
    color: #131218;
    font-size: 13px;
    font-weight: 800;
    box-sizing: border-box;
  }
  .fcc-time-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  /* ── Confirm Delete Box ── */
  .fcc-confirm-box {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 20px;
    padding: 28px 24px;
    max-width: 420px;
    width: 100%;
    box-shadow: 6px 6px 0px #131218;
    text-align: center;
    animation: modalIn .22s ease;
    box-sizing: border-box;
  }

  /* ── Responsive Breakpoints ── */
  @media (max-width: 1023px) {
    .fcc-info-container {
      padding: 20px 16px;
    }
    .fcc-info-header {
      padding: 18px 20px;
    }
  }

  @media (max-width: 767px) {
    .fcc-info-container {
      padding: 14px 12px;
    }
    .fcc-info-header {
      flex-direction: column;
      align-items: stretch;
      padding: 16px 14px;
      gap: 14px;
      border-radius: 14px;
      box-shadow: 3px 3px 0px #131218;
    }
    .fcc-info-title-wrap {
      min-width: 100%;
    }
    .fcc-info-main-title {
      font-size: 19px;
    }
    .fcc-info-actions {
      flex-direction: column;
      align-items: stretch;
      width: 100%;
      gap: 10px;
    }
    .fcc-filter-pills {
      width: 100%;
      box-sizing: border-box;
      justify-content: flex-start;
    }
    .fcc-filter-pill-link {
      flex: 1;
      justify-content: center;
      padding: 7px 10px;
      font-size: 11.5px;
    }
    .fcc-btn-add {
      width: 100%;
      justify-content: center;
      min-height: 42px;
    }

    /* Card Stacking on Mobile */
    .fcc-info-card {
      flex-direction: column;
      padding: 16px 14px;
      border-radius: 14px;
      gap: 12px;
    }
    .fcc-info-card:hover {
      box-shadow: 3px 3px 0px #131218;
    }
    .fcc-card-actions {
      width: 100%;
      display: flex;
      justify-content: flex-end;
      padding-top: 10px;
      border-top: 1px dashed #E2E8F0;
      gap: 8px;
    }
    .fcc-btn-edit {
      flex: 1;
      justify-content: center;
      min-height: 38px;
    }
    .fcc-btn-delete {
      min-width: 44px;
      min-height: 38px;
    }

    /* Modal Mobile */
    .fcc-modal-overlay {
      padding: 14px 10px;
    }
    .fcc-modal-box {
      padding: 20px 16px;
      border-radius: 16px;
      box-shadow: 4px 4px 0px #131218;
    }
    .fcc-radio-grid {
      grid-template-columns: 1fr;
      gap: 8px;
    }
    .fcc-time-grid {
      grid-template-columns: 1fr;
      gap: 10px;
    }
    .fcc-modal-footer-btns {
      flex-direction: column-reverse;
      gap: 8px !important;
    }
    .fcc-modal-footer-btns button {
      width: 100%;
      min-height: 42px;
      justify-content: center;
    }
    .fcc-confirm-box {
      padding: 22px 18px;
      border-radius: 16px;
      box-shadow: 4px 4px 0px #131218;
    }
  }

  @media (max-width: 419px) {
    .fcc-info-container {
      padding: 10px 8px;
    }
    .fcc-badge-row {
      gap: 6px;
    }
    .fcc-badge-type, .fcc-badge-status {
      font-size: 10.5px;
      padding: 2.5px 8px;
    }
  }
</style>

{{-- ══ Custom Confirm Delete Modal ════════════════════════════════ --}}
<div id="fcc-confirm-modal" class="fcc-modal-overlay" style="align-items:center;">
    <div class="fcc-confirm-box">
        <div style="width:52px;height:52px;border-radius:14px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:#EF4444;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="confirm-title" style="color:#131218;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Informasi?</h3>
        <p id="confirm-msg" style="color:#64748B;font-size:13px;margin:0 0 24px;line-height:1.5;font-weight:500;"></p>
        <div style="display:flex;gap:10px;justify-content:center;" class="fcc-modal-footer-btns">
            <button type="button" onclick="closeConfirm()" style="padding:10px 20px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:13px;font-weight:800;cursor:pointer;">Batal</button>
            <form id="confirm-delete-form" method="POST" style="margin:0;flex:1;">
                @csrf @method('DELETE')
                <button type="submit" style="width:100%;padding:10px 20px;border-radius:10px;border:1.5px solid #131218;background:#DC2626;color:#FFF;font-size:13px;font-weight:800;cursor:pointer;box-shadow:2px 2px 0px #131218;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ══ Form Modal (Tambah / Edit) ════════════════════════════════ --}}
<div id="info-modal" class="fcc-modal-overlay">
    <div class="fcc-modal-box">
        {{-- Header --}}
        <div class="fcc-modal-head">
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                    <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Form Konten</span>
                </div>
                <h2 id="info-modal-title" style="color:#131218;font-size:18px;font-weight:900;margin:0;font-family:'Outfit',sans-serif;">Tambah Informasi / FAQ</h2>
            </div>
            <button type="button" onclick="closeInfoModal()" class="fcc-modal-close-btn" title="Tutup">&times;</button>
        </div>

        <form id="info-form" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="info-method" value="POST">

            {{-- Jenis --}}
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#475569;margin-bottom:8px;text-transform:uppercase;letter-spacing:.7px;">Pilih Jenis Konten *</label>
                <div class="fcc-radio-grid">
                    @foreach(['info' => '📢 Informasi / Pengumuman', 'faq' => '❓ Pertanyaan FAQ'] as $v => $l)
                    <label class="fcc-radio-option" id="jenis-label-{{ $v }}" onmouseover="this.style.borderColor='#FFC81A'" onmouseout="syncJenisStyle()">
                        <input type="radio" name="jenis" id="modal-jenis-{{ $v }}" value="{{ $v }}" style="accent-color:#131218;" onchange="onJenisChange()">
                        <span>{{ $l }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Judul / Pengumuman --}}
            <div style="margin-bottom:16px;">
                <label id="judul-label-m" style="display:block;font-size:11px;font-weight:800;color:#475569;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Isi Pengumuman *</label>
                <input type="text" name="judul" id="modal-judul" required placeholder="Tulis teks pengumuman..." class="fcc-input" style="width:100%;background:#FFF;border:2px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:700;outline:none;box-sizing:border-box;">
            </div>

            {{-- Isi / Jawaban (hanya FAQ) --}}
            <div id="isi-section-modal" style="margin-bottom:16px;display:none;">
                <label style="display:block;font-size:11px;font-weight:800;color:#475569;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Jawaban / Penjelasan FAQ *</label>
                <textarea name="isi" id="modal-isi" rows="4" placeholder="Tulis jawaban lengkap untuk pertanyaan FAQ ini..." class="fcc-input" style="width:100%;background:#FFF;border:2px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:600;outline:none;resize:vertical;box-sizing:border-box;"></textarea>
            </div>

            {{-- Waktu Tayang (hanya Informasi) --}}
            <div id="tayang-section-modal" style="margin-bottom:18px;background:#FFFDF5;border:1.5px solid #FFC81A;border-radius:12px;padding:14px;box-sizing:border-box;">
                <p style="font-size:11px;font-weight:900;color:#131218;margin:0 0 10px;text-transform:uppercase;letter-spacing:.7px;display:flex;align-items:center;gap:6px;">
                    <span>⏰</span> Jadwal Waktu Tayang Pengumuman
                </p>
                <div class="fcc-time-grid">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:4px;">Mulai Tayang</label>
                        <input type="datetime-local" name="tayang_mulai" id="modal-mulai" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;padding:8px 10px;color:#131218;font-size:12.5px;font-weight:700;box-sizing:border-box;">
                        <p style="font-size:10px;color:#94A3B8;margin:4px 0 0;font-weight:600;">Kosong = langsung aktif</p>
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:4px;">Selesai Tayang</label>
                        <input type="datetime-local" name="tayang_selesai" id="modal-selesai" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;padding:8px 10px;color:#131218;font-size:12.5px;font-weight:700;box-sizing:border-box;">
                        <p style="font-size:10px;color:#94A3B8;margin:4px 0 0;font-weight:600;">Kosong = tidak ada batas</p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div style="border-top:1.5px solid #F1F5F9;padding-top:16px;display:flex;justify-content:flex-end;gap:10px;" class="fcc-modal-footer-btns">
                <button type="button" onclick="closeInfoModal()" style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 22px;font-size:13px;font-weight:900;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;box-shadow:2px 2px 0px #131218;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

{{-- ══ Main Content ════════════════════════════════════════════ --}}
<div class="fcc-info-container">

    {{-- Flash Messages --}}
    @if(session('success'))
      <div style="background:#DEF7EC;border:2px solid #0E9F6E;color:#03543F;border-radius:12px;padding:12px 16px;margin-bottom:18px;font-weight:800;font-size:13px;display:flex;align-items:center;justify-content:space-between;box-shadow:3px 3px 0px #0E9F6E;">
        <div style="display:flex;align-items:center;gap:8px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;font-size:16px;cursor:pointer;color:#03543F;">&times;</button>
      </div>
    @endif

    {{-- Header & Action Bar --}}
    <div class="fcc-info-header">
        <div class="fcc-info-title-wrap">
            <div class="fcc-info-title-row">
                <span class="fcc-info-tag">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Pusat Bantuan &amp; Konten
                </span>
                <h1 class="fcc-info-main-title">Informasi &amp; FAQ</h1>
            </div>
            <p class="fcc-info-sub">Kelola teks pengumuman running banner dan daftar FAQ yang tampil di Landing Page.</p>
        </div>

        <div class="fcc-info-actions">
            {{-- Filter Pills --}}
            <div class="fcc-filter-pills">
                <a href="{{ route('admin.informasi.index') }}" class="fcc-filter-pill-link {{ !request('jenis') ? 'active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('admin.informasi.index', ['jenis' => 'info']) }}" class="fcc-filter-pill-link {{ request('jenis') === 'info' ? 'active' : '' }}">
                    📢 Informasi
                </a>
                <a href="{{ route('admin.informasi.index', ['jenis' => 'faq']) }}" class="fcc-filter-pill-link {{ request('jenis') === 'faq' ? 'active' : '' }}">
                    ❓ FAQ
                </a>
            </div>

            {{-- Add Button --}}
            <button type="button" onclick="openAddModal()" class="fcc-btn-add">
                @include('components.icon',['name'=>'plus','size'=>15])
                <span>Tambah Konten</span>
            </button>
        </div>
    </div>

    {{-- Content List Cards --}}
    <div class="fcc-info-list">
        @forelse($informasi as $i)
        <div class="fcc-info-card">
            <div class="fcc-card-content">
                <div class="fcc-badge-row">
                    @if($i->jenis === 'info')
                        <span class="fcc-badge-type" style="background:#FFFDF5;color:#B38F00;border:1.5px solid #FFC81A;">
                            📢 INFORMASI
                        </span>
                        @php $isAktif = (!$i->tayang_mulai || $i->tayang_mulai <= now()) && (!$i->tayang_selesai || $i->tayang_selesai >= now()); @endphp
                        <span class="fcc-badge-status" style="background:{{ $isAktif ? '#ECFDF5' : '#F1F5F9' }};color:{{ $isAktif ? '#059669' : '#64748B' }};border:1px solid {{ $isAktif ? '#A7F3D0' : '#CBD5E1' }};">
                            {{ $isAktif ? '✓ Aktif Tayang' : '— Tidak Aktif' }}
                        </span>
                    @else
                        <span class="fcc-badge-type" style="background:#EEF2FF;color:#4F46E5;border:1.5px solid #818CF8;">
                            ❓ PERTANYAAN FAQ
                        </span>
                    @endif

                    <span class="fcc-badge-date">
                        <span>📅</span> {{ $i->created_at->format('d M Y') }}
                    </span>
                </div>

                <h3 class="fcc-card-heading">{{ $i->judul }}</h3>
                
                @if($i->jenis === 'faq' && $i->isi)
                    <p class="fcc-card-body-text">{{ Str::limit(strip_tags($i->isi), 160) }}</p>
                @elseif($i->jenis === 'info' && ($i->tayang_mulai || $i->tayang_selesai))
                    <div class="fcc-card-timing">
                        <span>⏰ Jadwal Tayang:</span>
                        <span style="color:#0F172A;font-weight:700;">
                            {{ $i->tayang_mulai ? $i->tayang_mulai->format('d M Y H:i') : 'Langsung' }}
                            —
                            {{ $i->tayang_selesai ? $i->tayang_selesai->format('d M Y H:i') : 'Selamanya' }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="fcc-card-actions">
                <button type="button"
                        onclick="openEditInfoModal({{ json_encode(['id'=>$i->id,'judul'=>$i->judul,'jenis'=>$i->jenis,'isi'=>$i->isi,'tayang_mulai'=>$i->tayang_mulai?->format('Y-m-d\TH:i'),'tayang_selesai'=>$i->tayang_selesai?->format('Y-m-d\TH:i')]) }})"
                        class="fcc-btn-edit"
                        title="Edit Data">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    <span>Edit</span>
                </button>
                <button type="button"
                        onclick="confirmInfoDelete('{{ route('admin.informasi.destroy', $i) }}', '{{ addslashes($i->judul) }}')"
                        class="fcc-btn-delete"
                        title="Hapus Data">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="fcc-card" style="padding:48px 20px;text-align:center;color:#94A3B8;border-radius:18px;border:2px solid #E5E7EB;background:#FFFFFF;">
            <div style="width:52px;height:52px;border-radius:16px;background:#F8FAFC;border:1.5px solid #CBD5E1;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                @include('components.icon',['name'=>'info','size'=>24,'style'=>'color:#64748B'])
            </div>
            <h4 style="font-size:16px;font-weight:900;color:#131218;margin:0 0 4px;">Belum Ada Data Informasi atau FAQ</h4>
            <p style="font-size:13px;color:#64748B;margin:0 0 18px;">
                @if(request('jenis'))
                    Tidak ditemukan konten dengan filter "{{ request('jenis') === 'info' ? 'Informasi' : 'FAQ' }}".
                @else
                    Klik tombol "Tambah Konten" untuk membuat pengumuman atau pertanyaan FAQ baru.
                @endif
            </p>
            @if(request('jenis'))
                <a href="{{ route('admin.informasi.index') }}" style="display:inline-flex;align-items:center;padding:8px 16px;border-radius:10px;background:#F1F5F9;color:#0F172A;font-size:12px;font-weight:800;text-decoration:none;">
                    Tampilkan Semua Konten
                </a>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(method_exists($informasi, 'links'))
    <div style="margin-top:24px;overflow-x:auto;">
        {{ $informasi->withQueryString()->links() }}
    </div>
    @endif
</div>

<script>
const UPDATE_INFO_URLS = @json($informasi->getCollection()->mapWithKeys(fn($i) => [$i->id => route('admin.informasi.update', $i)]));
const STORE_INFO_URL  = '{{ route('admin.informasi.store') }}';

// ── Info Modal Functions ────────────────────────────────
function openAddModal() {
    document.getElementById('info-modal-title').innerText = 'Tambah Informasi / FAQ';
    document.getElementById('info-form').action = STORE_INFO_URL;
    document.getElementById('info-method').value = 'POST';
    document.getElementById('modal-judul').value = '';
    document.getElementById('modal-isi').value = '';
    document.getElementById('modal-mulai').value = '';
    document.getElementById('modal-selesai').value = '';
    document.getElementById('modal-jenis-info').checked = true;
    onJenisChange();
    showModal('info-modal');
}

function openEditInfoModal(data) {
    document.getElementById('info-modal-title').innerText = 'Edit ' + (data.jenis === 'info' ? 'Informasi' : 'FAQ');
    document.getElementById('info-form').action = UPDATE_INFO_URLS[data.id];
    document.getElementById('info-method').value = 'PUT';
    document.getElementById('modal-judul').value = data.judul || '';
    document.getElementById('modal-isi').value = data.isi || '';
    document.getElementById('modal-mulai').value = data.tayang_mulai || '';
    document.getElementById('modal-selesai').value = data.tayang_selesai || '';
    const jenisEl = document.getElementById('modal-jenis-' + data.jenis);
    if (jenisEl) jenisEl.checked = true;
    onJenisChange();
    showModal('info-modal');
}

function closeInfoModal() {
    document.getElementById('info-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function onJenisChange() {
    const isFaq = document.getElementById('modal-jenis-faq')?.checked;
    const isiSec = document.getElementById('isi-section-modal');
    const taySec = document.getElementById('tayang-section-modal');
    const judulLbl = document.getElementById('judul-label-m');
    const judulInp = document.getElementById('modal-judul');
    if (isiSec) isiSec.style.display = isFaq ? 'block' : 'none';
    if (taySec) taySec.style.display = isFaq ? 'none' : 'block';
    if (judulLbl) judulLbl.innerText = isFaq ? 'Pertanyaan FAQ *' : 'Isi Pengumuman *';
    if (judulInp) judulInp.placeholder = isFaq ? 'Tulis pertanyaan FAQ di sini...' : 'Tulis teks pengumuman yang akan berjalan...';
    syncJenisStyle();
}

function syncJenisStyle() {
    const isFaq = document.getElementById('modal-jenis-faq')?.checked;
    ['info', 'faq'].forEach(v => {
        const lbl = document.getElementById('jenis-label-' + v);
        if (!lbl) return;
        const active = (v === 'faq') === isFaq;
        lbl.style.borderColor = active ? '#131218' : '#CBD5E1';
        lbl.style.background = active ? '#FFFDF5' : '#FFF';
        lbl.style.boxShadow = active ? '2px 2px 0px #131218' : 'none';
        lbl.style.color = '#131218';
    });
}

// ── Confirm Delete Functions ────────────────────────────
function confirmInfoDelete(url, name) {
    document.getElementById('confirm-title').innerText = 'Hapus Informasi?';
    document.getElementById('confirm-msg').innerText = `"${name}" akan dihapus secara permanen. Tindakan ini tidak bisa dibatalkan.`;
    document.getElementById('confirm-delete-form').action = url;
    showModal('fcc-confirm-modal');
}

function closeConfirm() {
    document.getElementById('fcc-confirm-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function showModal(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Backdrop clicks
document.getElementById('info-modal').addEventListener('click', function(e) { 
    if (e.target === this) closeInfoModal(); 
});
document.getElementById('fcc-confirm-modal').addEventListener('click', function(e) { 
    if (e.target === this) closeConfirm(); 
});

// Escape key to dismiss modals
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeInfoModal();
        closeConfirm();
    }
});

// Init on load
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('modal-jenis-info').checked = true;
    onJenisChange();
    @if($errors->any())
        openAddModal();
    @endif
});
</script>
@endsection
