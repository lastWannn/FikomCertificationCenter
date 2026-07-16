/**
 * FCC Admin Dashboard — Chart.js Real-time Charts
 * Data endpoints dari window.PAGE_DATA.api.*
 */
(function () {
    'use strict';

    const { api = {} } = window.PAGE_DATA || {};
    const BASE    = api.base    || '/admin/api';
    const STATS   = api.stats   || `${BASE}/chart/stats`;

    let chartPend, chartDaft, chartJenis;

    async function loadCharts() {
        const yr     = document.getElementById('chart-year')?.value || new Date().getFullYear();
        const yearLbl = document.getElementById('chart-year-label');
        if (yearLbl) yearLbl.textContent = yr;

        // Line: pendapatan
        try {
            const rPend = await fetch(`${BASE}/chart/pendapatan?tahun=${yr}`).then(r => r.json());
            if (chartPend) chartPend.destroy();
            chartPend = new Chart(document.getElementById('chartPendapatan'), {
                type: 'line',
                data: rPend,
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins:    { legend: { display: false } },
                    scales: {
                        y: {
                            grid: { color: '#F0F1F5' },
                            ticks: { callback: v => 'Rp ' + (v >= 1e6 ? (v/1e6).toFixed(1)+'jt' : (v/1e3).toFixed(0)+'k') },
                        },
                        x: { grid: { display: false } },
                    },
                },
            });
        } catch (_) {}

        // Bar: pendaftaran
        try {
            const rDaft = await fetch(`${BASE}/chart/pendaftaran?tahun=${yr}`).then(r => r.json());
            if (chartDaft) chartDaft.destroy();
            chartDaft = new Chart(document.getElementById('chartPendaftaran'), {
                type: 'bar',
                data: rDaft,
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { grid: { color: '#F0F1F5' }, beginAtZero: true }, x: { grid: { display: false } } },
                },
            });
        } catch (_) {}
    }

    async function loadPie() {
        try {
            const rJenis = await fetch(`${BASE}/chart/kegiatan`).then(r => r.json());
            if (chartJenis) chartJenis.destroy();
            chartJenis = new Chart(document.getElementById('chartJenis'), {
                type: 'doughnut',
                data: rJenis,
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '65%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } },
                    },
                },
            });

            const legend = document.getElementById('jenis-legend');
            if (legend && rJenis.labels) {
                legend.innerHTML = rJenis.labels.map((l, i) => `
                    <span class="jenis-legend-item">
                        <span class="jenis-legend-dot"
                              style="background:${rJenis.datasets[0].backgroundColor[i]}"></span>
                        ${l}: ${rJenis.datasets[0].data[i]}
                    </span>`
                ).join('');
            }
        } catch (_) {}
    }

    async function updateStats() {
        try {
            const s = await fetch(STATS).then(r => r.json());
            const deltas = [
                null, null,
                s.peserta_baru_bulan_ini  ? `+${s.peserta_baru_bulan_ini} bulan ini`                              : null,
                s.pendapatan_bulan_ini    ? 'Rp ' + Number(s.pendapatan_bulan_ini).toLocaleString('id') + ' bulan ini' : null,
            ];
            deltas.forEach((d, i) => {
                const el = document.getElementById(`stat-delta-${i}`);
                if (el && d) el.textContent = d;
            });
        } catch (_) {}
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCharts();
        loadPie();
        updateStats();
        document.getElementById('chart-year')?.addEventListener('change', loadCharts);
        setInterval(() => { loadCharts(); updateStats(); }, 60_000);
    });
})();
