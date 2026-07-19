/**
 * FCC Landing Index Page
 * Fix: step animation garis tidak sinkron mulai step 2+
 */
(function () {
    'use strict';

    const { arsips = [], searchRoute = '/api/search' } = window.PAGE_DATA || {};

    /* ── Filter kegiatan ─────────────────────────────────────── */
    function initFilter() {
        const cards   = document.querySelectorAll('.kegiatan-card');
        const buttons = document.querySelectorAll('[data-filter]');
        if (!cards.length) return;
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const val = btn.dataset.filter;
                cards.forEach(c => { c.style.display = (val === 'all' || c.dataset.jenis === val) ? '' : 'none'; });
                buttons.forEach(b => {
                    const active = b.dataset.filter === val;
                    b.style.background = active ? '#131218' : 'transparent';
                    b.style.color      = active ? '#FFC81A' : '#9CA3B0';
                });
            });
        });
    }

    /* ── Step animation (FIXED) ─────────────────────────────── */
    function initSteps() {
        const STEP_COUNT = 4;
        let curStep = 0, stepTimer;

        // Width garis progres berdasarkan step aktif
        // Garis dimulai dari center step-0 ke center step-3
        // 4 kolom equal: center masing-masing di 12.5%, 37.5%, 62.5%, 87.5%
        // Fill dimulai dari 0% (di step-0) → per step +33.3% dari lebar garis
        const FILL_WIDTHS = ['0%', '33.3%', '66.6%', '100%'];

        function setStep(s) {
            curStep = s;

            for (let i = 0; i < STEP_COUNT; i++) {
                const box   = document.getElementById(`step-box-${i}`);
                const num   = document.getElementById(`step-num-${i}`);
                const title = document.getElementById(`step-title-${i}`);
                const ic    = box?.querySelector('svg');
                if (!box) continue;

                const isActive = i === s;
                const isPast   = i < s;

                // Box styling
                if (isActive) {
                    box.style.background = 'linear-gradient(135deg,#FFC81A,#FFD84D)';
                    box.style.border     = 'none';
                    box.style.boxShadow  = '0 8px 28px rgba(255,200,26,.4)';
                } else if (isPast) {
                    box.style.background = 'rgba(255,200,26,.1)';
                    box.style.border     = '1.5px solid rgba(255,200,26,.3)';
                    box.style.boxShadow  = 'none';
                } else {
                    box.style.background = 'rgba(255,255,255,.08)';
                    box.style.border     = '1.5px solid rgba(255,255,255,.12)';
                    box.style.boxShadow  = 'none';
                }

                // Icon color
                if (ic) ic.style.color = isActive ? '#131218' : (isPast ? 'rgba(255,200,26,.7)' : 'rgba(255,255,255,.35)');

                // Number badge
                if (num) {
                    num.style.background = i <= s ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'rgba(255,255,255,.12)';
                    num.style.color      = i <= s ? '#131218' : 'rgba(255,255,255,.35)';
                }

                // Title
                if (title) {
                    title.style.color      = isActive ? '#FFF' : (isPast ? 'rgba(255,255,255,.65)' : 'rgba(255,255,255,.4)');
                    title.style.fontWeight = isActive ? '800' : '600';
                }
            }

            // FIX: update fill line width
            const fill = document.getElementById('step-fill');
            if (fill) fill.style.width = FILL_WIDTHS[s];

            // Dots
            document.querySelectorAll('#step-dots div').forEach((d, i) => {
                d.style.width      = i === s ? '20px' : '8px';
                d.style.background = i === s ? '#FFC81A' : 'rgba(255,255,255,.15)';
            });
        }

        function startTimer() {
            stepTimer = setInterval(() => setStep((curStep + 1) % STEP_COUNT), 2400);
        }

        window.setStep   = setStep;

        for (let i = 0; i < STEP_COUNT; i++) {
            const el = document.getElementById(`step-${i}`);
            if (el) {
                el.addEventListener('click', () => {
                    clearInterval(stepTimer);
                    window.setStep(i);
                    startTimer(); // Restart timer from clicked step
                });
            }
        }

        setStep(0);
        startTimer();
    }

    /* ── Arsip carousel ─────────────────────────────────────── */
    function initArsipCarousel() {
        const grid = document.getElementById('arsip-grid');
        const dots = document.getElementById('arsip-dots');
        if (!grid || !arsips.length) return;

        const PER_PAGE = 3;
        const totalPages = Math.ceil(arsips.length / PER_PAGE);
        let page = 0;

        function buildCard(a) {
            return `
            <a href="${a.url}" class="arsip-card" style="text-decoration:none;">
                <div class="arsip-card-thumb">
                    <div class="arsip-card-grid-overlay"></div>
                    <div class="arsip-card-circle"></div>
                    <div class="arsip-card-icon-wrap">
                        <div class="arsip-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <span class="arsip-card-doc-label">Dokumentasi</span>
                    </div>
                    <span class="arsip-card-badge">Kegiatan</span>
                </div>
                <div class="arsip-card-body">
                    <p class="arsip-card-title">${(a.judul || 'Arsip Kegiatan').substring(0, 46)}</p>
                    <p class="arsip-card-date">${(a.created_at || '').split('T')[0] || ''}</p>
                    <p class="arsip-card-desc">${a.ringkasan || 'Kegiatan telah selesai dilaksanakan.'}</p>
                    <span class="arsip-card-link">
                        Baca Selengkapnya
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </span>
                </div>
            </a>`;
        }

        function render() {
            const items = arsips.slice(page * PER_PAGE, (page + 1) * PER_PAGE);
            while (items.length < PER_PAGE && arsips.length > 0) {
                items.push(arsips[items.length % arsips.length]);
            }
            grid.style.opacity = '0';
            setTimeout(() => {
                grid.innerHTML = items.map(buildCard).join('');
                grid.style.opacity = '1';
                grid.style.transition = 'opacity .3s';
            }, 180);

            if (dots) {
                dots.innerHTML = Array.from({ length: totalPages }, (_, i) => `
                <div class="arsip-dot ${i === page ? 'arsip-dot--active' : ''}" data-page="${i}"></div>`
                ).join('');
                dots.querySelectorAll('.arsip-dot').forEach(d => {
                    d.addEventListener('click', () => goTo(+d.dataset.page));
                });
            }
        }

        function goTo(p) { page = ((p % totalPages) + totalPages) % totalPages; render(); }
        window.arsipNext = () => goTo(page + 1);
        window.arsipPrev = () => goTo(page - 1);

        render();
        setInterval(window.arsipNext, 5000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        initFilter();
        initSteps();
        initArsipCarousel();
    });
})();
