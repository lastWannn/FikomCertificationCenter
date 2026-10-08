@extends('layouts.admin')
@section('title','Kata Mereka (Testimoni)')
@section('page-title', 'Kata Mereka')
@section('page-breadcrumb', 'Konten / Kata Mereka')
@section('page-content')

<style>
/* ─── Base Container ─────────────────────────────────────────── */
.fcc-testi-container {
    padding: 24px 28px;
    background: #F6F8FB;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
    box-sizing: border-box;
}

/* ─── Header Area ────────────────────────────────────────────── */
.fcc-testi-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 14px;
}
.fcc-testi-header-left {
    flex: 1;
    min-width: 240px;
}
.fcc-testi-badge-tag {
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
.fcc-testi-title {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 4px 0 2px;
    letter-spacing: -0.02em;
    font-family: 'Outfit', sans-serif;
}
.fcc-testi-subtitle {
    color: #64748B;
    font-size: 13px;
    margin: 0;
    font-weight: 500;
}
.fcc-testi-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.fcc-testi-btn-add {
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
.fcc-testi-btn-add:hover {
    background: #FFC81A;
    color: #131218;
    transform: translateY(-1px);
    box-shadow: 2px 3px 0px #131218;
}

/* ─── Search & Filter Toolbar ────────────────────────────────── */
.fcc-testi-toolbar-card {
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    border-radius: 18px;
    padding: 14px 18px;
    margin-bottom: 22px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    box-sizing: border-box;
}
.fcc-testi-filter-form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin: 0;
    width: 100%;
    box-sizing: border-box;
    flex-wrap: wrap;
}
.fcc-testi-filter-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 0;
    flex-wrap: wrap;
}
.fcc-testi-search-box {
    position: relative;
    flex: 1;
    min-width: 180px;
    max-width: 320px;
}
.fcc-testi-search-icon {
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
.fcc-testi-search-input {
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
.fcc-testi-search-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
    background: #FFFFFF;
}
.fcc-testi-search-clear {
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
.fcc-testi-search-clear:hover {
    background: #CBD5E1;
    color: #0F172A;
}
.fcc-testi-select {
    width: 145px !important;
    max-width: 160px;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid #CBD5E1;
    font-size: 12.5px;
    font-weight: 700;
    padding: 0 28px 0 10px;
    background-color: #FFFFFF;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    box-sizing: border-box;
    cursor: pointer;
    color: #131218;
    flex-shrink: 0;
    transition: border-color .15s, box-shadow .15s;
}
.fcc-testi-select:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
    outline: none;
}
.fcc-testi-btn-search {
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
.fcc-testi-btn-search:hover {
    background: #FFD447;
    transform: translateY(-1px);
    box-shadow: 2px 3px 0px #131218;
}
.fcc-testi-btn-reset {
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
.fcc-testi-btn-reset:hover {
    background: #FEE2E2;
    border-color: #EF4444;
    color: #DC2626;
}
.fcc-testi-total-badge {
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
.fcc-testi-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #131218;
    display: inline-block;
    flex-shrink: 0;
}
.fcc-testi-toolbar-top-mobile {
    display: none;
}

/* ─── Cards Grid ─────────────────────────────────────────────── */
.fcc-testi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
    box-sizing: border-box;
    width: 100%;
}
.testimoni-card-admin {
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
.testimoni-card-admin:hover {
    border-color: #131218;
    box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    transform: translateY(-3px);
}
.fcc-testi-card-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
    gap: 8px;
    flex-wrap: wrap;
}
.fcc-testi-card-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #131218;
    border: 2px solid #FFC81A;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
}
.fcc-testi-card-name {
    font-size: 15px;
    font-weight: 900;
    color: #131218;
    margin: 0 0 2px;
    line-height: 1.3;
    font-family: 'Outfit', sans-serif;
    word-break: break-word;
}
.fcc-testi-card-stars {
    display: flex;
    align-items: center;
    gap: 2px;
    margin-bottom: 3px;
}
.fcc-testi-card-role {
    font-size: 11.5px;
    color: #64748B;
    margin: 0;
    font-weight: 700;
    word-break: break-word;
}
.fcc-testi-card-quote {
    background: #FFFDF5;
    border: 1.5px solid #FFC81A;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 16px;
    position: relative;
    box-sizing: border-box;
}
.fcc-testi-card-quote p {
    font-size: 12.5px;
    color: #131218;
    margin: 0;
    line-height: 1.55;
    font-weight: 600;
    font-style: italic;
    word-break: break-word;
}
.fcc-testi-card-actions {
    display: flex;
    gap: 6px;
    align-items: center;
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px dashed #E2E8F0;
    flex-wrap: wrap;
}
.fcc-testi-btn-toggle {
    flex: 1;
    min-height: 38px;
    padding: 0 10px;
    border-radius: 10px;
    border: 1.5px solid #131218;
    font-size: 11.5px;
    font-weight: 800;
    cursor: pointer;
    transition: all .16s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    box-sizing: border-box;
    white-space: nowrap;
}
.fcc-testi-btn-toggle:hover {
    transform: translateY(-1px);
}
.fcc-testi-btn-edit {
    min-height: 38px;
    padding: 0 14px;
    border-radius: 10px;
    border: 1.5px solid #131218;
    background: #FFFFFF;
    color: #131218;
    font-size: 12px;
    font-weight: 800;
    cursor: pointer;
    transition: all .16s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    box-sizing: border-box;
}
.fcc-testi-btn-edit:hover {
    background: #FFC81A;
    transform: translateY(-1px);
}
.fcc-testi-btn-del {
    min-height: 38px;
    padding: 0 12px;
    border-radius: 10px;
    border: 1px solid #FCA5A5;
    background: #FEF2F2;
    color: #DC2626;
    font-size: 12px;
    cursor: pointer;
    transition: all .16s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
}
.fcc-testi-btn-del:hover {
    background: #DC2626;
    color: #FFFFFF;
    border-color: #DC2626;
}

/* ─── Modals (Responsive & Touch-Friendly) ───────────────────── */
@keyframes modalIn {
    from { opacity: 0; transform: scale(.96) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.fcc-modal-backdrop {
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
.fcc-testi-modal-card {
    background: #FFFFFF;
    border: 2.5px solid #131218;
    border-radius: 22px;
    padding: 28px;
    max-width: 580px;
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
.fcc-testi-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    border-bottom: 2px solid #E5E7EB;
    padding-bottom: 14px;
    gap: 12px;
}
.fcc-testi-modal-close {
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
.fcc-testi-modal-close:hover {
    background: #FFC81A;
}
.fcc-testi-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 16px;
}
.fcc-testi-form-full {
    grid-column: 1 / -1;
}
.fcc-testi-form-label {
    display: block;
    font-size: 11px;
    font-weight: 800;
    color: #64748B;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: .8px;
}
.fcc-testi-form-input {
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
.fcc-testi-form-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
}
.fcc-testi-modal-footer {
    border-top: 1.5px solid #E2E4EB;
    padding-top: 18px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 6px;
}
.fcc-testi-btn-cancel {
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
.fcc-testi-btn-cancel:hover {
    background: #F1F5F9;
}
.fcc-testi-btn-submit {
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
.fcc-testi-btn-submit:hover {
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
    .fcc-testi-container {
        padding: 20px 16px;
    }
    .fcc-testi-grid {
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }
    .fcc-testi-search-box {
        min-width: 160px;
        max-width: 240px;
    }
    .fcc-testi-select {
        width: 130px !important;
        font-size: 12px;
    }
    .fcc-testi-btn-search {
        padding: 0 14px;
        font-size: 12px;
    }
    .fcc-testi-total-badge {
        font-size: 11px;
        padding: 3px 10px;
        box-shadow: 1.5px 1.5px 0px #131218;
    }
}

/* Mobile Devices (< 640px) */
@media (max-width: 639px) {
    .fcc-testi-container {
        padding: 14px 12px;
    }
    .fcc-testi-header {
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
        margin-bottom: 16px;
    }
    .fcc-testi-header-left {
        width: 100%;
    }
    .fcc-testi-title {
        font-size: 20px;
    }
    .fcc-testi-btn-add {
        width: 100%;
        min-height: 44px;
        justify-content: center;
        font-size: 13.5px;
    }
    .fcc-testi-toolbar-card {
        padding: 12px 14px;
        border-radius: 16px;
        margin-bottom: 16px;
    }
    .fcc-testi-filter-form {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    .fcc-testi-filter-left {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        gap: 8px;
    }
    .fcc-testi-search-box {
        width: 100% !important;
        max-width: 100% !important;
    }
    .fcc-testi-search-input {
        min-height: 40px;
        font-size: 13px;
    }
    .fcc-testi-mobile-select-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        width: 100%;
    }
    .fcc-testi-select {
        width: 100% !important;
        max-width: 100% !important;
        min-height: 40px;
    }
    .fcc-testi-mobile-btn-row {
        display: flex;
        gap: 8px;
        width: 100%;
    }
    .fcc-testi-btn-search,
    .fcc-testi-btn-reset {
        flex: 1;
        min-height: 40px;
    }
    .fcc-testi-toolbar-top-mobile {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1.5px dashed #E2E8F0;
        width: 100%;
        box-sizing: border-box;
    }
    .fcc-testi-toolbar-title-box {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }
    .fcc-testi-toolbar-top-mobile .fcc-testi-total-badge {
        font-size: 11px;
        padding: 3.5px 10px;
        box-shadow: 1.5px 1.5px 0px #131218;
    }
    .fcc-testi-total-badge-desktop {
        display: none !important;
    }
    .fcc-testi-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .testimoni-card-admin {
        padding: 16px;
        border-radius: 16px;
    }
    .fcc-testi-card-actions {
        display: flex;
        gap: 6px;
    }
    .fcc-testi-btn-toggle {
        min-height: 40px;
        font-size: 12px;
    }
    .fcc-testi-btn-edit {
        min-height: 40px;
        font-size: 12px;
        padding: 0 12px;
    }
    .fcc-testi-btn-del {
        min-height: 40px;
        padding: 0 14px;
    }
    .fcc-testi-form-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    .fcc-testi-modal-card {
        padding: 20px 16px;
        border-radius: 18px;
        max-height: calc(100vh - 24px);
        max-height: calc(100dvh - 24px);
    }
    .fcc-testi-modal-footer {
        display: flex;
        width: 100%;
        gap: 8px;
    }
    .fcc-testi-btn-cancel {
        flex: 1;
        min-height: 42px;
    }
    .fcc-testi-btn-submit {
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
    .fcc-testi-container {
        padding: 10px 8px;
    }
    .testimoni-card-admin {
        padding: 14px 12px;
    }
    .fcc-testi-mobile-select-row {
        grid-template-columns: 1fr;
    }
}
</style>

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" class="fcc-modal-backdrop">
    <div class="fcc-confirm-modal-card">
        <div id="fcc-confirm-icon" style="width:52px;height:52px;border-radius:16px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:#EF4444;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#131218;font-size:18px;font-weight:900;margin:0 0 8px;font-family:'Outfit',sans-serif;">Hapus Testimoni?</h3>
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
<div id="testimoni-modal" class="fcc-modal-backdrop">
    <div class="fcc-testi-modal-card">
        <div class="fcc-testi-modal-header">
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                    <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Ulasan &amp; Testimoni</span>
                </div>
                <h2 id="modal-title" style="color:#131218;font-size:18px;font-weight:900;margin:0;font-family:'Outfit',sans-serif;">Tambah Testimoni Baru</h2>
            </div>
            <button type="button" onclick="closeTestimoniModal()" class="fcc-testi-modal-close" aria-label="Tutup Modal">&times;</button>
        </div>

        <form id="testimoni-form" method="POST" enctype="multipart/form-data" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div class="fcc-testi-form-grid">
                <div class="fcc-testi-form-full">
                    <label class="fcc-testi-form-label">Nama Lengkap *</label>
                    <input type="text" name="nama" id="f-nama" required placeholder="Contoh: Budi Santoso" class="fcc-input fcc-testi-form-input">
                </div>

                <div class="fcc-testi-form-full">
                    <label class="fcc-testi-form-label">Keterangan / Status *</label>
                    <input type="text" name="keterangan" id="f-keterangan" required placeholder="Contoh: Mahasiswa Teknik, Mitra Perusahaan, Alumni FCC" class="fcc-input fcc-testi-form-input">
                </div>

                <div>
                    <label class="fcc-testi-form-label">Rating (Bintang) *</label>
                    <select name="rating" id="f-rating" required class="fcc-input fcc-testi-select" style="width:100% !important;max-width:none;">
                        <option value="5">⭐⭐⭐⭐⭐ (5) Sangat Puas</option>
                        <option value="4">⭐⭐⭐⭐ (4) Puas</option>
                        <option value="3">⭐⭐⭐ (3) Cukup</option>
                        <option value="2">⭐⭐ (2) Kurang</option>
                        <option value="1">⭐ (1) Sangat Kurang</option>
                    </select>
                </div>

                <div>
                    <label class="fcc-testi-form-label">Status Publikasi *</label>
                    <select name="status" id="f-status" required class="fcc-input fcc-testi-select" style="width:100% !important;max-width:none;">
                        <option value="dipublikasikan">✓ Dipublikasikan (Tampil)</option>
                        <option value="pending">⌛ Pending (Sembunyikan)</option>
                        <option value="ditolak">✕ Ditolak</option>
                    </select>
                </div>

                <div class="fcc-testi-form-full">
                    <label class="fcc-testi-form-label">Kata (Ulasan Testimoni) *</label>
                    <textarea name="kata" id="f-kata" required rows="4" placeholder="Tulis testimoni/ulasan peserta secara lengkap..." class="fcc-input fcc-testi-form-input" style="resize:vertical;min-height:90px;line-height:1.6;"></textarea>
                </div>

                <div class="fcc-testi-form-full">
                    <label class="fcc-testi-form-label">Upload Foto Profil (Opsional)</label>
                    <input type="file" name="foto" id="f-foto" accept="image/jpeg,image/png,image/jpg" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:8px 12px;color:#131218;font-size:12.5px;outline:none;box-sizing:border-box;cursor:pointer;">
                    <p id="f-foto-hint" style="font-size:11px;color:#94A3B8;margin:5px 0 0;font-weight:500;">Format: JPG, PNG (maks. 2MB). Kosongkan jika tidak ingin mengubah foto.</p>
                    <div id="f-foto-preview" style="margin-top:12px;display:none;align-items:center;gap:12px;background:#F8FAFC;border:1.5px dashed #CBD5E1;border-radius:12px;padding:10px;">
                        <img id="f-foto-img" src="" alt="Foto Saat Ini" style="width:48px;height:48px;object-fit:cover;border-radius:50%;border:2px solid #FFC81A;">
                        <div>
                            <p style="font-size:12px;font-weight:800;color:#131218;margin:0 0 2px;">Preview Foto Profil</p>
                            <span style="font-size:11px;color:#64748B;">Foto akan ditampilkan di landing page</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fcc-testi-modal-footer">
                <button type="button" onclick="closeTestimoniModal()" class="fcc-testi-btn-cancel">Batal</button>
                <button type="submit" class="fcc-testi-btn-submit">Simpan Testimoni</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Main Content Container ──────────────────────────────────── --}}
<div class="fcc-testi-container">

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
    <div class="fcc-testi-header">
        <div class="fcc-testi-header-left">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span class="fcc-testi-badge-tag">Ulasan &amp; Testimoni</span>
            </div>
            <h1 class="fcc-testi-title">Kata Mereka (Testimoni)</h1>
            <p class="fcc-testi-subtitle">Kelola ulasan/testimoni dari peserta yang tampil di Landing Page.</p>
        </div>
        <div class="fcc-testi-header-actions">
            <button type="button" onclick="openTestimoniModal()" class="fcc-testi-btn-add">
                @include('components.icon',['name'=>'plus','size'=>15]) Tambah Testimoni Baru
            </button>
        </div>
    </div>

    {{-- Search & Filter Toolbar --}}
    <div class="fcc-testi-toolbar-card">
        {{-- Mobile Top Row with Counter Badge --}}
        <div class="fcc-testi-toolbar-top-mobile">
            <div class="fcc-testi-toolbar-title-box">
                @include('components.icon',['name'=>'filter','size'=>13,'style'=>'color:#475569;'])
                <span>Filter &amp; Pencarian</span>
            </div>
            <span class="fcc-testi-total-badge">
                <span class="fcc-testi-badge-dot"></span>
                {{ $testimonis->total() }} Total Testimoni
            </span>
        </div>

        <form method="GET" action="{{ route('admin.testimoni.index') }}" class="fcc-testi-filter-form">
            <div class="fcc-testi-filter-left">
                {{-- Search Box --}}
                <div class="fcc-testi-search-box">
                    <span class="fcc-testi-search-icon">
                        @include('components.icon',['name'=>'search','size'=>14])
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, keterangan, isi ulasan..." class="fcc-input fcc-testi-search-input" autocomplete="off">
                    @if(request('q'))
                    <a href="{{ route('admin.testimoni.index', array_filter(['status' => request('status'), 'rating' => request('rating')])) }}" class="fcc-testi-search-clear" title="Hapus pencarian">✕</a>
                    @endif
                </div>

                {{-- Status Dropdown --}}
                <div class="fcc-testi-mobile-select-row">
                    <select name="status" onchange="this.form.submit()" class="fcc-input fcc-testi-select" title="Filter Status">
                        <option value="">Semua Status</option>
                        <option value="dipublikasikan" {{ request('status')==='dipublikasikan'?'selected':'' }}>✓ Dipublikasikan</option>
                        <option value="pending" {{ request('status')==='pending'?'selected':'' }}>⌛ Pending</option>
                        <option value="ditolak" {{ request('status')==='ditolak'?'selected':'' }}>✕ Ditolak</option>
                    </select>

                    {{-- Rating Dropdown --}}
                    <select name="rating" onchange="this.form.submit()" class="fcc-input fcc-testi-select" title="Filter Rating">
                        <option value="">Semua Rating</option>
                        <option value="5" {{ request('rating')==='5'?'selected':'' }}>⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4" {{ request('rating')==='4'?'selected':'' }}>⭐⭐⭐⭐ (4)</option>
                        <option value="3" {{ request('rating')==='3'?'selected':'' }}>⭐⭐⭐ (3)</option>
                        <option value="2" {{ request('rating')==='2'?'selected':'' }}>⭐⭐ (2)</option>
                        <option value="1" {{ request('rating')==='1'?'selected':'' }}>⭐ (1)</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="fcc-testi-mobile-btn-row">
                    <button type="submit" class="fcc-testi-btn-search">
                        <span>Cari</span>
                        <span style="font-size:13px;line-height:1;">&rarr;</span>
                    </button>

                    @if(request('q') || request('status') || request('rating'))
                    <a href="{{ route('admin.testimoni.index') }}" class="fcc-testi-btn-reset" title="Reset Semua Filter">
                        ✕ Reset
                    </a>
                    @endif
                </div>
            </div>

            {{-- Desktop Total Badge --}}
            <span class="fcc-testi-total-badge fcc-testi-total-badge-desktop">
                <span class="fcc-testi-badge-dot"></span>
                {{ $testimonis->total() }} Total Testimoni
            </span>
        </form>
    </div>

    {{-- Testimonial Cards Grid --}}
    <div class="fcc-testi-grid">
        @forelse($testimonis as $t)
        <div class="testimoni-card-admin">
            <div>
                {{-- Badges Header --}}
                <div class="fcc-testi-card-head">
                    <div style="display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                        @if($t->status === 'dipublikasikan')
                        <span style="font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;background:#ECFDF5;color:#059669;border:1px solid #10B981;white-space:nowrap;">
                            ✓ Dipublikasikan
                        </span>
                        @elseif($t->status === 'ditolak')
                        <span style="font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;background:#FEF2F2;color:#DC2626;border:1px solid #EF4444;white-space:nowrap;">
                            ✕ Ditolak
                        </span>
                        @else
                        <span style="font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;background:#FFFDF5;color:#D97706;border:1px solid #F59E0B;white-space:nowrap;">
                            ⌛ Pending / Sembunyi
                        </span>
                        @endif

                        @if($t->peserta_id)
                        <span style="font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;background:#EEF2FF;color:#4F46E5;border:1px solid #6366F1;white-space:nowrap;">
                            Peserta Terdaftar
                        </span>
                        @endif
                    </div>
                </div>

                {{-- User Avatar & Info --}}
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                    <div class="fcc-testi-card-avatar">
                        @if($t->foto && file_exists(public_path('storage/'.$t->foto)))
                            <img src="{{ asset('storage/'.$t->foto) }}" alt="{{ $t->nama }}" style="width:100%;height:100%;object-fit:cover;">
                        @elseif($t->foto)
                            <img src="{{ asset('storage/'.$t->foto) }}" alt="{{ $t->nama }}" style="width:100%;height:100%;object-fit:cover;" onerror="this.onerror=null;this.parentElement.innerHTML='<span style=\'color:#FFC81A;font-weight:900;font-size:16px;\'>{{ Str::upper(Str::substr($t->nama, 0, 1)) }}</span>';">
                        @else
                            <span style="color:#FFC81A;font-weight:900;font-size:16px;">{{ Str::upper(Str::substr($t->nama, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div style="flex:1;min-width:0;">
                        <h3 class="fcc-testi-card-name">{{ $t->nama }}</h3>
                        <div class="fcc-testi-card-stars">
                            @for($i = 0; $i < 5; $i++)
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="{{ $i < $t->rating ? '#FFC81A' : '#CBD5E1' }}"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                            <span style="font-size:10.5px;font-weight:800;color:#64748B;margin-left:3px;">({{ $t->rating }}/5)</span>
                        </div>
                        <p class="fcc-testi-card-role">{{ $t->keterangan }}</p>
                    </div>
                </div>
                
                {{-- Quote Box --}}
                <div class="fcc-testi-card-quote">
                    <p>"{{ Str::limit($t->kata, 130) }}"</p>
                </div>
            </div>
            
            {{-- Actions --}}
            <div class="fcc-testi-card-actions">
                <form action="{{ route('admin.testimoni.toggle-status', $t->id) }}" method="POST" style="margin:0;flex:1;">
                    @csrf
                    <button type="submit" class="fcc-testi-btn-toggle"
                            style="background:{{ $t->status==='dipublikasikan' ? '#FFFFFF' : '#FFC81A' }};color:#131218;width:100%;">
                        @include('components.icon',['name'=>$t->status==='dipublikasikan'?'eye-off':'eye','size'=>13])
                        <span>{{ $t->status==='dipublikasikan' ? 'Sembunyikan' : 'Tayangkan' }}</span>
                    </button>
                </form>

                <button type="button" onclick="openEditTestimoniModal({{ json_encode($t) }}, '{{ $t->foto ? asset('storage/'.$t->foto) : '' }}')" class="fcc-testi-btn-edit">
                    @include('components.icon',['name'=>'edit','size'=>13])
                    <span>Edit</span>
                </button>

                <button type="button" onclick="confirmTestimoniDelete('{{ route('admin.testimoni.destroy', $t) }}', {{ json_encode($t->nama) }})" class="fcc-testi-btn-del" title="Hapus Testimoni">
                    @include('components.icon',['name'=>'trash','size'=>13])
                </button>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;padding:48px 16px;text-align:center;color:#94A3B8;border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;box-sizing:border-box;">
            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'message-square','size'=>24,'style'=>'color:#9CA3B0'])
            </div>
            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">
                @if(request('q') || request('status') || request('rating'))
                    Tidak ditemukan ulasan yang sesuai dengan filter
                @else
                    Belum Ada Data Ulasan (Testimoni)
                @endif
            </p>
            <p style="font-size:12.5px;color:#64748B;margin:0 0 14px;">
                @if(request('q') || request('status') || request('rating'))
                    Coba ubah kata kunci atau bersihkan filter pencarian.
                @else
                    Klik "Tambah Testimoni Baru" untuk menambahkan ulasan pertama.
                @endif
            </p>
            @if(request('q') || request('status') || request('rating'))
            <a href="{{ route('admin.testimoni.index') }}" class="fcc-testi-btn-reset" style="display:inline-flex;">
                ✕ Hapus Semua Filter
            </a>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($testimonis->hasPages())
    <div style="margin-top:24px;padding:12px 18px;background:#FFFFFF;border-radius:16px;border:2px solid #E5E7EB;overflow-x:auto;-webkit-overflow-scrolling:touch;">
        {{ $testimonis->links() }}
    </div>
    @endif
</div>

<script>
const STORE_URL = '{{ route('admin.testimoni.store') }}';
const UPDATE_URLS = @json($testimonis->getCollection()->mapWithKeys(fn($t) => [$t->id => route('admin.testimoni.update', $t->id)]));

function openTestimoniModal() {
    document.getElementById('modal-title').innerText = 'Tambah Testimoni Baru';
    document.getElementById('testimoni-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    document.getElementById('f-nama').value = '';
    document.getElementById('f-keterangan').value = '';
    document.getElementById('f-rating').value = '5';
    document.getElementById('f-status').value = 'dipublikasikan';
    document.getElementById('f-kata').value = '';
    document.getElementById('f-foto').value = '';
    document.getElementById('f-foto-preview').style.display = 'none';
    document.getElementById('f-foto-img').src = '';
    document.getElementById('f-foto-hint').innerText = 'Format: JPG, PNG (maks. 2MB).';
    showModal('testimoni-modal');
}

function openEditTestimoniModal(testimoni, fotoAssetUrl) {
    document.getElementById('modal-title').innerText = 'Edit Testimoni';
    document.getElementById('testimoni-form').action = UPDATE_URLS[testimoni.id] || `/admin/testimoni/${testimoni.id}`;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('f-nama').value = testimoni.nama || '';
    document.getElementById('f-keterangan').value = testimoni.keterangan || '';
    document.getElementById('f-rating').value = testimoni.rating || '5';
    document.getElementById('f-status').value = testimoni.status || 'dipublikasikan';
    document.getElementById('f-kata').value = testimoni.kata || '';
    document.getElementById('f-foto').value = '';
    
    const preview = document.getElementById('f-foto-preview');
    if (fotoAssetUrl) {
        document.getElementById('f-foto-img').src = fotoAssetUrl;
        preview.style.display = 'flex';
        document.getElementById('f-foto-hint').innerText = 'Biarkan kosong jika tidak ingin mengubah foto.';
    } else {
        preview.style.display = 'none';
        document.getElementById('f-foto-img').src = '';
        document.getElementById('f-foto-hint').innerText = 'Format: JPG, PNG (maks. 2MB). Opsional.';
    }
    showModal('testimoni-modal');
}

function closeTestimoniModal() {
    const modal = document.getElementById('testimoni-modal');
    if(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function confirmTestimoniDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Testimoni?';
    document.getElementById('fcc-confirm-msg').innerText = `Ulasan dari "${name}" akan dihapus secara permanen.`;
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
document.getElementById('testimoni-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeTestimoniModal();
});
document.getElementById('fcc-confirm-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Live image preview on photo pick
document.getElementById('f-foto')?.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            if (typeof fccShowFileAlert === 'function') fccShowFileAlert('Hanya file JPG dan PNG yang diperbolehkan!');
            else alert('Hanya file JPG dan PNG yang diperbolehkan!');
            this.value = '';
            document.getElementById('f-foto-preview').style.display = 'none';
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            if (typeof fccShowFileAlert === 'function') fccShowFileAlert('Ukuran foto maksimal 2MB!');
            else alert('Ukuran foto maksimal 2MB!');
            this.value = '';
            document.getElementById('f-foto-preview').style.display = 'none';
            return;
        }
        const preview = document.getElementById('f-foto-preview');
        const img = document.getElementById('f-foto-img');
        img.src = URL.createObjectURL(file);
        preview.style.display = 'flex';
        document.getElementById('f-foto-hint').innerText = 'Foto dipilih: ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
    }
});

// Re-open modal on validation error
document.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
        openTestimoniModal();
    @endif
});

// Watch overflow
[document.getElementById('testimoni-modal'), document.getElementById('fcc-confirm-modal')].forEach(el => {
    if(!el) return;
    const obs = new MutationObserver(() => {
        const visible = document.getElementById('testimoni-modal')?.style.display !== 'none' ||
                        document.getElementById('fcc-confirm-modal')?.style.display !== 'none';
        document.body.style.overflow = visible ? 'hidden' : '';
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endsection
