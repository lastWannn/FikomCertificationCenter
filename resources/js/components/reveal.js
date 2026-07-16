/**
 * FCC Reveal Animations
 * Menggunakan IntersectionObserver untuk animasi elemen saat masuk viewport.
 * Class .reveal, .rl, .rr, .stat-card-light
 */
(function () {
    'use strict';

    if (!('IntersectionObserver' in window)) {
        // Fallback: langsung tampilkan semua
        document.querySelectorAll('.reveal,.rl,.rr,.stat-card-light').forEach(el => {
            el.classList.add('vis');
        });
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('vis');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.reveal, .rl, .rr, .stat-card-light').forEach(el => {
            observer.observe(el);
        });
    });
})();
