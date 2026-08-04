{{--
    FCC Modal System Component
    CSS: resources/css/app.css (sudah diimport global)
    JS:  resources/js/components/modal.js (diimport app.js)

    Cara pakai di view:
      Toast otomatis dari session flash.
      Confirm: onclick="fccConfirm({title:'...',msg:'...',action:'...'})"
--}}

{{-- ── TOAST CONTAINER ─────────────────────────────────────────── --}}
<div id="fcc-toast-wrap" style="position:fixed;top:20px;right:20px;z-index:999999 !important;" role="region" aria-live="polite" aria-label="Notifikasi"></div>

{{-- ── CONFIRMATION MODAL ────────────────────────────────────────── --}}
<div id="fcc-modal-overlay" onclick="fccModalClose()" role="dialog"
     aria-modal="true" aria-labelledby="fcc-modal-title"
     style="display:none;position:fixed;inset:0;z-index:9999999 !important;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div id="fcc-modal-card" onclick="event.stopPropagation()" style="background:#FFF;border-radius:20px;padding:32px 28px;max-width:420px;width:90%;position:relative;box-shadow:0 24px 64px rgba(0,0,0,.25);text-align:center;">
        <div id="fcc-modal-icon" style="width:54px;height:54px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;"></div>
        <h3 id="fcc-modal-title" style="font-size:18px;font-weight:900;color:#131218;margin:0 0 6px;"></h3>
        <p  id="fcc-modal-msg" style="font-size:13.5px;color:#6B7280;margin:0 0 24px;line-height:1.5;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button type="button" onclick="fccModalClose()" class="fcc-btn-outline-dark"
                    style="padding:11px 24px;font-size:13.5px;font-weight:700;border-radius:12px;cursor:pointer;border:1.5px solid #E2E4EB;background:#F7F8FA;color:#6B7280;">
                Batal
            </button>
            <button type="button" id="fcc-modal-btn" onclick="fccModalConfirmClick()"
                    style="padding:11px 24px;border-radius:12px;border:none;font-size:13.5px;font-weight:800;cursor:pointer;color:#FFF;background:#EF4444;box-shadow:0 4px 14px rgba(239,68,68,.3);transition:all .2s;"
                    onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                Ya, Hapus
            </button>
        </div>
        <button type="button" onclick="fccModalClose()" aria-label="Tutup" style="
            position:absolute;top:16px;right:16px;width:30px;height:30px;
            border:none;background:none;cursor:pointer;color:#9CA3B0;
            font-size:20px;line-height:1;border-radius:10px;transition:background .15s;"
            onmouseover="this.style.background='#F7F8FA'"
            onmouseout="this.style.background='none'">&#215;</button>
    </div>
</div>

{{-- ── PHP FLASH DATA & GLOBAL CONFIRM HELPERS ── --}}
<script>
window.FCC_FLASH = {!! json_encode([
    'success' => session('success'),
    'error'   => session('error'),
    'warning' => session('warning'),
    'info'    => session('info'),
    'errors'  => $errors->first(),
]) !!};

window.fccModalConfirmClick = function() {
    const cb = window.FCC_CONFIRM_CALLBACK;
    window.FCC_CONFIRM_CALLBACK = null;

    if (typeof window.fccModalClose === 'function') {
        window.fccModalClose();
    }

    if (cb && typeof cb === 'function') {
        cb();
    }
};

window.fccConfirmDelete = function(elem, title = 'Konfirmasi Hapus', msg = 'Apakah Anda yakin ingin menghapus data ini?') {
    const form = elem ? (elem.tagName === 'FORM' ? elem : elem.closest('form')) : null;
    if (!form) return false;
    
    if (typeof window.fccConfirm === 'function') {
        window.fccConfirm({
            title: title,
            msg: msg,
            danger: true,
            btnText: 'Ya, Hapus',
            onConfirm: function() {
                HTMLFormElement.prototype.submit.call(form);
            }
        });
    } else {
        if (confirm(msg)) HTMLFormElement.prototype.submit.call(form);
    }
    return false;
};

window.fccConfirmAction = function(elem, title = 'Konfirmasi Tindakan', msg = 'Apakah Anda yakin?', btnText = 'Ya, Lanjutkan', danger = false) {
    if (!elem) return false;
    
    if (typeof window.fccConfirm === 'function') {
        window.fccConfirm({
            title: title,
            msg: msg,
            danger: danger,
            btnText: btnText,
            onConfirm: function() {
                if (elem.form || elem.tagName === 'FORM') {
                    const form = elem.tagName === 'FORM' ? elem : elem.form;
                    HTMLFormElement.prototype.submit.call(form);
                } else if (elem.tagName === 'A' && elem.href) {
                    window.location.href = elem.href;
                }
            }
        });
    } else {
        if (confirm(msg)) {
            if (elem.form || elem.tagName === 'FORM') {
                const form = elem.tagName === 'FORM' ? elem : elem.form;
                HTMLFormElement.prototype.submit.call(form);
            } else if (elem.tagName === 'A' && elem.href) {
                window.location.href = elem.href;
            }
        }
    }
    return false;
};
</script>
{{-- JS modal dimuat dari resources/js/components/modal.js via app.js --}}
