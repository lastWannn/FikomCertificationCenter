{{--
    FCC Modal System Component
    CSS: resources/css/app.css (sudah diimport global)
    JS:  resources/js/components/modal.js (diimport app.js)

    Cara pakai di view:
      Toast otomatis dari session flash.
      Confirm: onclick="fccConfirm({title:'...',msg:'...',action:'...'})"
--}}

{{-- ── TOAST CONTAINER ─────────────────────────────────────────── --}}
<div id="fcc-toast-wrap" role="region" aria-live="polite" aria-label="Notifikasi"></div>

{{-- ── CONFIRMATION MODAL ────────────────────────────────────────── --}}
<div id="fcc-modal-overlay" onclick="fccModalClose()" role="dialog"
     aria-modal="true" aria-labelledby="fcc-modal-title">
    <div id="fcc-modal-card" onclick="event.stopPropagation()">
        <div id="fcc-modal-icon"></div>
        <h3 id="fcc-modal-title"></h3>
        <p  id="fcc-modal-msg"></p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="fccModalClose()" class="fcc-btn-outline-dark"
                    style="padding:10px 22px;font-size:14px;">
                Batal
            </button>
            <form id="fcc-modal-form" method="POST" style="display:inline;">
                @csrf
                <input id="fcc-modal-method" type="hidden" name="_method" value="DELETE">
                <button type="submit" id="fcc-modal-btn"
                        style="padding:10px 22px;border-radius:10px;border:none;font-size:14px;font-weight:700;cursor:pointer;">
                </button>
            </form>
        </div>
        <button onclick="fccModalClose()" aria-label="Tutup" style="
            position:absolute;top:14px;right:14px;width:28px;height:28px;
            border:none;background:none;cursor:pointer;color:#9CA3B0;
            font-size:18px;line-height:1;border-radius:8px;transition:background .15s;"
            onmouseover="this.style.background='#F7F8FA'"
            onmouseout="this.style.background='none'">&#215;</button>
    </div>
</div>

{{-- ── PHP FLASH DATA → JS (satu-satunya inline script yang tersisa) ── --}}
<script>
window.FCC_FLASH = {!! json_encode([
    'success' => session('success'),
    'error'   => session('error'),
    'warning' => session('warning'),
    'info'    => session('info'),
    'errors'  => $errors->first(),
]) !!};
</script>
{{-- JS modal dimuat dari resources/js/components/modal.js via app.js --}}
