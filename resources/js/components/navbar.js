/**
 * FCC Navbar — selalu hitam (fixed)
 * Fix: navbar sempat jadi putih menyebabkan elemen kuning tidak kelihatan.
 */
(function () {
    'use strict';

    const SEARCH_ENDPOINT = '/api/search';

    function initNavbar() {
        const nav = document.getElementById('fcc-nav');
        if (!nav) return;

        // Pastikan nav selalu dark (tidak berubah saat scroll)
        nav.style.background   = '#131218';
        nav.style.boxShadow    = '0 1px 0 rgba(255,200,26,.15)';

        // Tambah padding top ke konten agar tidak tertutup nav
        const wrap = document.querySelector('.page-content-wrap');
        if (wrap && !wrap.style.paddingTop) wrap.style.paddingTop = '68px';
    }

    function initNavSearch() {
        const inp  = document.getElementById('nav-search-inp');
        const drop = document.getElementById('nav-dropdown');
        if (!inp || !drop) return;

        let timer;
        function ucfirst(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; }

        inp.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(async () => {
                const q = inp.value.trim();
                if (q.length < 2) { drop.style.display = 'none'; return; }
                try {
                    const data = await fetch(
                        `${SEARCH_ENDPOINT}?q=${encodeURIComponent(q)}&ajax=1`,
                        { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
                    ).then(r => r.json());

                    if (!data.results?.length) { drop.style.display = 'none'; return; }

                    drop.innerHTML = data.results.slice(0, 6).map(r => `
                        <a href="${r.url}" class="nav-search-item">
                            <div class="nav-search-icon">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                     stroke="#FFC81A" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="nav-search-text">
                                <span class="nav-search-judul">${r.judul}</span>
                                <span class="nav-search-meta">${ucfirst(r.jenis)} · ${r.tanggal}</span>
                            </div>
                        </a>
                    `).join('') +
                    `<a href="${SEARCH_ENDPOINT}?q=${encodeURIComponent(q)}" class="nav-search-all">
                        Lihat ${data.total} hasil &rarr;
                    </a>`;
                    drop.style.display = 'block';
                } catch (_) {}
            }, 280);
        });

        inp.addEventListener('focus', () => {
            if (drop.innerHTML.trim()) drop.style.display = 'block';
        });
        document.addEventListener('click', e => {
            if (!e.target.closest('#nav-search-box')) drop.style.display = 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initNavbar();
        initNavSearch();
    });
})();
