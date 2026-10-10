@extends('layouts.admin')
@section('title','Kategori')
@section('page-title','Kategori')
@section('page-content')

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:16px;box-sizing:border-box;">
    <div class="fcc-confirm-box" style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px 28px;max-width:420px;width:92%;box-shadow:0 24px 60px rgba(0,0,0,0.5);text-align:center;position:relative;animation:modalIn .25s ease;box-sizing:border-box;">
        <div id="fcc-confirm-icon" style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.15);border:1.5px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 8px;line-height:1.3;">Hapus Kategori?</h3>
        <p id="fcc-confirm-msg" style="color:rgba(255,255,255,.65);font-size:13.5px;margin:0 0 24px;line-height:1.6;"></p>
        <div class="fcc-confirm-btns" style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <button type="button" onclick="closeConfirm()" style="padding:11px 24px;border-radius:12px;border:1.5px solid rgba(255,255,255,.15);background:rgba(255,255,255,.05);color:rgba(255,255,255,.8);font-size:13.5px;font-weight:700;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">Batal</button>
            <form id="fcc-confirm-form" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="padding:11px 26px;border-radius:12px;border:none;background:linear-gradient(135deg,#EF4444,#DC2626);color:#FFF;font-size:13.5px;font-weight:800;cursor:pointer;box-shadow:0 4px 15px rgba(239,68,68,.3);transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ── Form Modal (Create/Edit) ─────────────────────────────────── --}}
<div id="kategori-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;overflow-y:auto;padding:20px 16px;box-sizing:border-box;">
    <div class="fcc-modal-box" style="background:#1C1B22;border:1px solid rgba(255,255,255,.12);border-radius:20px;padding:30px 28px;max-width:480px;width:92%;box-shadow:0 24px 60px rgba(0,0,0,.5);animation:modalIn .25s ease;margin:auto;position:relative;box-sizing:border-box;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:20px;">
            <div style="flex:1;min-width:0;">
                <h2 id="modal-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 6px;line-height:1.3;">Tambah Kategori Baru</h2>
                <p style="color:rgba(255,255,255,.5);font-size:13px;margin:0;line-height:1.4;">Masukkan nama kategori pelatihan/sertifikasi.</p>
            </div>
            <button type="button" onclick="closeKategoriModal()" aria-label="Tutup" style="width:34px;height:34px;border-radius:10px;border:1.5px solid rgba(255,255,255,.15);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:1;flex-shrink:0;transition:all .18s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">&times;</button>
        </div>

        <form id="kategori-form" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="margin-bottom:22px;">
                <label for="f-nama" style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.6);margin-bottom:8px;text-transform:uppercase;letter-spacing:.8px;">Nama Kategori <span style="color:#EF4444;">*</span></label>
                <input type="text" name="nama_kategori" id="f-nama" required placeholder="Contoh: Desain Grafis" style="width:100%;background:rgba(255,255,255,.06);border:1.5px solid rgba(255,255,255,.15);border-radius:12px;padding:12px 16px;color:#FFF;font-size:14.5px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.15)'" onkeydown="if(event.key==='Enter')event.preventDefault();">
            </div>

            <div class="fcc-modal-footer-btns" style="border-top:1px solid rgba(255,255,255,.08);padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeKategoriModal()" style="padding:11px 22px;border-radius:12px;border:1.5px solid rgba(255,255,255,.15);background:rgba(255,255,255,.05);color:rgba(255,255,255,.75);font-size:13.5px;font-weight:700;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">Batal</button>
                <button type="button" onclick="document.getElementById('kategori-form').submit();" style="padding:11px 26px;border-radius:12px;border:1.5px solid #131218;background:#FFC81A;color:#131218;font-size:13.5px;font-weight:900;cursor:pointer;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Simpan</button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes modalIn {
  from { opacity: 0; transform: scale(.95) translateY(10px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
}
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
#kategori-skeleton-overlay {
  transition: opacity 0.35s ease, visibility 0.35s ease;
}

/* ── Base Responsive View Rules ── */
.fcc-kategori-desktop-table {
  display: block;
}
.fcc-kategori-mobile-list {
  display: none;
}
.fcc-kategori-stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

/* ── Tablet & Small Laptops (768px – 1023px) ── */
@media (max-width: 1023px) {
  .fcc-kategori-container {
    padding: 20px 16px !important;
  }
  .fcc-kategori-stats-grid {
    gap: 12px !important;
    margin-bottom: 20px !important;
  }
}

/* ── Switch to Mobile Cards (< 768px) ── */
@media (max-width: 767px) {
  .fcc-kategori-container {
    padding: 16px 14px 44px !important;
  }
  .fcc-kategori-desktop-table {
    display: none !important;
  }
  /* Remove double-nested card on mobile: let cards breathe on the page background */
  .fcc-kategori-main-card {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    border-radius: 0 !important;
    overflow: visible !important;
  }
  .fcc-kategori-card-header {
    padding: 0 4px 14px 4px !important;
    background: transparent !important;
    border-bottom: none !important;
  }
  .fcc-kategori-mobile-list {
    display: flex !important;
    flex-direction: column !important;
    gap: 14px !important;
    padding: 0 !important;
    background: transparent !important;
  }
  .fcc-kategori-stats-grid {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 10px !important;
    margin-bottom: 22px !important;
  }
  .fcc-kategori-stats-grid > div:last-child {
    grid-column: span 2 !important;
  }
  /* Floating Pagination Capsule on Mobile */
  .fcc-pagination-bar {
    background: #FFFFFF !important;
    border: 1.5px solid #E2E8F0 !important;
    border-radius: 16px !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03) !important;
    padding: 16px 14px !important;
    margin-top: 8px !important;
    flex-direction: column !important;
    align-items: center !important;
    text-align: center !important;
    gap: 14px !important;
  }
  .fcc-pagination-bar > div {
    justify-content: center !important;
    width: 100% !important;
  }
}

/* ── Standard Mobile (< 640px) ── */
@media (max-width: 639px) {
  .fcc-kategori-container {
    padding: 14px 12px !important;
  }
  .fcc-kategori-header {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 14px !important;
    margin-bottom: 18px !important;
  }
  .fcc-kategori-header-btn {
    width: 100% !important;
    justify-content: center !important;
    padding: 11px 18px !important;
    font-size: 13.5px !important;
  }
  .fcc-kategori-filter-wrap {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
  }
  .fcc-kategori-filter-input-wrap {
    width: 100% !important;
  }
  .fcc-kategori-filter-actions {
    display: flex !important;
    width: 100% !important;
    gap: 8px !important;
  }
  .fcc-kategori-filter-actions button,
  .fcc-kategori-filter-actions a {
    flex: 1 !important;
    justify-content: center !important;
    text-align: center !important;
  }
  .fcc-kategori-card-header {
    padding: 14px 16px !important;
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 10px !important;
  }
  .fcc-kategori-card-header > div:last-child {
    width: 100% !important;
    display: flex !important;
    justify-content: flex-start !important;
  }
  .fcc-modal-box {
    padding: 22px 16px !important;
    border-radius: 18px !important;
    width: 95% !important;
    max-height: 90vh !important;
  }
  .fcc-modal-footer-btns {
    flex-direction: column-reverse !important;
    gap: 10px !important;
  }
  .fcc-modal-footer-btns button {
    width: 100% !important;
    justify-content: center !important;
    padding: 12px 20px !important;
  }
  .fcc-confirm-box {
    padding: 24px 16px !important;
    border-radius: 18px !important;
    width: 94% !important;
  }
  .fcc-confirm-btns {
    flex-direction: column-reverse !important;
    gap: 10px !important;
  }
  .fcc-confirm-btns button,
  .fcc-confirm-btns form {
    width: 100% !important;
  }
  .fcc-confirm-btns form button {
    width: 100% !important;
    justify-content: center !important;
  }
}

/* ── Compact Phone (< 420px) ── */
@media (max-width: 419px) {
  .fcc-kategori-container {
    padding: 12px 10px !important;
  }
  .fcc-kategori-stats-grid {
    grid-template-columns: 1fr !important;
    gap: 10px !important;
  }
  .fcc-kategori-stats-grid > div:last-child {
    grid-column: auto !important;
  }
  .fcc-kategori-mobile-list {
    padding: 10px !important;
    gap: 10px !important;
  }
  .fcc-mobile-card-actions {
    flex-direction: column !important;
    gap: 8px !important;
  }
  .fcc-mobile-card-actions button {
    width: 100% !important;
    justify-content: center !important;
  }
}
</style>

<div class="fcc-kategori-container" style="padding:24px;position:relative;">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <div id="kategori-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:inherit;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:14px;">
        <div style="flex:1;min-width:220px;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:240px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:200px;height:12px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:180px;height:42px;border-radius:30px;"></div>
      </div>

      {{-- Stats Skeleton --}}
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:14px;margin-bottom:22px;">
        @for($sk=0; $sk<3; $sk++)
        <div style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:14px;">
          <div class="fcc-skeleton-box" style="width:44px;height:44px;border-radius:12px;flex-shrink:0;"></div>
          <div style="flex:1;">
            <div class="fcc-skeleton-box" style="width:65%;height:12px;margin-bottom:6px;"></div>
            <div class="fcc-skeleton-box" style="width:40%;height:20px;"></div>
          </div>
        </div>
        @endfor
      </div>

      {{-- Filter Skeleton --}}
      <div style="padding:16px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;margin-bottom:20px;">
        <div class="fcc-skeleton-box" style="width:100%;height:40px;border-radius:10px;"></div>
      </div>

      {{-- Table Skeleton --}}
      <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('kategori-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div class="fcc-kategori-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;flex-wrap:wrap;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;flex-shrink:0;">Klasifikasi &amp; Tagging</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Daftar Kategori</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola semua kategori program pelatihan &amp; sertifikasi.</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <button type="button" onclick="openKategoriModal()" class="fcc-kategori-header-btn"
                    style="padding:10px 20px;font-size:13.5px;font-weight:900;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(0,0,0,0.12);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;white-space:nowrap;"
                    onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                @include('components.icon',['name'=>'plus','size'=>16]) Tambah Kategori Baru
            </button>
        </div>
    </div>

    {{-- Neo-Brutalist Stat Cards Grid --}}
    <div class="fcc-kategori-stats-grid">
        {{-- Total Kategori --}}
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'tag','size'=>20])
            </div>
            <div style="min-width:0;">
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Kategori</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ $totalKategori ?? $kategori->total() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Kategori</span>
                </p>
            </div>
        </div>

        {{-- Terhubung Pelatihan --}}
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#B38F00;flex-shrink:0;">
                @include('components.icon',['name'=>'book','size'=>20])
            </div>
            <div style="min-width:0;">
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Pelatihan Terhubung</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ $totalPelatihan ?? 0 }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span>
                </p>
            </div>
        </div>

        {{-- Terhubung Sertifikasi --}}
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div style="min-width:0;">
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Sertifikasi Terhubung</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ $totalSertifikasi ?? 0 }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="fcc-card" style="margin-bottom:20px;padding:16px 20px;background:#FFF;border-radius:18px;border:2px solid #E5E7EB;box-shadow:0 2px 10px rgba(0,0,0,0.02);">
        <form method="GET" action="{{ route('admin.kategori.index') }}" class="fcc-kategori-filter-wrap" style="display:flex;align-items:center;gap:12px;margin:0;">
            <div class="fcc-kategori-filter-input-wrap" style="flex:1;position:relative;">
                <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94A3B8;pointer-events:none;display:flex;">
                    @include('components.icon',['name'=>'search','size'=>16])
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..."
                       style="width:100%;box-sizing:border-box;padding:10px 14px 10px 40px;background:#F8FAFC;border:1.5px solid #CBD5E1;border-radius:12px;color:#131218;font-size:13.5px;font-weight:600;outline:none;transition:border-color .18s;"
                       onfocus="this.style.borderColor='#131218';this.style.background='#FFF';"
                       onblur="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC';">
            </div>
            <div class="fcc-kategori-filter-actions" style="display:flex;align-items:center;gap:8px;">
                <button type="submit"
                        style="padding:10px 20px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:12px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .18s;white-space:nowrap;"
                        onmouseover="this.style.background='#FFC81A';this.style.color='#131218';"
                        onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                    @include('components.icon',['name'=>'filter','size'=>14]) Filter
                </button>
                @if(request('search'))
                <a href="{{ route('admin.kategori.index') }}"
                   style="padding:10px 16px;font-size:13px;font-weight:800;background:#F1F5F9;color:#64748B;border:1.5px solid #CBD5E1;border-radius:12px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .18s;white-space:nowrap;"
                   onmouseover="this.style.background='#E2E8F0';this.style.color='#131218';"
                   onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';">
                    @include('components.icon',['name'=>'x','size'=>14]) Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card fcc-kategori-main-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div class="fcc-kategori-card-header" style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Master Kategori Program</h3>
            </div>
            <div>
                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;white-space:nowrap;display:inline-block;">
                    @if(request('search'))
                        {{ $kategori->total() }} Ditemukan
                    @else
                        {{ $kategori->total() }} Kategori
                    @endif
                </span>
            </div>
        </div>

        {{-- Desktop Table View (>= 768px) --}}
        <div class="fcc-kategori-desktop-table" style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:55px;">No</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Nama Kategori</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:170px;">Total Pelatihan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:170px;">Total Sertifikasi</th>
                        <th style="padding:14px 20px;text-align:right;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $kat)
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        {{-- No --}}
                        <td style="padding:16px 16px;text-align:center;vertical-align:middle;color:#64748B;font-weight:800;font-size:13px;">
                            <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;">
                                {{ $kategori->firstItem() + $index }}
                            </span>
                        </td>

                        {{-- Nama Kategori --}}
                        <td style="padding:16px 20px;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:36px;height:36px;border-radius:10px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;font-weight:900;flex-shrink:0;font-size:15px;">
                                    🏷️
                                </div>
                                <span style="font-size:14px;font-weight:900;color:#131218;word-break:break-word;">{{ $kat->nama_kategori }}</span>
                            </div>
                        </td>

                        {{-- Total Pelatihan --}}
                        <td style="padding:16px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:800;padding:4px 12px;border-radius:20px;background:#FFFDF5;color:#B38F00;border:1px solid #FFC81A;display:inline-block;white-space:nowrap;">
                                {{ $kat->pelatihan_count }} Program
                            </span>
                        </td>

                        {{-- Total Sertifikasi --}}
                        <td style="padding:16px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:800;padding:4px 12px;border-radius:20px;background:#EEF2FF;color:#4F46E5;border:1px solid #818CF8;display:inline-block;white-space:nowrap;">
                                {{ $kat->sertifikasi_count }} Program
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:16px 20px;text-align:right;vertical-align:middle;">
                            <div style="display:inline-flex;gap:6px;align-items:center;justify-content:flex-end;">
                                <button type="button" onclick="openEditKategoriModal({{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}')" title="Edit Kategori"
                                        style="width:34px;height:34px;border-radius:8px;border:1.5px solid #CBD5E1;background:#FFF;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;"
                                        onmouseover="this.style.borderColor='#131218';this.style.background='#FFC81A';" onmouseout="this.style.borderColor='#CBD5E1';this.style.background='#FFF';">
                                    @include('components.icon',['name'=>'edit','size'=>14])
                                </button>
                                <button type="button" onclick="confirmKategoriDelete('{{ route('admin.kategori.destroy', $kat->hashid) }}', '{{ addslashes($kat->nama_kategori) }}')" title="Hapus Kategori"
                                        style="width:34px;height:34px;border-radius:8px;border:1.5px solid #FCA5A5;background:#FEF2F2;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;"
                                        onmouseover="this.style.background='#EF4444';this.style.color='#FFF';this.style.borderColor='#DC2626';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                                    @include('components.icon',['name'=>'trash','size'=>14])
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px 20px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'tag','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">
                                @if(request('search'))
                                    Kategori Tidak Ditemukan
                                @else
                                    Belum Ada Kategori Ditemukan
                                @endif
                            </p>
                            <p style="font-size:12.5px;color:#64748B;margin:0 0 14px;">
                                @if(request('search'))
                                    Tidak ada data kategori yang cocok dengan pencarian "{{ request('search') }}".
                                @else
                                    Klik tombol "Tambah Kategori Baru" untuk menambahkan kategori pertama.
                                @endif
                            </p>
                            @if(request('search'))
                            <a href="{{ route('admin.kategori.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;font-size:12.5px;font-weight:800;background:#131218;color:#FFC81A;border-radius:20px;text-decoration:none;">
                                @include('components.icon',['name'=>'refresh-cw','size'=>12]) Tampilkan Semua Kategori
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards List View (< 768px) --}}
        <div class="fcc-kategori-mobile-list">
            @forelse($kategori as $index => $kat)
            <div class="fcc-mobile-card-item" style="background:#FFFFFF;border:1.5px solid #E2E8F0;border-left:4px solid #FFC81A;border-radius:16px;padding:16px 18px;box-shadow:0 3px 12px rgba(0,0,0,0.03);display:flex;flex-direction:column;gap:12px;">
                {{-- Header Item: Number, Icon, Title --}}
                <div style="display:flex;align-items:flex-start;gap:10px;">
                    <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;font-size:12px;flex-shrink:0;">
                        {{ $kategori->firstItem() + $index }}
                    </span>
                    <div style="width:34px;height:34px;border-radius:10px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;font-size:15px;flex-shrink:0;">
                        🏷️
                    </div>
                    <div style="flex:1;min-width:0;">
                        <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;line-height:1.35;word-break:break-word;">
                            {{ $kat->nama_kategori }}
                        </h4>
                    </div>
                </div>

                {{-- Badges Row --}}
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;padding:10px 12px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
                    <span style="font-size:11.5px;font-weight:800;padding:4px 10px;border-radius:20px;background:#FFFDF5;color:#B38F00;border:1px solid #FFC81A;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                        📚 {{ $kat->pelatihan_count }} Pelatihan
                    </span>
                    <span style="font-size:11.5px;font-weight:800;padding:4px 10px;border-radius:20px;background:#EEF2FF;color:#4F46E5;border:1px solid #818CF8;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                        🏆 {{ $kat->sertifikasi_count }} Sertifikasi
                    </span>
                </div>

                {{-- Actions Row --}}
                <div class="fcc-mobile-card-actions" style="display:flex;gap:8px;justify-content:flex-end;padding-top:4px;border-top:1px dashed #E2E8F0;">
                    <button type="button" onclick="openEditKategoriModal({{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}')"
                            style="flex:1;padding:9px 14px;border-radius:10px;border:1.5px solid #CBD5E1;background:#FFFFFF;color:#131218;font-size:12.5px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .18s;"
                            onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';"
                            onmouseout="this.style.background='#FFFFFF';this.style.borderColor='#CBD5E1';">
                        @include('components.icon',['name'=>'edit','size'=>14]) Edit
                    </button>
                    <button type="button" onclick="confirmKategoriDelete('{{ route('admin.kategori.destroy', $kat->hashid) }}', '{{ addslashes($kat->nama_kategori) }}')"
                            style="flex:1;padding:9px 14px;border-radius:10px;border:1.5px solid #FCA5A5;background:#FEF2F2;color:#EF4444;font-size:12.5px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;transition:all .18s;"
                            onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';this.style.borderColor='#DC2626';"
                            onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                        @include('components.icon',['name'=>'trash','size'=>14]) Hapus
                    </button>
                </div>
            </div>
            @empty
            <div style="padding:36px 16px;text-align:center;color:#94A3B8;background:#FFFFFF;border-radius:16px;">
                <div style="width:48px;height:48px;border-radius:14px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    @include('components.icon',['name'=>'tag','size'=>22,'style'=>'color:#9CA3B0'])
                </div>
                <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 4px;">
                    @if(request('search'))
                        Kategori Tidak Ditemukan
                    @else
                        Belum Ada Kategori
                    @endif
                </p>
                <p style="font-size:12px;color:#64748B;margin:0 0 12px;">
                    @if(request('search'))
                        Tidak ada data yang cocok dengan "{{ request('search') }}".
                    @else
                        Ketuk tombol "Tambah Kategori Baru" di atas.
                    @endif
                </p>
                @if(request('search'))
                <a href="{{ route('admin.kategori.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:20px;text-decoration:none;">
                    @include('components.icon',['name'=>'refresh-cw','size'=>12]) Reset Pencarian
                </a>
                @endif
            </div>
            @endforelse
        </div>

        @if($kategori->hasPages())
        <div class="fcc-pagination-wrap" style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;">
            {{ $kategori->links() }}
        </div>
        @endif
    </div>
</div>

<script>
const STORE_URL = '{{ route('admin.kategori.store') }}';
const UPDATE_URLS = @json($kategori->pluck('hashid', 'id')->map(fn($hashid) => route('admin.kategori.update', $hashid)));

function openKategoriModal() {
    document.getElementById('modal-title').innerText = 'Tambah Kategori Baru';
    document.getElementById('kategori-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    const input = document.getElementById('f-nama');
    input.value = '';
    showModal('kategori-modal');
    setTimeout(() => input.focus(), 80);
}

function openEditKategoriModal(id, nama) {
    document.getElementById('modal-title').innerText = 'Edit Kategori';
    document.getElementById('kategori-form').action = UPDATE_URLS[id] || '';
    document.getElementById('form-method').value = 'PUT';
    const input = document.getElementById('f-nama');
    input.value = nama;
    showModal('kategori-modal');
    setTimeout(() => input.focus(), 80);
}

function closeKategoriModal() {
    document.getElementById('kategori-modal').style.display = 'none';
}

function confirmKategoriDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Kategori?';
    document.getElementById('fcc-confirm-msg').innerText = `Kategori "${name}" akan dihapus. Pelatihan dan Sertifikasi yang terkait mungkin akan kehilangan data kategori ini.`;
    document.getElementById('fcc-confirm-form').action = url;
    showModal('fcc-confirm-modal');
}

function closeConfirm() {
    document.getElementById('fcc-confirm-modal').style.display = 'none';
}

function showModal(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close on backdrop click
document.getElementById('kategori-modal').addEventListener('click', function(e) {
    if (e.target === this) closeKategoriModal();
});
document.getElementById('fcc-confirm-modal').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeKategoriModal();
        closeConfirm();
    }
});

// Watch overflow state
[document.getElementById('kategori-modal'), document.getElementById('fcc-confirm-modal')].forEach(el => {
    if (!el) return;
    const obs = new MutationObserver(() => {
        const visible = (document.getElementById('kategori-modal').style.display !== 'none') ||
                        (document.getElementById('fcc-confirm-modal').style.display !== 'none');
        document.body.style.overflow = visible ? 'hidden' : '';
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endsection
