@extends('layouts.admin')
@section('title', 'No. Rekening')
@section('page-content')

<style>
/* ─── Global Scoped Styles: Rekening Admin ─────────────────────── */
.fcc-rekening-container {
    padding: 24px 28px;
    box-sizing: border-box;
    width: 100%;
}

/* ─── Header & Action Bar ────────────────────────────────────── */
.fcc-rekening-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 16px;
}
.fcc-rekening-header-left {
    flex: 1;
    min-width: 0;
}
.fcc-rekening-badge-tag {
    font-size: 11px;
    font-weight: 900;
    color: #131218;
    background: #FFC81A;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid #131218;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    margin-bottom: 6px;
}
.fcc-rekening-title {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 0 0 4px;
    letter-spacing: -0.02em;
    font-family: 'Outfit', sans-serif;
    line-height: 1.25;
}
.fcc-rekening-subtitle {
    color: #64748B;
    font-size: 13px;
    margin: 0;
    font-weight: 500;
    line-height: 1.45;
}
.fcc-rekening-btn-add {
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 900;
    background: #FFC81A;
    color: #131218;
    border-radius: 12px;
    border: 1.5px solid #131218;
    box-shadow: 2px 2px 0px #131218;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all .15s ease-in-out;
    white-space: nowrap;
    text-decoration: none;
    flex-shrink: 0;
}
.fcc-rekening-btn-add:hover {
    background: #FFD447;
    transform: translateY(-1px);
    box-shadow: 2px 3px 0px #131218;
}
.fcc-rekening-btn-add:active {
    transform: translateY(1px);
    box-shadow: 1px 1px 0px #131218;
}
.fcc-rekening-readonly-badge {
    font-size: 12px;
    font-weight: 800;
    padding: 7px 14px;
    border-radius: 20px;
    background: #F1F5F9;
    color: #64748B;
    border: 1.5px solid #CBD5E1;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

/* ─── Search & Filter Toolbar ────────────────────────────────── */
.fcc-rekening-toolbar-card {
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    border-radius: 18px;
    padding: 14px 18px;
    margin-bottom: 22px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    box-sizing: border-box;
}
.fcc-rekening-toolbar-top-mobile {
    display: none;
}
.fcc-rekening-filter-form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin: 0;
    width: 100%;
    box-sizing: border-box;
    flex-wrap: wrap;
}
.fcc-rekening-filter-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 0;
    flex-wrap: wrap;
}
.fcc-rekening-search-box {
    position: relative;
    flex: 1;
    min-width: 180px;
    max-width: 320px;
}
.fcc-rekening-search-icon {
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
.fcc-rekening-search-input {
    width: 100% !important;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid #CBD5E1;
    font-size: 13px;
    padding: 0 32px 0 34px !important;
    background: #FFFFFF;
    box-sizing: border-box;
    color: #131218;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.fcc-rekening-search-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
    background: #FFFFFF;
}
.fcc-rekening-search-clear {
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
.fcc-rekening-search-clear:hover {
    background: #CBD5E1;
    color: #0F172A;
}
.fcc-rekening-btn-search {
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
.fcc-rekening-btn-search:hover {
    background: #FFD447;
    transform: translateY(-1px);
    box-shadow: 2px 3px 0px #131218;
}
.fcc-rekening-btn-reset {
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
.fcc-rekening-btn-reset:hover {
    background: #FEE2E2;
    border-color: #EF4444;
    color: #DC2626;
}
.fcc-rekening-badge-wrap {
    display: flex;
    align-items: center;
    flex-shrink: 0;
}
.fcc-rekening-total-pill {
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
.fcc-rekening-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #131218;
    display: inline-block;
    flex-shrink: 0;
}

/* ─── Cards Grid ─────────────────────────────────────────────── */
.fcc-rekening-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 20px;
    box-sizing: border-box;
    width: 100%;
}
.rekening-card-admin {
    background: #FFFFFF;
    border-radius: 20px;
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    transition: all .2s cubic-bezier(.4, 0, .2, 1);
}
.rekening-card-admin.active {
    border: 2.5px solid #131218;
    box-shadow: 0 8px 24px rgba(255, 200, 26, 0.16), 2.5px 2.5px 0px #131218;
}
.rekening-card-admin.inactive {
    border: 2px solid #E5E7EB;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
}
.rekening-card-admin:hover {
    border-color: #131218;
    transform: translateY(-2px);
}
.fcc-rekening-card-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 16px;
    gap: 10px;
}
.fcc-rekening-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.fcc-rekening-card-icon.active {
    background: #131218;
    border: 2px solid #FFC81A;
    box-shadow: 1.5px 1.5px 0px #FFC81A;
}
.fcc-rekening-card-icon.inactive {
    background: #F8FAFC;
    border: 1.5px solid #CBD5E1;
}
.fcc-rekening-card-status-badge {
    font-size: 10.5px;
    font-weight: 900;
    padding: 4px 10px;
    border-radius: 12px;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    line-height: 1.2;
}
.fcc-rekening-card-status-badge.active {
    background: #FFFDF5;
    color: #92400E;
    border: 1.5px solid #FFC81A;
}
.fcc-rekening-card-status-badge.inactive {
    background: #F8FAFC;
    color: #64748B;
    border: 1.5px solid #CBD5E1;
}
.fcc-rekening-card-bank {
    font-size: 17px;
    font-weight: 900;
    color: #131218;
    margin: 0 0 6px;
    font-family: 'Outfit', sans-serif;
    line-height: 1.3;
}
.fcc-rekening-number-box {
    background: #F8FAFC;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px;
    padding: 8px 12px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    box-sizing: border-box;
    transition: border-color .15s;
}
.fcc-rekening-number-text {
    font-family: 'JetBrains Mono', 'Courier New', Courier, monospace;
    font-size: 17px;
    font-weight: 900;
    color: #131218;
    letter-spacing: 0.8px;
    word-break: break-all;
    line-height: 1.3;
}
.fcc-rekening-btn-copy {
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    padding: 4px 8px;
    font-size: 11px;
    font-weight: 800;
    color: #475569;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all .15s;
    white-space: nowrap;
    flex-shrink: 0;
}
.fcc-rekening-btn-copy:hover {
    background: #FFC81A;
    border-color: #131218;
    color: #131218;
}
.fcc-rekening-card-owner {
    font-size: 13px;
    color: #64748B;
    margin: 0 0 18px;
    font-weight: 600;
    line-height: 1.4;
    word-break: break-word;
}
.fcc-rekening-card-owner strong {
    color: #131218;
    font-weight: 800;
}
.fcc-rekening-card-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    border-top: 1.5px solid #F1F5F9;
    padding-top: 14px;
    margin-top: auto;
}
.fcc-rekening-btn-activate {
    flex: 1;
    min-height: 38px;
    padding: 0 12px;
    border-radius: 10px;
    border: 1.5px solid #131218;
    background: #131218;
    color: #FFC81A;
    font-size: 12px;
    font-weight: 900;
    cursor: pointer;
    transition: all .15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
}
.fcc-rekening-btn-activate:hover {
    background: #FFC81A;
    color: #131218;
}
.fcc-rekening-btn-edit {
    flex: 1;
    min-height: 38px;
    padding: 0 12px;
    border-radius: 10px;
    border: 1.5px solid #131218;
    background: #FFFFFF;
    color: #131218;
    font-size: 12px;
    font-weight: 900;
    cursor: pointer;
    transition: all .15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
}
.fcc-rekening-btn-edit:hover {
    background: #FFC81A;
}
.fcc-rekening-btn-delete {
    min-height: 38px;
    padding: 0 12px;
    border-radius: 10px;
    border: 1.5px solid #FCA5A5;
    background: #FEF2F2;
    color: #DC2626;
    font-size: 12px;
    font-weight: 800;
    cursor: pointer;
    transition: all .15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.fcc-rekening-btn-delete:hover {
    background: #DC2626;
    color: #FFFFFF;
    border-color: #DC2626;
}

/* ─── Modal Styles ───────────────────────────────────────────── */
.fcc-rekening-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9998;
    background: rgba(19, 18, 24, 0.65);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    align-items: center;
    justify-content: center;
    padding: 16px;
    box-sizing: border-box;
    overflow-y: auto;
}
.fcc-rekening-modal-card {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 22px;
    padding: 26px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 24px 64px rgba(0,0,0,0.35);
    animation: modalIn .22s cubic-bezier(.4, 0, .2, 1);
    box-sizing: border-box;
    position: relative;
    max-height: calc(100vh - 40px);
    max-height: calc(100dvh - 40px);
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.96) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.fcc-rekening-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    border-bottom: 2px solid #E5E7EB;
    padding-bottom: 14px;
    gap: 12px;
}
.fcc-rekening-modal-close {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1.5px solid #131218;
    background: #FFFFFF;
    color: #131218;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    line-height: 1;
    font-weight: 900;
    transition: all .15s;
    flex-shrink: 0;
}
.fcc-rekening-modal-close:hover {
    background: #FFC81A;
}
.fcc-rekening-form-group {
    margin-bottom: 16px;
}
.fcc-rekening-form-label {
    display: block;
    font-size: 11px;
    font-weight: 800;
    color: #64748B;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: .6px;
}
.fcc-rekening-form-input {
    width: 100% !important;
    background: #FFFFFF;
    border: 1.5px solid #CBD5E1;
    border-radius: 10px;
    padding: 10px 14px;
    color: #131218;
    font-size: 13.5px;
    font-weight: 600;
    outline: none;
    box-sizing: border-box;
    transition: border-color .15s, box-shadow .15s;
    min-height: 42px;
}
.fcc-rekening-form-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
}
.fcc-rekening-modal-footer {
    border-top: 1.5px solid #E2E4EB;
    padding-top: 18px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 6px;
}
.fcc-rekening-btn-cancel {
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 800;
    background: #FFFFFF;
    color: #131218;
    border: 1.5px solid #131218;
    border-radius: 10px;
    cursor: pointer;
    transition: all .15s;
    min-height: 40px;
}
.fcc-rekening-btn-cancel:hover {
    background: #F1F5F9;
}
.fcc-rekening-btn-submit {
    padding: 10px 24px;
    font-size: 13px;
    font-weight: 900;
    background: #131218;
    color: #FFC81A;
    border: 1.5px solid #131218;
    border-radius: 10px;
    cursor: pointer;
    transition: all .15s;
    box-shadow: 2px 2px 0px #131218;
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.fcc-rekening-btn-submit:hover {
    background: #FFC81A;
    color: #131218;
    transform: translateY(-1px);
}

/* ─── Responsive Breakpoints ─────────────────────────────────── */
/* Tablet / iPad (640px to 1023px) */
@media (max-width: 1023px) and (min-width: 640px) {
    .fcc-rekening-container {
        padding: 20px 16px;
    }
    .fcc-rekening-grid {
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 16px;
    }
    .fcc-rekening-search-box {
        min-width: 160px;
        max-width: 260px;
    }
    .fcc-rekening-btn-search {
        padding: 0 14px;
        font-size: 12px;
    }
    .fcc-rekening-total-pill {
        font-size: 11px;
        padding: 3px 10px;
        box-shadow: 1.5px 1.5px 0px #131218;
    }
}

/* Mobile Devices (< 640px) */
@media (max-width: 639px) {
    .fcc-rekening-container {
        padding: 14px 12px;
    }
    .fcc-rekening-header {
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
        margin-bottom: 16px;
    }
    .fcc-rekening-header-left {
        width: 100%;
    }
    .fcc-rekening-title {
        font-size: 20px;
    }
    .fcc-rekening-btn-add {
        width: 100%;
        min-height: 44px;
        justify-content: center;
        font-size: 13.5px;
    }
    .fcc-rekening-readonly-badge {
        width: 100%;
        box-sizing: border-box;
        justify-content: center;
    }
    .fcc-rekening-toolbar-card {
        padding: 12px 14px;
        border-radius: 16px;
        margin-bottom: 16px;
    }
    .fcc-rekening-toolbar-top-mobile {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1.5px dashed #E2E8F0;
        width: 100%;
        box-sizing: border-box;
    }
    .fcc-rekening-toolbar-title-box {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }
    .fcc-rekening-toolbar-top-mobile .fcc-rekening-total-pill {
        font-size: 11px;
        padding: 3.5px 10px;
        box-shadow: 1.5px 1.5px 0px #131218;
    }
    .fcc-rekening-badge-wrap-desktop {
        display: none !important;
    }
    .fcc-rekening-filter-form {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    .fcc-rekening-filter-left {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        gap: 8px;
    }
    .fcc-rekening-search-box {
        width: 100% !important;
        max-width: 100% !important;
    }
    .fcc-rekening-search-input {
        min-height: 40px;
        font-size: 13px;
    }
    .fcc-rekening-mobile-btn-row {
        display: flex;
        gap: 8px;
        width: 100%;
    }
    .fcc-rekening-btn-search,
    .fcc-rekening-btn-reset {
        flex: 1;
        min-height: 40px;
    }
    .fcc-rekening-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .rekening-card-admin {
        padding: 16px;
        border-radius: 16px;
    }
    .fcc-rekening-card-actions {
        gap: 8px;
    }
    .fcc-rekening-btn-activate,
    .fcc-rekening-btn-edit {
        min-height: 40px;
        font-size: 12.5px;
    }
    .fcc-rekening-btn-delete {
        min-height: 40px;
        padding: 0 14px;
    }
    .fcc-rekening-modal-card {
        padding: 20px 16px;
        border-radius: 18px;
    }
    .fcc-rekening-modal-footer {
        flex-direction: column-reverse;
        gap: 8px;
    }
    .fcc-rekening-btn-cancel,
    .fcc-rekening-btn-submit {
        width: 100%;
        justify-content: center;
        min-height: 42px;
    }
}
</style>

<div class="fcc-rekening-container">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="padding:12px 18px;border-radius:14px;background:#ECFDF5;border:2px solid #10B981;color:#065F46;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 14px rgba(16,185,129,0.12);">
        <div style="display:flex;align-items:center;gap:10px;">
            @include('components.icon',['name'=>'check','size'=>18,'style'=>'color:#059669;flex-shrink:0'])
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#059669;cursor:pointer;font-size:20px;line-height:1;font-weight:900;">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 18px;border-radius:14px;background:#FEF2F2;border:2px solid #EF4444;color:#991B1B;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 14px rgba(239,68,68,0.12);">
        <div style="display:flex;align-items:center;gap:10px;">
            @include('components.icon',['name'=>'x','size'=>18,'style'=>'color:#DC2626;flex-shrink:0'])
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#DC2626;cursor:pointer;font-size:20px;line-height:1;font-weight:900;">&times;</button>
    </div>
    @endif

    {{-- Header & Action Bar --}}
    <div class="fcc-rekening-header">
        <div class="fcc-rekening-header-left">
            <span class="fcc-rekening-badge-tag">Keuangan &amp; Rekening</span>
            <h1 class="fcc-rekening-title">Nomor Rekening Pembayaran</h1>
            <p class="fcc-rekening-subtitle">Kelola rekening tujuan pembayaran peserta. Hanya satu rekening yang aktif di website.</p>
        </div>

        <div>
            @if(auth('admin')->user()?->isSuperAdmin())
            <button type="button" onclick="openAddRekeningModal()" class="fcc-rekening-btn-add">
                @include('components.icon',['name'=>'plus','size'=>15]) Tambah Rekening Baru
            </button>
            @else
            <span class="fcc-rekening-readonly-badge">
                🔒 Mode Lihat Saja (Super Admin Only)
            </span>
            @endif
        </div>
    </div>

    {{-- Info Alert for Regular Admin --}}
    @if(!auth('admin')->user()?->isSuperAdmin())
    <div style="padding:12px 18px;border-radius:14px;background:#EEF2FF;border:1.5px solid #818CF8;color:#4F46E5;font-size:13px;font-weight:800;margin-bottom:20px;display:flex;align-items:center;gap:10px;box-shadow:0 2px 10px rgba(79,70,229,0.08);">
        <span style="font-size:16px;">ℹ️</span>
        <span>Informasi: Anda masuk sebagai Admin Biasa. Perubahan dan pengaturan nomor rekening hanya dapat dilakukan oleh Super Admin.</span>
    </div>
    @endif

    {{-- Search & Filter Toolbar --}}
    <div class="fcc-rekening-toolbar-card">
        {{-- Mobile Top Row with Counter Badge --}}
        <div class="fcc-rekening-toolbar-top-mobile">
            <div class="fcc-rekening-toolbar-title-box">
                @include('components.icon',['name'=>'filter','size'=>13,'style'=>'color:#475569;'])
                <span>Filter &amp; Pencarian</span>
            </div>
            <span class="fcc-rekening-total-pill">
                <span class="fcc-rekening-badge-dot"></span>
                {{ $rekening->total() }} Total Rekening
            </span>
        </div>

        <form method="GET" action="{{ route('admin.rekening.index') }}" class="fcc-rekening-filter-form">
            <div class="fcc-rekening-filter-left">
                {{-- Search Box --}}
                <div class="fcc-rekening-search-box">
                    <span class="fcc-rekening-search-icon">
                        @include('components.icon',['name'=>'search','size'=>14])
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari bank, no. rekening, pemilik..." class="fcc-input fcc-rekening-search-input" autocomplete="off">
                    @if(request('q'))
                    <a href="{{ route('admin.rekening.index') }}" class="fcc-rekening-search-clear" title="Hapus pencarian">✕</a>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="fcc-rekening-mobile-btn-row">
                    <button type="submit" class="fcc-rekening-btn-search">
                        <span>Cari</span>
                        <span style="font-size:13px;line-height:1;">&rarr;</span>
                    </button>

                    @if(request('q'))
                    <a href="{{ route('admin.rekening.index') }}" class="fcc-rekening-btn-reset" title="Reset Pencarian">
                        ✕ Reset
                    </a>
                    @endif
                </div>
            </div>

            {{-- Desktop Total Counter Pill --}}
            <div class="fcc-rekening-badge-wrap fcc-rekening-badge-wrap-desktop">
                <span class="fcc-rekening-total-pill">
                    <span class="fcc-rekening-badge-dot"></span>
                    {{ $rekening->total() }} Total Rekening
                </span>
            </div>
        </form>
    </div>

    {{-- Bank Account Cards Grid --}}
    <div class="fcc-rekening-grid">
        @forelse($rekening as $r)
        <div class="rekening-card-admin {{ $r->is_active ? 'active' : 'inactive' }}">
            <div>
                {{-- Card Top Row --}}
                <div class="fcc-rekening-card-head">
                    <div class="fcc-rekening-card-icon {{ $r->is_active ? 'active' : 'inactive' }}">
                        @include('components.icon',['name'=>'wallet','size'=>22,'style'=>"color:".($r->is_active ? '#FFC81A' : '#64748B')])
                    </div>

                    @if($r->is_active)
                    <span class="fcc-rekening-card-status-badge active">
                        ★ REKENING UTAMA AKTIF
                    </span>
                    @else
                    <span class="fcc-rekening-card-status-badge inactive">
                        Nonaktif
                    </span>
                    @endif
                </div>

                {{-- Bank Name --}}
                <h3 class="fcc-rekening-card-bank">{{ $r->bank }}</h3>

                {{-- Account Number with Copy Button --}}
                <div class="fcc-rekening-number-box">
                    <span class="fcc-rekening-number-text" id="rek-num-{{ $r->id }}">{{ $r->no_rekening }}</span>
                    <button type="button" class="fcc-rekening-btn-copy" onclick="copyRekening('{{ $r->no_rekening }}', this)" title="Salin nomor rekening">
                        @include('components.icon',['name'=>'clipboard','size'=>12])
                        <span>Salin</span>
                    </button>
                </div>

                {{-- Account Owner --}}
                <p class="fcc-rekening-card-owner">
                    a.n. <strong>{{ $r->nama_pemilik }}</strong>
                </p>
            </div>

            {{-- Card Action Buttons (Super Admin Only) --}}
            @if(auth('admin')->user()?->isSuperAdmin())
            <div class="fcc-rekening-card-actions">
                @if(!$r->is_active)
                <form action="{{ route('admin.rekening.aktifkan', $r) }}" method="POST" style="flex:1;margin:0;">
                    @csrf
                    <button type="submit" class="fcc-rekening-btn-activate" title="Aktifkan sebagai rekening utama">
                        @include('components.icon',['name'=>'check','size'=>13]) Aktifkan
                    </button>
                </form>
                @endif

                <button type="button" onclick="openEditRekeningModal({{ json_encode($r) }})" class="fcc-rekening-btn-edit" title="Edit nomor rekening">
                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                </button>

                <form action="{{ route('admin.rekening.destroy', $r) }}" method="POST" style="margin:0;" onsubmit="return fccConfirmDelete(event, this, 'Hapus Rekening', 'Apakah Anda yakin ingin menghapus rekening {{ addslashes($r->bank) }} ({{ addslashes($r->no_rekening) }})? Data yang dihapus tidak dapat dipulihkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="fcc-rekening-btn-delete" title="Hapus Rekening">
                        @include('components.icon',['name'=>'trash','size'=>14])
                    </button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div style="grid-column:1/-1;padding:48px 16px;text-align:center;color:#94A3B8;border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;box-sizing:border-box;">
            <div style="width:52px;height:52px;border-radius:16px;background:#F8FAFC;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;border:1.5px solid #E2E8F0;">
                @include('components.icon',['name'=>'wallet','size'=>24,'style'=>'color:#94A3B8'])
            </div>
            <p style="font-size:15px;font-weight:900;color:#131218;margin:0 0 4px;font-family:'Outfit',sans-serif;">
                @if(request('q'))
                    Tidak ditemukan rekening dengan kata kunci "{{ request('q') }}"
                @else
                    Belum Ada Rekening Terdaftar
                @endif
            </p>
            <p style="font-size:12.5px;color:#64748B;margin:0 0 14px;font-weight:500;">
                @if(request('q'))
                    Coba gunakan kata kunci pencarian yang lain atau hapus filter.
                @else
                    Klik tombol "Tambah Rekening Baru" untuk menambahkan rekening pertama.
                @endif
            </p>
            @if(request('q'))
            <a href="{{ route('admin.rekening.index') }}" class="fcc-rekening-btn-reset" style="display:inline-flex;">
                ✕ Hapus Filter Pencarian
            </a>
            @elseif(auth('admin')->user()?->isSuperAdmin())
            <button type="button" onclick="openAddRekeningModal()" class="fcc-rekening-btn-add" style="margin:0 auto;">
                @include('components.icon',['name'=>'plus','size'=>15]) Tambah Rekening Sekarang
            </button>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($rekening->hasPages())
    <div style="margin-top:24px;padding:12px 18px;background:#FFFFFF;border-radius:16px;border:2px solid #E5E7EB;overflow-x:auto;-webkit-overflow-scrolling:touch;">
        {{ $rekening->links() }}
    </div>
    @endif

</div>

{{-- MODAL TAMBAH / EDIT REKENING (Super Admin Only) --}}
@if(auth('admin')->user()?->isSuperAdmin())
<div id="rekening-modal" class="fcc-rekening-modal-overlay">
    <div class="fcc-rekening-modal-card">
        <div class="fcc-rekening-modal-header">
            <div>
                <span class="fcc-rekening-badge-tag" style="margin-bottom:2px;">Form Rekening</span>
                <h2 id="rekening-modal-title" style="color:#131218;font-size:18px;font-weight:900;margin:0;font-family:'Outfit',sans-serif;">Tambah Rekening Baru</h2>
            </div>
            <button type="button" onclick="closeRekeningModal()" class="fcc-rekening-modal-close" aria-label="Tutup Modal">&times;</button>
        </div>

        <form id="rekening-form" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="rekening-method" value="POST">

            <div class="fcc-rekening-form-group">
                <label class="fcc-rekening-form-label">Nama Pemilik Rekening *</label>
                <input type="text" name="nama_pemilik" id="f-nama-pemilik" required placeholder="Contoh: Fikom Certification Center" class="fcc-input fcc-rekening-form-input">
            </div>

            <div class="fcc-rekening-form-group">
                <label class="fcc-rekening-form-label">Nama Bank / Penyedia E-Wallet *</label>
                <input type="text" name="bank" id="f-bank" required placeholder="Contoh: Bank Mandiri, BCA, BNI, BRI" class="fcc-input fcc-rekening-form-input">
            </div>

            <div class="fcc-rekening-form-group" style="margin-bottom:20px;">
                <label class="fcc-rekening-form-label">Nomor Rekening / Virtual Account *</label>
                <input type="text" name="no_rekening" id="f-no-rekening" required placeholder="Contoh: 1520012345678" class="fcc-input fcc-rekening-form-input" style="font-family:'JetBrains Mono',monospace;font-weight:800;letter-spacing:0.5px;">
            </div>

            <div class="fcc-rekening-modal-footer">
                <button type="button" onclick="closeRekeningModal()" class="fcc-rekening-btn-cancel">Batal</button>
                <button type="submit" class="fcc-rekening-btn-submit">
                    @include('components.icon',['name'=>'check','size'=>15])
                    <span id="rekening-btn-text">Simpan Rekening</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const STORE_REKENING_URL = '{{ route('admin.rekening.store') }}';
const UPDATE_REKENING_URLS = @json($rekening->getCollection()->mapWithKeys(fn($r) => [$r->id => route('admin.rekening.update', $r)]));

function openAddRekeningModal() {
    document.getElementById('rekening-modal-title').innerText = 'Tambah Rekening Baru';
    document.getElementById('rekening-btn-text').innerText = 'Simpan Rekening';
    document.getElementById('rekening-form').action = STORE_REKENING_URL;
    document.getElementById('rekening-method').value = 'POST';
    document.getElementById('f-nama-pemilik').value = '';
    document.getElementById('f-bank').value = '';
    document.getElementById('f-no-rekening').value = '';
    showModal('rekening-modal');
}

function openEditRekeningModal(rekening) {
    document.getElementById('rekening-modal-title').innerText = 'Edit Nomor Rekening';
    document.getElementById('rekening-btn-text').innerText = 'Perbarui Rekening';
    document.getElementById('rekening-form').action = UPDATE_REKENING_URLS[rekening.id] || `/admin/rekening/${rekening.id}`;
    document.getElementById('rekening-method').value = 'PUT';
    document.getElementById('f-nama-pemilik').value = rekening.nama_pemilik || '';
    document.getElementById('f-bank').value = rekening.bank || '';
    document.getElementById('f-no-rekening').value = rekening.no_rekening || '';
    showModal('rekening-modal');
}

function closeRekeningModal() {
    const el = document.getElementById('rekening-modal');
    if (el) el.style.display = 'none';
    document.body.style.overflow = '';
}

function showModal(id) {
    const el = document.getElementById(id);
    if(el) {
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

// Copy to clipboard helper
function copyRekening(text, btn) {
    if (!navigator.clipboard) {
        const temp = document.createElement('textarea');
        temp.value = text;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
    } else {
        navigator.clipboard.writeText(text);
    }

    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<span>✓ Disalin!</span>';
    btn.style.background = '#ECFDF5';
    btn.style.borderColor = '#10B981';
    btn.style.color = '#059669';

    setTimeout(() => {
        btn.innerHTML = originalHtml;
        btn.style.background = '';
        btn.style.borderColor = '';
        btn.style.color = '';
    }, 1800);
}

// Backdrop click
document.getElementById('rekening-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeRekeningModal();
});

// ESC key to close
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeRekeningModal();
});

// Auto re-open on validation errors if any
document.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
        openAddRekeningModal();
    @endif
});
</script>
@endif

@endsection
