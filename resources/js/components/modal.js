/**
 * FCC Modal & Toast System
 * Toast: fccToast(message, type, title?)
 * Confirm Modal: fccConfirm({ title, msg, action, method, btnText, danger, onConfirm })
 * Auto-interceptor for native confirm(...) calls
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
    function fccConfirm({ title, msg, action, method = 'DELETE', btnText = 'Ya, Hapus', danger = true, onConfirm = null }) {
        const overlay = document.getElementById('fcc-modal-overlay');
        if (!overlay) return;

        window.FCC_CONFIRM_CALLBACK = onConfirm || null;
        window.FCC_CONFIRM_ACTION   = action || null;

        const color = danger ? '#EF4444' : '#FFC81A';
        const iconSvg = danger
            ? `<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="${color}" stroke-width="2.5" stroke-linecap="round">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
               </svg>`
            : `<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="${color}" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
               </svg>`;

        const modalIcon = document.getElementById('fcc-modal-icon');
        if (modalIcon) {
            modalIcon.style.background = danger ? 'rgba(239,68,68,.12)' : 'rgba(255,200,26,.14)';
            modalIcon.innerHTML        = iconSvg;
        }

        const modalTitle = document.getElementById('fcc-modal-title');
        if (modalTitle) modalTitle.textContent = title || 'Konfirmasi Tindakan';

        const modalMsg = document.getElementById('fcc-modal-msg');
        if (modalMsg) modalMsg.textContent = msg || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';

        const modalBtn = document.getElementById('fcc-modal-btn');
        if (modalBtn) {
            modalBtn.textContent      = btnText || (danger ? 'Ya, Hapus' : 'Ya, Lanjutkan');
            modalBtn.style.background = danger ? '#EF4444' : '#FFC81A';
            modalBtn.style.color      = danger ? '#FFF'    : '#131218';
        }

        overlay.style.display = 'flex';
        overlay.classList.remove('closing');
        overlay.classList.add('open');
    }

    function fccModalClose() {
        const overlay = document.getElementById('fcc-modal-overlay');
        if (!overlay) return;
        window.FCC_CONFIRM_CALLBACK = null;
        window.FCC_CONFIRM_ACTION   = null;
        overlay.classList.add('closing');
        setTimeout(() => {
            overlay.classList.remove('open', 'closing');
            overlay.style.display = 'none';
        }, 200);
    }

    function fccModalConfirmClick() {
        const cb = window.FCC_CONFIRM_CALLBACK;
        const action = window.FCC_CONFIRM_ACTION;
        window.FCC_CONFIRM_CALLBACK = null;
        window.FCC_CONFIRM_ACTION   = null;

        fccModalClose();

        if (cb && typeof cb === 'function') {
            cb();
        } else if (action && action !== 'javascript:void(0)') {
            const modalForm = document.getElementById('fcc-modal-form');
            if (modalForm) modalForm.submit();
        }
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

    /* ── Global Automatic Interceptor for confirm(...) ────────────── */
    document.addEventListener('DOMContentLoaded', function() {
        const modalForm = document.getElementById('fcc-modal-form');
        if (modalForm) {
            modalForm.addEventListener('submit', function(e) {
                if (confirmCallback) {
                    e.preventDefault();
                    const cb = confirmCallback;
                    confirmCallback = null;
                    fccModalClose();
                    cb();
                }
            });
        }
    });

    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form.getAttribute('data-fcc-confirmed') === 'true') {
            form.removeAttribute('data-fcc-confirmed');
            return true;
        }

        const onsubmitAttr = form.getAttribute('onsubmit') || '';
        if (onsubmitAttr.includes('confirm(')) {
            const match = onsubmitAttr.match(/confirm\s*\(\s*['"]([^'"]+)['"]\s*\)/);
            const msg = (match && match[1]) ? match[1] : 'Apakah Anda yakin ingin menghapus data ini?';
            
            e.preventDefault();
            e.stopImmediatePropagation();

            const isDelete = form.querySelector('[name="_method"][value="DELETE"]') || onsubmitAttr.toLowerCase().includes('hapus') || msg.toLowerCase().includes('hapus');

            fccConfirm({
                title: isDelete ? 'Konfirmasi Hapus' : 'Konfirmasi Tindakan',
                msg: msg,
                danger: isDelete,
                btnText: isDelete ? 'Ya, Hapus' : 'Ya, Lanjutkan',
                onConfirm: function() {
                    form.setAttribute('data-fcc-confirmed', 'true');
                    form.submit();
                }
            });
            return false;
        }
    }, true);

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('button, a');
        if (!btn) return;

        const onclickAttr = btn.getAttribute('onclick') || '';
        if (onclickAttr.includes('confirm(')) {
            if (btn.form && (btn.form.getAttribute('onsubmit') || '').includes('confirm(')) {
                return;
            }

            if (btn.getAttribute('data-fcc-confirmed') === 'true') {
                btn.removeAttribute('data-fcc-confirmed');
                return true;
            }

            const match = onclickAttr.match(/confirm\s*\(\s*['"]([^'"]+)['"]\s*\)/);
            const msg = (match && match[1]) ? match[1] : 'Apakah Anda yakin?';

            e.preventDefault();
            e.stopImmediatePropagation();

            const isDelete = onclickAttr.toLowerCase().includes('hapus') || msg.toLowerCase().includes('hapus');

            fccConfirm({
                title: isDelete ? 'Konfirmasi Hapus' : 'Konfirmasi Tindakan',
                msg: msg,
                danger: isDelete,
                btnText: isDelete ? 'Ya, Hapus' : 'Ya, Lanjutkan',
                onConfirm: function() {
                    btn.setAttribute('data-fcc-confirmed', 'true');
                    if (btn.form) {
                        btn.form.setAttribute('data-fcc-confirmed', 'true');
                        btn.form.submit();
                    } else if (btn.tagName === 'A' && btn.href) {
                        window.location.href = btn.href;
                    } else {
                        btn.click();
                    }
                }
            });
            return false;
        }
    }, true);

    function fccConfirmDelete(elem, title = 'Konfirmasi Hapus', msg = 'Apakah Anda yakin ingin menghapus data ini?') {
        const form = elem ? (elem.tagName === 'FORM' ? elem : elem.closest('form')) : null;
        if (!form) return false;
        fccConfirm({
            title: title,
            msg: msg,
            danger: true,
            btnText: 'Ya, Hapus',
            onConfirm: function() {
                form.submit();
            }
        });
        return false;
    }

    function fccConfirmAction(elem, title = 'Konfirmasi Tindakan', msg = 'Apakah Anda yakin?', btnText = 'Ya, Lanjutkan', danger = false) {
        if (!elem) return false;
        fccConfirm({
            title: title,
            msg: msg,
            danger: danger,
            btnText: btnText,
            onConfirm: function() {
                if (elem.form || elem.tagName === 'FORM') {
                    const form = elem.tagName === 'FORM' ? elem : elem.form;
                    form.submit();
                } else if (elem.tagName === 'A' && elem.href) {
                    window.location.href = elem.href;
                }
            }
        });
        return false;
    }

    /* ── Keyboard close ──────────────────────────────────────────── */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') fccModalClose();
    });

    /* ── Export ke global ────────────────────────────────────────── */
    window.fccToast             = fccToast;
    window.fccConfirm           = fccConfirm;
    window.fccConfirmDelete     = fccConfirmDelete;
    window.fccConfirmAction     = fccConfirmAction;
    window.fccModalClose        = fccModalClose;
    window.fccModalConfirmClick = fccModalConfirmClick;

    document.addEventListener('DOMContentLoaded', initFlash);
})();
