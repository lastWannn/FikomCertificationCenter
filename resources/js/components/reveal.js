/**
 * FCC Reveal Animations — Upgraded with Spring & Stagger Support
 * Classes: .reveal, .rl, .rr, .stat-card-light, .spring-up, .spring-left, .spring-right
 */
(function () {
    'use strict';

    const SELECTORS = '.reveal, .rl, .rr, .stat-card-light, .spring-up, .spring-left, .spring-right';

    if (!('IntersectionObserver' in window)) {
        document.querySelectorAll(SELECTORS).forEach(el => el.classList.add('vis'));
        return;
    }

    // Use a single shared observer for performance
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                // Get stagger delay from CSS class or inline style
                const delay = el.style.transitionDelay || el.style.animationDelay || '';
                if (!delay) {
                    // Check for stagger-N class
                    const staggerMatch = el.className.match(/stagger-(\d)/);
                    if (staggerMatch) {
                        const ms = (parseInt(staggerMatch[1]) - 1) * 100;
                        if (el.classList.contains('spring-up') || el.classList.contains('spring-left') || el.classList.contains('spring-right')) {
                            el.style.animationDelay = `${ms}ms`;
                        } else {
                            el.style.transitionDelay = `${ms}ms`;
                        }
                    }
                }
                // Small rAF to ensure browser paints first, then triggers
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => el.classList.add('vis'));
                });
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll(SELECTORS).forEach(el => observer.observe(el));
    });
})();
