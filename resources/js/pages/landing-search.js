/**
 * FCC Landing Search Results Page
 * Autocomplete untuk form pencarian di halaman hasil search.
 */
(function () {
    'use strict';

    function ucfirst(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; }

    function initSearchPage() {
        const input = document.getElementById('main-search');
        const drop  = document.getElementById('search-dropdown');
        if (!input || !drop) return;

        let timer;

        input.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(async () => {
                const q = input.value.trim();
                if (q.length < 2) { drop.style.display = 'none'; return; }

                try {
                    const data = await fetch(
                        `/api/search?q=${encodeURIComponent(q)}&ajax=1`,
                        { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
                    ).then(r => r.json());

                    if (!data.results?.length) { drop.style.display = 'none'; return; }

                    drop.innerHTML = data.results.map(r => `
                        <a href="${r.url}" class="search-drop-item">
                            <div class="search-drop-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="#FFC81A" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                            <div class="search-drop-text">
                                <span class="search-drop-judul">${r.judul}</span>
                                <span class="search-drop-meta">
                                    ${ucfirst(r.jenis)} &bull; ${r.tanggal} &bull; <strong>${r.biaya}</strong>
                                </span>
                            </div>
                        </a>
                    `).join('') +
                    `<a href="/api/search?q=${encodeURIComponent(q)}" class="search-drop-all">
                        Lihat semua ${data.total} hasil &rarr;
                    </a>`;
                    drop.style.display = 'block';
                } catch (_) {}
            }, 280);
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('#search-form')) drop.style.display = 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', initSearchPage);
})();
