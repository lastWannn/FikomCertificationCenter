/**
 * FCC Jelajahi Kegiatan — Modal Konfirmasi Pendaftaran (Fast & Responsive)
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
        if (form$) {
            form$.action = `/peserta/daftar/${kegiatanId}`;
            
            // Reset submit button state
            const btn = form$.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btn.innerHTML = `✔ Konfirmasi Pendaftaran`;
            }
        }

        if (biaya$) {
            if (biayaList && biayaList.length > 0) {
                const options = biayaList.map((b, idx) => `
                    <label style="display:flex;align-items:center;gap:12px;background:${idx === 0 ? '#FFFDF5' : '#F7F8FA'};border:2px solid ${idx === 0 ? '#FFC81A' : '#E2E4EB'};border-radius:12px;padding:12px 16px;margin-bottom:10px;cursor:pointer;transition:all 0.18s ease;"
                           onclick="highlightBiayaOption(this)">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <input type="radio" name="biaya_kegiatan_id" value="${b.id}" ${idx === 0 ? 'checked' : ''} style="accent-color:#FFC81A;width:17px;height:17px;cursor:pointer;" required>
                            <span style="font-size:13.5px;font-weight:800;color:#0F0F14;">${b.nama_jenis}</span>
                        </div>
                    </label>
                `).join('');

                biaya$.innerHTML = `
                    <p style="font-size:11px;font-weight:900;color:#131218;text-transform:uppercase;letter-spacing:0.7px;margin:0 0 10px;">
                        Pilih Kategori Peserta Anda:
                    </p>
                    <div style="margin-bottom:18px;" id="biaya-radio-group">
                        ${options}
                    </div>
                `;
            } else {
                biaya$.innerHTML = `
                    <div style="background:#ECFDF5;border:1.5px solid #10B981;border-radius:12px;padding:14px;margin-bottom:18px;color:#065F46;font-size:13.5px;font-weight:800;text-align:center;">
                        ✓ Kegiatan ini Gratis! Anda akan langsung terdaftar setelah konfirmasi.
                    </div>
                `;
            }
        }

        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    };

    window.highlightBiayaOption = function (selectedLabel) {
        const group = document.getElementById('biaya-radio-group');
        if (!group) return;
        group.querySelectorAll('label').forEach(lbl => {
            const radio = lbl.querySelector('input');
            if (radio && radio.checked) {
                lbl.style.borderColor = '#FFC81A';
                lbl.style.background = '#FFFDF5';
            } else {
                lbl.style.borderColor = '#E2E4EB';
                lbl.style.background = '#F7F8FA';
            }
        });
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

        // Instant form submit feedback
        const form$ = document.getElementById('daftar-form');
        if (form$) {
            form$.addEventListener('submit', function() {
                const btn = form$.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.style.opacity = '0.75';
                    btn.style.cursor = 'wait';
                    btn.innerHTML = `<span style="display:inline-flex;align-items:center;gap:8px;">⏳ Memproses Pendaftaran...</span>`;
                }
            });
        }
    });
})();
