/**
 * FCC Jelajahi Kegiatan — Modal Konfirmasi Pendaftaran
 * Penentuan biaya secara otomatis oleh sistem (tanpa pilihan manual).
 */
(function () {
    'use strict';

    window.showDaftarModal = function (kegiatanId, judul, biayaList) {
        const modal  = document.getElementById('daftar-modal');
        const judul$ = document.getElementById('modal-judul');
        const form$  = document.getElementById('daftar-form');
        const biaya$ = document.getElementById('biaya-section');
        if (!modal) return;

        if (judul$) judul$.textContent = judul;
        if (form$)  form$.action       = `/peserta/daftar/${kegiatanId}`;

        if (biaya$) {
            if (biayaList && biayaList.length > 0) {
                const options = biayaList.map((b, idx) => `
                    <label style="display:flex;align-items:center;gap:12px;background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:12px;padding:12px 16px;margin-bottom:10px;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.borderColor='#FFC81A'" onmouseout="if(!this.querySelector('input').checked)this.style.borderColor='#E2E4EB'">
                        <input type="radio" name="biaya_kegiatan_id" value="${b.id}" ${idx === 0 ? 'checked' : ''} style="accent-color:#FFC81A;width:16px;height:16px;" required>
                        <span style="font-size:14px;font-weight:700;color:#0F0F14;">${b.nama_jenis}</span>
                    </label>
                `).join('');

                biaya$.innerHTML = `
                    <p style="font-size:12px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 10px;">
                        Pilih Kategori Peserta Anda:
                    </p>
                    <div style="margin-bottom:16px;">
                        ${options}
                    </div>
                `;
            } else {
                biaya$.innerHTML = `
                    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.2);border-radius:12px;padding:14px;margin-bottom:18px;color:#059669;font-size:13px;font-weight:700;text-align:center;">
                        ✓ Kegiatan ini Gratis! Anda akan langsung terdaftar setelah konfirmasi.
                    </div>
                `;
            }
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
