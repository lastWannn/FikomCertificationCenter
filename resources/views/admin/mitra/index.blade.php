@extends('layouts.admin')
@section('title','Mitra & Partner')
@section('page-title', 'Mitra & Partner')
@section('page-breadcrumb', 'Konten / Mitra & Partner')
@section('page-content')

<style>
/* ─── Base Container ─────────────────────────────────────────── */
.fcc-mitra-container {
    padding: 24px 28px;
    background: #F6F8FB;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
    box-sizing: border-box;
}

/* ─── Header Area ────────────────────────────────────────────── */
.fcc-mitra-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 14px;
}
.fcc-mitra-header-left {
    flex: 1;
    min-width: 240px;
}
.fcc-mitra-badge-tag {
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
.fcc-mitra-title {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 4px 0 2px;
    letter-spacing: -0.02em;
    font-family: 'Outfit', sans-serif;
}
.fcc-mitra-subtitle {
    color: #64748B;
    font-size: 13px;
    margin: 0;
    font-weight: 500;
}
.fcc-mitra-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.fcc-mitra-btn-add {
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 900;
    background: #131218;
    color: #FFC81A;
    border-radius: 30px;
    border: 1.5px solid #131218;
    box-shadow: 2px 2px 0px #131218;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all .16s ease;
    white-space: nowrap;
}
.fcc-mitra-btn-add:hover {
    background: #FFC81A;
    color: #131218;
    transform: translateY(-1px);
    box-shadow: 2px 3px 0px #131218;
}

/* ─── Search & Toolbar Card ──────────────────────────────────── */
.fcc-mitra-toolbar-card {
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    border-radius: 18px;
    padding: 14px 18px;
    margin-bottom: 22px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    box-sizing: border-box;
}
.fcc-mitra-search-form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin: 0;
    width: 100%;
    box-sizing: border-box;
}
.fcc-mitra-search-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 0;
    flex-wrap: nowrap;
}
.fcc-mitra-search-box {
    position: relative;
    flex: 1;
    min-width: 180px;
    max-width: 360px;
}
.fcc-mitra-search-icon {
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
.fcc-mitra-search-input {
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
.fcc-mitra-search-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
    background: #FFFFFF;
}
.fcc-mitra-search-clear {
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
.fcc-mitra-search-clear:hover {
    background: #CBD5E1;
    color: #0F172A;
}
.fcc-mitra-btn-search {
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
.fcc-mitra-btn-search:hover {
    background: #FFD447;
    transform: translateY(-1px);
    box-shadow: 2px 3px 0px #131218;
}
.fcc-mitra-btn-reset {
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
.fcc-mitra-btn-reset:hover {
    background: #FEE2E2;
    border-color: #EF4444;
    color: #DC2626;
}
.fcc-mitra-total-badge {
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
.fcc-mitra-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #131218;
    display: inline-block;
    flex-shrink: 0;
}
.fcc-mitra-toolbar-top-mobile {
    display: none;
}

/* ─── Cards Grid ─────────────────────────────────────────────── */
.fcc-mitra-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    box-sizing: border-box;
    width: 100%;
}
.mitra-card-admin {
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    border-radius: 20px;
    padding: 18px;
    transition: all .2s cubic-bezier(.4, 0, .2, 1);
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box;
    position: relative;
}
.mitra-card-admin:hover {
    border-color: #131218;
    box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    transform: translateY(-3px);
}
.fcc-mitra-logo-box {
    width: 100%;
    height: 104px;
    border-radius: 14px;
    background: #F8FAFC;
    border: 1.5px dashed #CBD5E1;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
    overflow: hidden;
    position: relative;
    padding: 10px;
    box-sizing: border-box;
    transition: background-color .18s;
}
.mitra-card-admin:hover .fcc-mitra-logo-box {
    background: #FFF;
    border-color: #94A3B8;
}
.fcc-mitra-logo-img {
    max-width: 85%;
    max-height: 80%;
    object-fit: contain;
    transition: transform .2s ease;
}
.mitra-card-admin:hover .fcc-mitra-logo-img {
    transform: scale(1.05);
}
.fcc-mitra-card-title {
    font-size: 15.5px;
    font-weight: 900;
    color: #131218;
    margin: 0 0 6px;
    line-height: 1.3;
    word-break: break-word;
    font-family: 'Outfit', sans-serif;
}
.fcc-mitra-link {
    font-size: 12px;
    color: #059669;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 16px;
    word-break: break-all;
    transition: color .15s;
}
.fcc-mitra-link:hover {
    color: #047857;
    text-decoration: underline;
}
.fcc-mitra-no-link {
    font-size: 12px;
    color: #94A3B8;
    margin: 0 0 16px;
    font-weight: 500;
}
.fcc-mitra-card-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px dashed #E2E8F0;
}
.fcc-mitra-btn-edit {
    flex: 1;
    min-height: 38px;
    padding: 0 14px;
    border-radius: 10px;
    border: 1.5px solid #131218;
    background: #FFFFFF;
    color: #131218;
    font-size: 12.5px;
    font-weight: 800;
    cursor: pointer;
    transition: all .16s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    box-sizing: border-box;
}
.fcc-mitra-btn-edit:hover {
    background: #FFC81A;
    transform: translateY(-1px);
}
.fcc-mitra-btn-del {
    min-height: 38px;
    padding: 0 14px;
    border-radius: 10px;
    border: 1.5px solid #FCA5A5;
    background: #FEF2F2;
    color: #DC2626;
    font-size: 12px;
    font-weight: 800;
    cursor: pointer;
    transition: all .16s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
}
.fcc-mitra-btn-del:hover {
    background: #DC2626;
    color: #FFFFFF;
    border-color: #DC2626;
}

/* ─── Modals (Responsive & Scrollable) ───────────────────────── */
@keyframes modalIn {
    from { opacity: 0; transform: scale(.96) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.fcc-mitra-modal-overlay {
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
.fcc-mitra-modal-card {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 22px;
    padding: 28px;
    max-width: 520px;
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
.fcc-mitra-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    border-bottom: 2px solid #E5E7EB;
    padding-bottom: 14px;
    gap: 12px;
}
.fcc-mitra-modal-close {
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
.fcc-mitra-modal-close:hover {
    background: #FFC81A;
}
.fcc-mitra-form-group {
    margin-bottom: 18px;
}
.fcc-mitra-form-label {
    display: block;
    font-size: 11px;
    font-weight: 800;
    color: #64748B;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: .8px;
}
.fcc-mitra-form-input {
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
}
.fcc-mitra-form-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
}
.fcc-mitra-modal-footer {
    border-top: 1.5px solid #E2E4EB;
    padding-top: 18px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 6px;
}
.fcc-mitra-btn-cancel {
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
.fcc-mitra-btn-cancel:hover {
    background: #F1F5F9;
}
.fcc-mitra-btn-submit {
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
}
.fcc-mitra-btn-submit:hover {
    background: #FFC81A;
    color: #131218;
    transform: translateY(-1px);
}

/* Confirm Dialog */
.fcc-confirm-modal-card {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 22px;
    padding: 28px;
    max-width: 420px;
    width: 100%;
    box-shadow: 0 24px 60px rgba(0,0,0,0.35);
    text-align: center;
    position: relative;
    animation: modalIn .22s ease;
    box-sizing: border-box;
}

/* ─── Responsive Breakpoints ─────────────────────────────────── */
/* Tablet / iPad (640px to 1023px) */
@media (max-width: 1023px) and (min-width: 640px) {
    .fcc-mitra-container {
        padding: 20px 16px;
    }
    .fcc-mitra-grid {
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 16px;
    }
    .fcc-mitra-logo-box {
        height: 92px;
    }
    .fcc-mitra-search-form {
        flex-wrap: nowrap;
        gap: 10px;
    }
    .fcc-mitra-search-box {
        min-width: 160px;
        max-width: 280px;
    }
    .fcc-mitra-total-badge {
        font-size: 11px;
        padding: 3px 10px;
        box-shadow: 1.5px 1.5px 0px #131218;
    }
}

/* Mobile Devices (< 640px) */
@media (max-width: 639px) {
    .fcc-mitra-container {
        padding: 14px 12px;
    }
    .fcc-mitra-header {
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
        margin-bottom: 16px;
    }
    .fcc-mitra-header-left {
        width: 100%;
    }
    .fcc-mitra-title {
        font-size: 20px;
    }
    .fcc-mitra-btn-add {
        width: 100%;
        min-height: 44px;
        justify-content: center;
        font-size: 13.5px;
    }
    .fcc-mitra-toolbar-card {
        padding: 12px 14px;
        border-radius: 16px;
        margin-bottom: 16px;
    }
    .fcc-mitra-search-form {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    .fcc-mitra-search-left {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        gap: 8px;
    }
    .fcc-mitra-search-box {
        width: 100% !important;
        max-width: 100% !important;
    }
    .fcc-mitra-search-input {
        min-height: 40px;
        font-size: 13px;
    }
    .fcc-mitra-btn-search,
    .fcc-mitra-btn-reset {
        width: 100%;
        min-height: 40px;
    }
    .fcc-mitra-toolbar-top-mobile {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1.5px dashed #E2E8F0;
        width: 100%;
        box-sizing: border-box;
    }
    .fcc-mitra-toolbar-title-box {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }
    .fcc-mitra-toolbar-top-mobile .fcc-mitra-total-badge {
        font-size: 11px;
        padding: 3.5px 10px;
        box-shadow: 1.5px 1.5px 0px #131218;
    }
    .fcc-mitra-total-badge-desktop {
        display: none !important;
    }
    .fcc-mitra-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .mitra-card-admin {
        padding: 16px;
        border-radius: 16px;
    }
    .fcc-mitra-logo-box {
        height: 88px;
    }
    .fcc-mitra-card-actions {
        gap: 8px;
    }
    .fcc-mitra-btn-edit {
        min-height: 40px;
        font-size: 13px;
    }
    .fcc-mitra-btn-del {
        min-height: 40px;
        padding: 0 16px;
    }
    .fcc-mitra-modal-card {
        padding: 20px 16px;
        border-radius: 18px;
        max-height: calc(100vh - 24px);
        max-height: calc(100dvh - 24px);
    }
    .fcc-mitra-modal-footer {
        display: flex;
        width: 100%;
        gap: 8px;
    }
    .fcc-mitra-btn-cancel {
        flex: 1;
        min-height: 42px;
    }
    .fcc-mitra-btn-submit {
        flex: 1.4;
        min-height: 42px;
    }
    .fcc-confirm-modal-card {
        padding: 20px 16px;
        border-radius: 18px;
    }
}

/* Very Small Screens (< 380px) */
@media (max-width: 379px) {
    .fcc-mitra-container {
        padding: 10px 8px;
    }
    .mitra-card-admin {
        padding: 14px 12px;
    }
}
</style>

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" class="fcc-mitra-modal-overlay">
    <div class="fcc-confirm-modal-card">
        <div id="fcc-confirm-icon" style="width:52px;height:52px;border-radius:16px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:#EF4444;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#131218;font-size:18px;font-weight:900;margin:0 0 8px;font-family:'Outfit',sans-serif;">Hapus Mitra?</h3>
        <p id="fcc-confirm-msg" style="color:#64748B;font-size:13px;margin:0 0 24px;line-height:1.6;font-weight:500;"></p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button type="button" onclick="closeConfirm()" style="flex:1;padding:10px 18px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:13px;font-weight:800;cursor:pointer;min-height:40px;">Batal</button>
            <form id="fcc-confirm-form" method="POST" style="flex:1;margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="width:100%;padding:10px 18px;border-radius:10px;border:1px solid #131218;background:#DC2626;color:#FFF;font-size:13px;font-weight:800;cursor:pointer;min-height:40px;box-shadow:0 4px 14px rgba(220,38,38,.3);transition:all .18s;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ── Form Modal (Create/Edit) ─────────────────────────────────── --}}
<div id="mitra-modal" class="fcc-mitra-modal-overlay">
    <div class="fcc-mitra-modal-card">
        <div class="fcc-mitra-modal-header">
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                    <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Kemitraan</span>
                </div>
                <h2 id="modal-title" style="color:#131218;font-size:18px;font-weight:900;margin:0;font-family:'Outfit',sans-serif;">Tambah Mitra Baru</h2>
            </div>
            <button type="button" onclick="closeMitraModal()" class="fcc-mitra-modal-close" aria-label="Tutup Modal">&times;</button>
        </div>

        <form id="mitra-form" method="POST" enctype="multipart/form-data" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="_id" id="form-id" value="">

            <div class="fcc-mitra-form-group">
                <label class="fcc-mitra-form-label">Nama Mitra *</label>
                <input type="text" name="nama_mitra" id="f-nama" required placeholder="Contoh: Microsoft Indonesia, Google Cloud" class="fcc-input fcc-mitra-form-input">
            </div>

            <div class="fcc-mitra-form-group">
                <label class="fcc-mitra-form-label">Link Website</label>
                <input type="url" name="link_website" id="f-link" placeholder="https://www.partner.com" class="fcc-input fcc-mitra-form-input">
            </div>

            <div class="fcc-mitra-form-group">
                <label class="fcc-mitra-form-label">Upload Logo Mitra</label>
                <input type="file" name="logo" id="f-logo" accept="image/*" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:8px 12px;color:#131218;font-size:12.5px;outline:none;box-sizing:border-box;cursor:pointer;">
                <p id="f-logo-hint" style="font-size:11px;color:#94A3B8;margin:5px 0 0;font-weight:500;">Format: JPG, PNG, WebP (maks. 2MB). Kosongkan jika tidak ingin mengubah logo.</p>
                <div id="f-logo-preview" style="margin-top:12px;display:none;background:#F8FAFC;border:1.5px dashed #CBD5E1;border-radius:12px;padding:10px;text-align:center;">
                    <img id="f-logo-img" src="" alt="Preview Logo" style="max-height:56px;max-width:100%;border-radius:8px;object-fit:contain;">
                    <p style="font-size:11px;color:#64748B;margin:6px 0 0;font-weight:700;">Preview Logo</p>
                </div>
            </div>

            <div class="fcc-mitra-modal-footer">
                <button type="button" onclick="closeMitraModal()" class="fcc-mitra-btn-cancel">Batal</button>
                <button type="submit" class="fcc-mitra-btn-submit">Simpan Mitra</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Main Content Container ──────────────────────────────────── --}}
<div class="fcc-mitra-container">

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
    <div class="fcc-mitra-header">
        <div class="fcc-mitra-header-left">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span class="fcc-mitra-badge-tag">Kemitraan &amp; Partner</span>
            </div>
            <h1 class="fcc-mitra-title">Logo Mitra &amp; Partner</h1>
            <p class="fcc-mitra-subtitle">Kelola daftar logo partner resmi yang tampil di halaman depan website.</p>
        </div>
        <div class="fcc-mitra-header-actions">
            <button type="button" onclick="openMitraModal()" class="fcc-mitra-btn-add">
                @include('components.icon',['name'=>'plus','size'=>15]) Tambah Mitra Baru
            </button>
        </div>
    </div>

    {{-- Search & Filter Toolbar --}}
    <div class="fcc-mitra-toolbar-card">
        {{-- Mobile Top Row with Counter Badge --}}
        <div class="fcc-mitra-toolbar-top-mobile">
            <div class="fcc-mitra-toolbar-title-box">
                @include('components.icon',['name'=>'filter','size'=>13,'style'=>'color:#475569;'])
                <span>Filter &amp; Pencarian</span>
            </div>
            <span class="fcc-mitra-total-badge">
                <span class="fcc-mitra-badge-dot"></span>
                {{ $mitras->total() }} Total Mitra
            </span>
        </div>

        <form method="GET" action="{{ route('admin.mitra.index') }}" class="fcc-mitra-search-form">
            <div class="fcc-mitra-search-left">
                <div class="fcc-mitra-search-box">
                    <span class="fcc-mitra-search-icon">
                        @include('components.icon',['name'=>'search','size'=>14])
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama mitra atau website..." class="fcc-input fcc-mitra-search-input" autocomplete="off">
                    @if(request('q'))
                    <a href="{{ route('admin.mitra.index') }}" class="fcc-mitra-search-clear" title="Hapus pencarian">✕</a>
                    @endif
                </div>

                <button type="submit" class="fcc-mitra-btn-search">
                    <span>Cari</span>
                    <span style="font-size:13px;line-height:1;">&rarr;</span>
                </button>

                @if(request('q'))
                <a href="{{ route('admin.mitra.index') }}" class="fcc-mitra-btn-reset" title="Reset Pencarian">
                    ✕ Reset
                </a>
                @endif
            </div>

            {{-- Desktop Total Badge --}}
            <span class="fcc-mitra-total-badge fcc-mitra-total-badge-desktop">
                <span class="fcc-mitra-badge-dot"></span>
                {{ $mitras->total() }} Total Mitra
            </span>
        </form>
    </div>

    {{-- Mitra Cards Grid --}}
    <div class="fcc-mitra-grid">
        @forelse($mitras as $m)
        <div class="mitra-card-admin">
            <div>
                {{-- Logo Box --}}
                <div class="fcc-mitra-logo-box">
                    @if($m->logo && file_exists(public_path('storage/'.$m->logo)))
                        <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}" class="fcc-mitra-logo-img">
                    @elseif($m->logo)
                        <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}" class="fcc-mitra-logo-img" onerror="this.onerror=null;this.parentElement.innerHTML='<div style=\'display:flex;flex-direction:column;align-items:center;gap:4px;color:#94A3B8;\'><span style=\'font-size:11px;font-weight:700;\'>{{ Str::limit($m->nama_mitra, 14) }}</span></div>';">
                    @else
                        <div style="display:flex;flex-direction:column;align-items:center;gap:4px;color:#94A3B8;">
                            @include('components.icon',['name'=>'users','size'=>22,'style'=>'color:#9CA3B0'])
                            <span style="font-size:11px;font-weight:700;">Tanpa Logo</span>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <h3 class="fcc-mitra-card-title">{{ $m->nama_mitra }}</h3>
                @if($m->link_website)
                <a href="{{ $m->link_website }}" target="_blank" rel="noopener noreferrer" class="fcc-mitra-link" title="{{ $m->link_website }}">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    <span>{{ Str::limit($m->link_website, 28) }}</span>
                </a>
                @else
                <p class="fcc-mitra-no-link">Tidak ada link website</p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="fcc-mitra-card-actions">
                <button type="button" onclick="openEditModal({{ json_encode($m) }}, '{{ $m->logo ? asset('storage/'.$m->logo) : '' }}')" class="fcc-mitra-btn-edit">
                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                </button>
                <button type="button" onclick="confirmDelete('{{ route('admin.mitra.destroy', $m) }}', {{ json_encode($m->nama_mitra) }})" class="fcc-mitra-btn-del" title="Hapus Mitra">
                    @include('components.icon',['name'=>'trash','size'=>13])
                </button>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;padding:48px 16px;text-align:center;color:#94A3B8;border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;box-sizing:border-box;">
            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
            </div>
            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">
                @if(request('q'))
                    Tidak ditemukan mitra dengan kata kunci "{{ request('q') }}"
                @else
                    Belum Ada Data Mitra / Partner
                @endif
            </p>
            <p style="font-size:12.5px;color:#64748B;margin:0 0 14px;">
                @if(request('q'))
                    Coba gunakan kata kunci lain atau bersihkan pencarian.
                @else
                    Klik "Tambah Mitra Baru" untuk menambahkan partner pertama.
                @endif
            </p>
            @if(request('q'))
            <a href="{{ route('admin.mitra.index') }}" class="fcc-mitra-btn-reset" style="display:inline-flex;">
                ✕ Hapus Filter Pencarian
            </a>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($mitras->hasPages())
    <div style="margin-top:24px;padding:12px 18px;background:#FFFFFF;border-radius:16px;border:2px solid #E5E7EB;overflow-x:auto;-webkit-overflow-scrolling:touch;">
        {{ $mitras->links() }}
    </div>
    @endif
</div>

<script>
const STORE_URL = '{{ route('admin.mitra.store') }}';
const UPDATE_URLS = @json($mitras->getCollection()->mapWithKeys(fn($m) => [$m->id => route('admin.mitra.update', $m->id)]));

// ── Modal helpers ──────────────────────────────────────
function openMitraModal() {
    document.getElementById('modal-title').innerText = 'Tambah Mitra Baru';
    document.getElementById('mitra-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('f-nama').value = '';
    document.getElementById('f-link').value = '';
    document.getElementById('f-logo').value = '';
    document.getElementById('f-logo-preview').style.display = 'none';
    document.getElementById('f-logo-img').src = '';
    document.getElementById('f-logo-hint').innerText = 'Format: JPG, PNG, WebP (maks. 2MB).';
    showModal('mitra-modal');
}

function openEditModal(mitra, logoAssetUrl) {
    document.getElementById('modal-title').innerText = 'Edit Mitra';
    document.getElementById('mitra-form').action = UPDATE_URLS[mitra.id] || `/admin/mitra/${mitra.id}`;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = mitra.id;
    document.getElementById('f-nama').value = mitra.nama_mitra || '';
    document.getElementById('f-link').value = mitra.link_website || '';
    document.getElementById('f-logo').value = '';
    
    const preview = document.getElementById('f-logo-preview');
    if (logoAssetUrl) {
        document.getElementById('f-logo-img').src = logoAssetUrl;
        preview.style.display = 'block';
        document.getElementById('f-logo-hint').innerText = 'Biarkan kosong jika tidak ingin mengubah logo.';
    } else {
        preview.style.display = 'none';
        document.getElementById('f-logo-img').src = '';
        document.getElementById('f-logo-hint').innerText = 'Format: JPG, PNG, WebP (maks. 2MB). Opsional.';
    }
    showModal('mitra-modal');
}

function closeMitraModal() {
    const modal = document.getElementById('mitra-modal');
    if(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

// ── Confirm Delete ─────────────────────────────────────
function confirmDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Mitra?';
    document.getElementById('fcc-confirm-msg').innerText = `Data mitra "${name}" akan dihapus secara permanen. Tindakan ini tidak bisa dibatalkan.`;
    document.getElementById('fcc-confirm-form').action = url;
    showModal('fcc-confirm-modal');
}

function closeConfirm() {
    const modal = document.getElementById('fcc-confirm-modal');
    if(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function showModal(id) {
    const el = document.getElementById(id);
    if(el) {
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

// Close on backdrop click
document.getElementById('mitra-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeMitraModal();
});
document.getElementById('fcc-confirm-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Live Logo Preview on file pick
document.getElementById('f-logo')?.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const preview = document.getElementById('f-logo-preview');
        const img = document.getElementById('f-logo-img');
        img.src = URL.createObjectURL(file);
        preview.style.display = 'block';
        document.getElementById('f-logo-hint').innerText = 'File dipilih: ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
    }
});

// Re-open modal if validation errors exist
document.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
        openMitraModal();
    @endif
});
</script>
@endsection
