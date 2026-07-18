/**
 * FCC Jelajahi Kegiatan — Modal Pendaftaran
 * Menampilkan modal pilih jenis biaya sebelum mendaftar.
 */
(function () {
    'use strict';

    function buildBiayaOption(b) {
        return `<label class="biaya-option">
            <input type="radio" name="biaya_kegiatan_id" value="${b.id}" required>
            <span class="biaya-option-label">
                ${b.nama_jenis} &mdash; <strong>Rp ${parseInt(b.nominal).toLocaleString('id-ID')}</strong>
            </span>
        </label>`;
    }

    window.showDaftarModal = function (kegiatanId, judul, biayaList) {
        const modal  = document.getElementById('daftar-modal');
        const judul$ = document.getElementById('modal-judul');
        const form$  = document.getElementById('daftar-form');
        const biaya$ = document.getElementById('biaya-section');
        if (!modal) return;

        if (judul$) judul$.textContent = judul;
        if (form$)  form$.action       = `/peserta/daftar/${kegiatanId}`;

        if (biaya$) {
            biaya$.innerHTML = biayaList?.length
                ? '<p class="biaya-label">Pilih Jenis Biaya *</p>' + biayaList.map(buildBiayaOption).join('')
                : '<div class="biaya-gratis">&#10003; Kegiatan ini gratis! Langsung terdaftar setelah konfirmasi.</div>';
        }

        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    };

    window.closeDaftarModal = function () {
        const modal = document.getElementById('daftar-modal');
        if (modal) {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('daftar-modal');
        if (modal) {
            modal.addEventListener('click', e => {
                if (e.target === modal) window.closeDaftarModal();
            });
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') window.closeDaftarModal();
        });
    });
})();
