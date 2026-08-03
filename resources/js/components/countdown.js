/**
 * FCC Countdown Timer
 * Data expiry dari window.PAGE_DATA.expiry
 * Saat timer kritis (< 5 menit), tampilkan warning.
 */
(function () {
    'use strict';

    function initCountdown() {
        const timerEl = document.getElementById('timer');
        if (!timerEl) return;

        const expiryStr = window.PAGE_DATA?.expiry;
        if (!expiryStr) return;

        const serverTimeStr = window.PAGE_DATA?.serverTime;
        const offset = serverTimeStr ? (new Date(serverTimeStr) - new Date()) : 0;

        const expiry = new Date(expiryStr);

        function tick() {
            const nowAdjusted = Date.now() + offset;
            const diff = expiry - nowAdjusted;

            if (diff <= 0) {
                timerEl.textContent = 'KADALUARSA';
                timerEl.style.color = '#EF4444';
                
                // Anti infinite reload loop: reload maks 1 kali per 10 detik
                const lastReload = sessionStorage.getItem('last_countdown_reload');
                const now = Date.now();
                if (!lastReload || (now - parseInt(lastReload, 10) > 10000)) {
                    sessionStorage.setItem('last_countdown_reload', String(now));
                    setTimeout(() => location.reload(), 2000);
                }
                return;
            }

            const h = String(Math.floor(diff / 3_600_000)).padStart(2, '0');
            const m = String(Math.floor((diff % 3_600_000) / 60_000)).padStart(2, '0');
            const s = String(Math.floor((diff % 60_000) / 1_000)).padStart(2, '0');
            timerEl.textContent = `${h}:${m}:${s}`;

            // Warna berubah saat kritis < 5 menit
            if (diff < 5 * 60 * 1000) {
                timerEl.style.color  = '#EF4444';
                timerEl.style.animation = 'blink 1s ease-in-out infinite';
            } else if (diff < 15 * 60 * 1000) {
                timerEl.style.color = '#F59E0B';
            } else {
                timerEl.style.color = '#EF4444';
            }
        }

        tick();
        const interval = setInterval(tick, 1000);

        // Bersihkan interval saat halaman ditutup
        window.addEventListener('beforeunload', () => clearInterval(interval));
    }

    window.initCountdown = initCountdown;

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(initCountdown, 0);
    } else {
        document.addEventListener('DOMContentLoaded', initCountdown);
    }
})();
