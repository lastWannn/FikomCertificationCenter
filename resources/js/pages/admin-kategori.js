/**
 * FCC Admin Kategori — Inline edit helpers
 */
(function () {
    'use strict';

    window.editKategori = function (id, nama, jenis) {
        const form = document.getElementById(`edit-form-${id}`);
        if (form) form.style.display = form.style.display === 'none' ? 'block' : 'none';
    };
})();
