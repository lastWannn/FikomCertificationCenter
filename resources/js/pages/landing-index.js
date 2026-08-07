/**
 * FCC Landing Index Page — Full Animation Suite
 * 1. Hero Parallax (mouse tracking)
 * 2. Hero Particle Canvas
 * 3. Number Counter (scroll-triggered)
 * 4. 3D Tilt Cards (Vanilla JS)
 * 5. Magnetic Buttons
 * 6. Animated filter with spring transition
 * 7. Step animation (CSS class-based)
 * 8. Arsip carousel
 */
(function () {
    'use strict';

    const { arsips = [] } = window.PAGE_DATA || {};

    /* ── 1. HERO PARALLAX ────────────────────────────────────────── */
    function initHeroParallax() {
        const hero   = document.querySelector('[data-hero]');
        if (!hero) return;
        const layers = hero.querySelectorAll('.parallax-layer');
        if (!layers.length) return;

        let ticking = false;
        hero.addEventListener('mousemove', (e) => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                const rect = hero.getBoundingClientRect();
                const cx   = rect.width  / 2;
                const cy   = rect.height / 2;
                const dx   = (e.clientX - rect.left - cx) / cx;
                const dy   = (e.clientY - rect.top  - cy) / cy;
                layers.forEach(layer => {
                    const speed = parseFloat(layer.dataset.parallax || 15);
                    layer.style.transform = `translate(${dx * speed}px, ${dy * speed}px)`;
                });
                ticking = false;
            });
        });
        hero.addEventListener('mouseleave', () => {
            layers.forEach(l => (l.style.transform = 'translate(0,0)'));
        });
    }

    /* ── 2. HERO PARTICLE CANVAS ─────────────────────────────────── */
    function initParticles() {
        const canvas = document.getElementById('hero-particles');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let W, H, particles;

        function resize() {
            W = canvas.width  = canvas.parentElement.offsetWidth;
            H = canvas.height = canvas.parentElement.offsetHeight;
        }

        function createParticles() {
            const count = Math.min(70, Math.floor(W * H / 12000));
            particles = Array.from({ length: count }, () => ({
                x:     Math.random() * W,
                y:     Math.random() * H,
                r:     Math.random() * 1.8 + .3,
                vx:    (Math.random() - .5) * .25,
                vy:    -(Math.random() * .4 + .15),
                alpha: Math.random() * .55 + .15,
            }));
        }

        function draw() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(255,200,26,${p.alpha})`;
                ctx.fill();
                p.x += p.vx;
                p.y += p.vy;
                if (p.y < -5)   { p.y = H + 5; p.x = Math.random() * W; }
                if (p.x < -5)   p.x = W + 5;
                if (p.x > W + 5) p.x = -5;
            });
            requestAnimationFrame(draw);
        }

        resize();
        createParticles();
        draw();
        window.addEventListener('resize', () => { resize(); createParticles(); });
    }

    /* ── 3. NUMBER COUNTER ───────────────────────────────────────── */
    function initCounters() {
        const counters = document.querySelectorAll('[data-count]');
        if (!counters.length) return;

        function animateCount(el) {
            const target   = parseInt(el.dataset.count, 10);
            const suffix   = el.dataset.suffix || '';
            const duration = 1800;
            const start    = performance.now();
            function easeOut(t) { return 1 - Math.pow(1 - t, 3); }
            function tick(now) {
                const progress = Math.min((now - start) / duration, 1);
                el.textContent = Math.floor(easeOut(progress) * target) + suffix;
                if (progress < 1) requestAnimationFrame(tick);
                else el.textContent = target + suffix;
            }
            requestAnimationFrame(tick);
        }

        if (!('IntersectionObserver' in window)) {
            counters.forEach(el => animateCount(el));
            return;
        }

        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(el => {
            el.textContent = '0' + (el.dataset.suffix || '');
            obs.observe(el);
        });
    }

    /* ── 4. 3D TILT CARDS ────────────────────────────────────────── */
    function initTilt() {
        if ('ontouchstart' in window) return;
        document.querySelectorAll('.tilt-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect    = card.getBoundingClientRect();
                const x       = e.clientX - rect.left;
                const y       = e.clientY - rect.top;
                const cx      = rect.width  / 2;
                const cy      = rect.height / 2;
                const rotateX = ((y - cy) / cy) * -9;
                const rotateY = ((x - cx) / cx) *  9;
                card.style.transform  = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.025,1.025,1.025)`;
                card.style.transition = 'transform .08s ease';

                let glare = card.querySelector('.tilt-glare');
                if (!glare) {
                    glare = document.createElement('div');
                    glare.className    = 'tilt-glare';
                    glare.style.cssText = 'position:absolute;inset:0;border-radius:inherit;pointer-events:none;z-index:50;';
                    if (getComputedStyle(card).position === 'static') card.style.position = 'relative';
                    card.appendChild(glare);
                }
                glare.style.background = `radial-gradient(circle at ${(x/rect.width)*100}% ${(y/rect.height)*100}%, rgba(255,255,255,.14) 0%, transparent 65%)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform  = 'perspective(800px) rotateX(0deg) rotateY(0deg) scale3d(1,1,1)';
                card.style.transition = 'transform .45s cubic-bezier(.23,1,.32,1)';
                const glare = card.querySelector('.tilt-glare');
                if (glare) glare.style.background = 'transparent';
            });
        });
    }

    /* ── 5. MAGNETIC BUTTONS ─────────────────────────────────────── */
    function initMagnetic() {
        if ('ontouchstart' in window) return;
        document.querySelectorAll('.btn-magnetic').forEach(btn => {
            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const dx   = (e.clientX - rect.left - rect.width  / 2) * .35;
                const dy   = (e.clientY - rect.top  - rect.height / 2) * .35;
                btn.style.transform = `translate(${dx}px, ${dy}px)`;
            });
            btn.addEventListener('mouseleave', () => {
                btn.style.transform = 'translate(0,0)';
            });
        });
    }

    /* ── 6. ANIMATED FILTER ──────────────────────────────────────── */
    function initFilter() {
        const cards   = document.querySelectorAll('.kegiatan-card');
        const buttons = document.querySelectorAll('[data-filter]');
        if (!cards.length) return;

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const val = btn.dataset.filter;
                buttons.forEach(b => {
                    const active     = b.dataset.filter === val;
                    b.style.background = active ? '#131218' : 'transparent';
                    b.style.color      = active ? '#FFC81A' : '#9CA3B0';
                });

                let delay = 0;
                cards.forEach(c => {
                    const show = val === 'all' || c.dataset.jenis === val;
                    if (show) {
                        c.style.display         = '';
                        c.style.animationDelay  = `${delay}ms`;
                        c.classList.remove('filtering-hide');
                        delay += 60;
                    } else {
                        c.classList.add('filtering-hide');
                        setTimeout(() => {
                            c.style.display = 'none';
                            c.classList.remove('filtering-hide');
                        }, 360);
                    }
                });
            });
        });
    }

    /* ── 7. STEP ANIMATION ───────────────────────────────────────── */
    function initSteps() {
        const STEP_COUNT = 4;
        let curStep = 0, stepTimer, iconTimeout;
        const FILL_WIDTHS = ['0%', 'calc(33.33% - 35px)', 'calc(66.66% - 35px)', 'calc(100% - 70px)'];

        function setStep(s) {
            curStep = s;
            clearTimeout(iconTimeout);

            const fill = document.getElementById('step-fill');
            if (fill) fill.style.width = FILL_WIDTHS[s];

            document.querySelectorAll('#step-dots div').forEach((d, i) => {
                d.style.width      = i === s ? '20px' : '8px';
                d.style.background = i === s ? '#FFC81A' : 'rgba(255,255,255,.15)';
            });

            for (let i = 0; i < STEP_COUNT; i++) {
                const el = document.getElementById(`step-${i}`);
                if (!el) continue;
                
                if (i < s) {
                    el.classList.add('past');   
                    el.classList.remove('active');
                } else if (i > s) {
                    el.classList.remove('active', 'past');
                }
            }
            
            const activeEl = document.getElementById(`step-${s}`);
            if (activeEl) {
                if (s === 0) {
                    activeEl.classList.add('active'); 
                    activeEl.classList.remove('past');
                } else {
                    iconTimeout = setTimeout(() => {
                        activeEl.classList.add('active'); 
                        activeEl.classList.remove('past');
                    }, 400);
                }
            }
        }

        function startTimer() { stepTimer = setInterval(() => setStep((curStep + 1) % STEP_COUNT), 2800); }
        window.setStep = setStep;

        for (let i = 0; i < STEP_COUNT; i++) {
            const el = document.getElementById(`step-${i}`);
            if (el) el.addEventListener('click', () => { clearInterval(stepTimer); setStep(i); startTimer(); });
        }
        setStep(0);
        startTimer();
    }

    /* ── 8. ARSIP CAROUSEL ───────────────────────────────────────── */
    function initArsipCarousel() {
        const grid = document.getElementById('arsip-grid');
        const dots = document.getElementById('arsip-dots');
        if (!grid || !arsips.length) return;

        const PER_PAGE   = 3;
        const totalPages = Math.ceil(arsips.length / PER_PAGE);
        let page = 0;

        function buildCard(a) {
            return `<a href="${a.url}" class="arsip-card tilt-card" style="text-decoration:none;">
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
                    <span class="arsip-card-link">Baca Selengkapnya
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </span>
                </div>
            </a>`;
        }

        function render() {
            const items = arsips.slice(page * PER_PAGE, (page + 1) * PER_PAGE);
            while (items.length < PER_PAGE && arsips.length > 0) items.push(arsips[items.length % arsips.length]);

            grid.style.cssText = 'display:grid; grid-template-columns:repeat(3,1fr); gap:18px; opacity:0; transform:translateY(12px); transition:opacity .25s ease,transform .25s ease;';
            setTimeout(() => {
                grid.innerHTML = items.map(buildCard).join('');
                grid.style.opacity = '1';
                grid.style.transform = 'translateY(0)';
                initTilt();
            }, 200);

            if (dots) {
                dots.innerHTML = Array.from({ length: totalPages }, (_, i) =>
                    `<div class="arsip-dot ${i === page ? 'arsip-dot--active' : ''}" data-page="${i}"></div>`
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
        setInterval(window.arsipNext, 5500);
    }

    /* ── INIT ────────────────────────────────────────────────────── */
    function initAll() {
        initHeroParallax();
        initParticles();
        initCounters();
        initTilt();
        initMagnetic();
        initFilter();
        initSteps();
        initArsipCarousel();
    }

    document.addEventListener('DOMContentLoaded', initAll);
    document.addEventListener('livewire:navigated', initAll);
})();
