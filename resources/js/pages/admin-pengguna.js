/**
 * FCC Admin Manajemen Pengguna
 * Toggle dropdown status per baris tabel peserta.
 */
(function () {
    'use strict';

    window.toggleDropdown = function (id) {
        const el = document.getElementById(id);
        if (!el) return;
        document.querySelectorAll('[id^="drop-"]').forEach(d => {
            if (d.id !== id) { 
                d.style.display = 'none'; 
                d.style.top = 'calc(100% + 6px)'; 
                d.style.bottom = 'auto'; 
                if (d.parentElement) d.parentElement.style.zIndex = '';
                const tr = d.closest('tr');
                if (tr) { tr.style.zIndex = ''; tr.style.position = ''; }
            }
        });
        
        if (el.style.display === 'none' || el.style.display === '') {
            el.style.display = 'block';
            
            if (el.parentElement) el.parentElement.style.zIndex = '9999';
            const tr = el.closest('tr');
            if (tr) { tr.style.position = 'relative'; tr.style.zIndex = '999'; }
            
            // Deteksi tabrakan layar bawah
            const rect = el.getBoundingClientRect();
            if (rect.bottom > (window.innerHeight || document.documentElement.clientHeight)) {
                el.style.top = 'auto';
                el.style.bottom = 'calc(100% + 6px)';
            } else {
                el.style.top = 'calc(100% + 6px)';
                el.style.bottom = 'auto';
            }
        } else {
            el.style.display = 'none';
            if (el.parentElement) el.parentElement.style.zIndex = '';
            const tr = el.closest('tr');
            if (tr) { tr.style.zIndex = ''; tr.style.position = ''; }
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('click', e => {
            if (!e.target.closest('[onclick*="toggleDropdown"]') &&
                !e.target.closest('[id^="drop-"]')) {
                document.querySelectorAll('[id^="drop-"]').forEach(d => {
                    d.style.display = 'none';
                    if (d.parentElement) d.parentElement.style.zIndex = '';
                    const tr = d.closest('tr');
                    if (tr) { tr.style.zIndex = ''; tr.style.position = ''; }
                });
            }
        });
    });
})();
