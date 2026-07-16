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
            if (d.id !== id) d.style.display = 'none';
        });
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    };

    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('click', e => {
            if (!e.target.closest('[onclick*="toggleDropdown"]') &&
                !e.target.closest('[id^="drop-"]')) {
                document.querySelectorAll('[id^="drop-"]').forEach(d => d.style.display = 'none');
            }
        });
    });
})();
