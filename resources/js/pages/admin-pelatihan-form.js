/**
 * FCC Admin Pelatihan Form — Preview gambar, char counter
 */
(function () {
    'use strict';

    function initImagePreview() {
        const input   = document.getElementById('gambar-input');
        const preview = document.getElementById('gambar-preview');
        if (!input || !preview) return;

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            preview.src   = url;
            preview.style.display = 'block';
        });
    }

    document.addEventListener('DOMContentLoaded', initImagePreview);
})();
