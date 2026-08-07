/**
 * FCC Admin Dashboard — Chart.js Real-time Charts
 * Data endpoints dari window.PAGE_DATA.api.*
 */
(function () {
    'use strict';

    let chartPend, chartDaft, chartJenis;

    async function loadCharts() {
        const { api = {} } = window.PAGE_DATA || {};
        const BASE = api.base || '/admin/api';

        const canvasPend = document.getElementById('chartPendapatan');
        const canvasDaft = document.getElementById('chartPendaftaran');
        if (!canvasPend && !canvasDaft) return;

        const yr = document.getElementById('chart-year')?.value || new Date().getFullYear();
        const yearLbl = document.getElementById('chart-year-label');
        if (yearLbl) yearLbl.textContent = yr;

        // Line: pendapatan
        if (canvasPend) {
            try {
                const rPend = await fetch(`${BASE}/chart/pendapatan?tahun=${yr}`).then(r => r.json());
                if (chartPend) chartPend.destroy();
                chartPend = new Chart(canvasPend, {
                    type: 'line',
                    data: rPend,
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
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
        }

        // Bar: pendaftaran
        if (canvasDaft) {
            try {
                const rDaft = await fetch(`${BASE}/chart/pendaftaran?tahun=${yr}`).then(r => r.json());
                if (chartDaft) chartDaft.destroy();
                chartDaft = new Chart(canvasDaft, {
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
    }

    async function loadPie() {
        const { api = {} } = window.PAGE_DATA || {};
        const BASE = api.base || '/admin/api';
        const canvasJenis = document.getElementById('chartJenis');
        if (!canvasJenis) return;

        try {
            const rJenis = await fetch(`${BASE}/chart/kegiatan`).then(r => r.json());
            if (chartJenis) chartJenis.destroy();
            chartJenis = new Chart(canvasJenis, {
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
        const { api = {} } = window.PAGE_DATA || {};
        const STATS = api.stats || '/admin/api/chart/stats';

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

    function initDashboard() {
        if (!document.getElementById('chartPendapatan') && !document.getElementById('chartPendaftaran')) return;
        loadCharts();
        loadPie();
        updateStats();
        document.getElementById('chart-year')?.removeEventListener('change', loadCharts);
        document.getElementById('chart-year')?.addEventListener('change', loadCharts);
    }

    document.addEventListener('DOMContentLoaded', initDashboard);
    document.addEventListener('livewire:navigated', initDashboard);
})();
