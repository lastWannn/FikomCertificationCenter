/**
 * FCC Landing Index Page — Animation Suite
 */
(function () {
    'use strict';

    const { arsips = [] } = window.PAGE_DATA || {};

    /* ── 2. HERO PARTICLE CANVAS ─────────────────────────────────── */
    function initParticles() {
        const canvas = document.getElementById('hero-particles');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let W, H, particles, animId;
        let isVisible = true;

        function resize() {
            if (!canvas.parentElement) return;
            W = canvas.width  = canvas.parentElement.offsetWidth;
            H = canvas.height = canvas.parentElement.offsetHeight;
        }

        function createParticles() {
            const count = Math.min(15, Math.floor(W * H / 50000));
            particles = Array.from({ length: count }, () => ({
                x:     Math.random() * W,
                y:     Math.random() * H,
                r:     Math.random() * 1.5 + .3,
                vx:    (Math.random() - .5) * .15,
                vy:    -(Math.random() * .2 + .08),
                alpha: Math.random() * .4 + .1,
            }));
        }

        function draw() {
            if (!isVisible) return;
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
            animId = requestAnimationFrame(draw);
        }

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    isVisible = entry.isIntersecting;
                    if (isVisible) draw();
                    else if (animId) cancelAnimationFrame(animId);
                });
            }, { threshold: 0.05 });
            observer.observe(canvas);
        }

        resize();
        createParticles();
        draw();
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => { resize(); createParticles(); }, 200);
        });
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

    /* ── INIT ────────────────────────────────────────────────────── */
    // Critical: runs immediately (needed for visible content)
    function initCritical() {
        initCounters();
        initFilter();
    }

    // Non-critical: deferred until browser is idle (visual effects)
    function initDeferred() {
        (window.requestIdleCallback || setTimeout)(function() {
            initParticles();
            initTilt();
            initMagnetic();
            initArsipCarousel();
        });
    }

    function initAll() {
        initCritical();
        initDeferred();
    }

    document.addEventListener('DOMContentLoaded', initAll);
    document.addEventListener('livewire:navigated', initAll);
})();
