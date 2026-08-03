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
                const items = biayaList.map(b => `
                    <div style="background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;padding:12px;margin-bottom:10px;">
                        <p style="margin:0 0 2px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:0.5px;">
                            ${b.nama_jenis}
                        </p>
                        <p style="margin:0;font-size:16px;font-weight:900;color:#10B981;font-family:monospace;">
                            Rp ${parseInt(b.nominal).toLocaleString('id-ID')}
                        </p>
                    </div>
                `).join('');
                biaya$.innerHTML = `
                    <p style="font-size:12px;color:#6B7280;margin:0 0 10px;font-weight:600;">
                        Biaya Kegiatan (Tarif Otomatis Sistem):
                    </p>
                    ${items}
                    <p style="font-size:11px;color:#9CA3B0;margin:0 0 16px;">
                        *Sistem otomatis menetapkan tarif yang sesuai dengan status akun pendaftar.
                    </p>
                `;
            } else {
                biaya$.innerHTML = `
                    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.2);border-radius:10px;padding:14px;margin-bottom:16px;color:#059669;font-size:13px;font-weight:700;text-align:center;">
                        &#10003; Kegiatan ini Gratis! Langsung terdaftar setelah konfirmasi.
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
