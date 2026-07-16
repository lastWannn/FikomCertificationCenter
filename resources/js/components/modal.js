/**
 * FCC Modal & Toast System
 * Toast: fccToast(message, type, title?)
 * Confirm Modal: fccConfirm({ title, msg, action, method, btnText, danger })
 * Auto-triggered dari window.FCC_FLASH (set di Blade)
 */
(function () {
    'use strict';

    const ICONS = {
        success: '✓',
        error:   '✕',
        warning: '⚠',
        info:    'ℹ',
    };
    const LABELS = { success: 'Berhasil', error: 'Error', warning: 'Peringatan', info: 'Informasi' };

    /* ── Toast ───────────────────────────────────────────────────── */
    function fccToast(message, type = 'success', title = '') {
        const wrap = document.getElementById('fcc-toast-wrap');
        if (!wrap || !message) return;

        const id    = 'toast-' + Date.now() + Math.random().toString(36).slice(2, 6);
        const label = title || LABELS[type] || 'Notifikasi';
        const icon  = ICONS[type] || ICONS.success;

        const el = document.createElement('div');
        el.id        = id;
        el.className = `fcc-toast fcc-toast-${type}`;
        el.setAttribute('role', 'alert');
        el.innerHTML = `
            <div class="fcc-toast-icon">${icon}</div>
            <div class="fcc-toast-body">
                <p class="fcc-toast-title">${label}</p>
                <p class="fcc-toast-msg">${message}</p>
            </div>
            <button class="fcc-toast-close" aria-label="Tutup">&times;</button>
            <div class="fcc-toast-progress"></div>
        `;
        el.querySelector('.fcc-toast-close').addEventListener('click', () => fccToastRemove(id));
        el.addEventListener('click', () => fccToastRemove(id));
        wrap.appendChild(el);

        setTimeout(() => fccToastRemove(id), 4200);
    }

    function fccToastRemove(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('hiding');
        setTimeout(() => el.remove(), 300);
    }

    /* ── Confirm Modal ───────────────────────────────────────────── */
    function fccConfirm({ title, msg, action, method = 'DELETE', btnText = 'Hapus', danger = true }) {
        const overlay = document.getElementById('fcc-modal-overlay');
        if (!overlay) return;

        const color = danger ? '#EF4444' : '#FFC81A';
        const iconSvg = danger
            ? `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="${color}" stroke-width="2.5" stroke-linecap="round">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
               </svg>`
            : `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="${color}" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
               </svg>`;

        document.getElementById('fcc-modal-icon').style.background =
            danger ? 'rgba(239,68,68,.1)' : 'rgba(255,200,26,.12)';
        document.getElementById('fcc-modal-icon').innerHTML        = iconSvg;
        document.getElementById('fcc-modal-title').textContent     = title || 'Konfirmasi';
        document.getElementById('fcc-modal-msg').textContent       = msg   || 'Apakah Anda yakin?';
        document.getElementById('fcc-modal-form').action           = action;
        document.getElementById('fcc-modal-method').value          = method;

        const btn = document.getElementById('fcc-modal-btn');
        btn.textContent        = btnText;
        btn.style.background   = danger ? '#EF4444' : '#FFC81A';
        btn.style.color        = danger ? '#FFF'    : '#131218';

        overlay.classList.add('open');
    }

    function fccModalClose() {
        const overlay = document.getElementById('fcc-modal-overlay');
        if (!overlay) return;
        overlay.classList.add('closing');
        setTimeout(() => overlay.classList.remove('open', 'closing'), 200);
    }

    /* ── Auto-trigger dari FCC_FLASH ─────────────────────────────── */
    function initFlash() {
        const flash = window.FCC_FLASH || {};
        if (flash.success) fccToast(flash.success, 'success');
        if (flash.error)   fccToast(flash.error,   'error');
        if (flash.warning) fccToast(flash.warning,  'warning');
        if (flash.info)    fccToast(flash.info,     'info');
        if (flash.errors)  fccToast(flash.errors,   'error', 'Validasi Gagal');
    }

    /* ── Keyboard close ──────────────────────────────────────────── */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') fccModalClose();
    });

    /* ── Export ke global ────────────────────────────────────────── */
    window.fccToast      = fccToast;
    window.fccConfirm    = fccConfirm;
    window.fccModalClose = fccModalClose;

    document.addEventListener('DOMContentLoaded', initFlash);
})();
