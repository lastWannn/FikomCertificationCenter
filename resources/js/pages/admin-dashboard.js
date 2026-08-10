/**
 * FCC Admin Dashboard — Chart.js Real-time Charts
 * Data endpoints dari window.PAGE_DATA.api.*
 */
(function () {
    'use strict';

    let chartCombo = null;
    let chartJenis = null;
    let chartStatusPendaftar = null;

    async function loadCharts() {
        const { api = {} } = window.PAGE_DATA || {};
        const BASE = api.base || '/admin/api';

        const canvasCombo = document.getElementById('chartPendapatanPendaftaran') || document.getElementById('chartPendapatan');
        if (!canvasCombo) return;

        const yr = document.getElementById('chart-year')?.value || new Date().getFullYear();
        const metric = document.getElementById('chart-metric')?.value || 'semua';
        const yearLbl = document.getElementById('chart-year-label');
        if (yearLbl) yearLbl.textContent = yr;

        try {
            const [rPend, rDaft] = await Promise.all([
                fetch(`${BASE}/chart/pendapatan?tahun=${yr}`).then(r => r.json()),
                fetch(`${BASE}/chart/pendaftaran?tahun=${yr}`).then(r => r.json())
            ]);

            if (typeof Chart !== 'undefined') {
                const existing = Chart.getChart(canvasCombo);
                if (existing) existing.destroy();
            }
            if (chartCombo) {
                try { chartCombo.destroy(); } catch (_) {}
                chartCombo = null;
            }

            const labels = rPend.labels || rDaft.labels || ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            const dataPendapatan = rPend.datasets?.[0]?.data || [];
            const dataPendaftaran = rDaft.datasets?.[0]?.data || [];

            const datasets = [];
            const scales = {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '700' }, color: '#64748B' }
                }
            };

            if (metric === 'semua' || metric === 'pendapatan') {
                datasets.push({
                    label: 'Pendapatan (Rp)',
                    type: 'line',
                    data: dataPendapatan,
                    borderColor: '#FFC81A',
                    backgroundColor: 'rgba(255, 200, 26, 0.18)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#FFC81A',
                    pointBorderColor: '#131218',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    yAxisID: metric === 'semua' ? 'yPendapatan' : 'y',
                });

                scales[metric === 'semua' ? 'yPendapatan' : 'y'] = {
                    type: 'linear',
                    position: 'left',
                    grid: { color: '#F1F5F9' },
                    ticks: {
                        font: { size: 11, weight: '700' },
                        color: '#131218',
                        callback: v => 'Rp ' + (v >= 1e6 ? (v/1e6).toFixed(1)+'jt' : (v/1e3).toFixed(0)+'k')
                    }
                };
            }

            if (metric === 'semua' || metric === 'pendaftaran') {
                datasets.push({
                    label: 'Pendaftaran (Siswa/i)',
                    type: 'bar',
                    data: dataPendaftaran,
                    backgroundColor: '#3B82F6',
                    hoverBackgroundColor: '#2563EB',
                    borderRadius: 6,
                    yAxisID: metric === 'semua' ? 'yPendaftaran' : 'y',
                });

                scales[metric === 'semua' ? 'yPendaftaran' : 'y'] = {
                    type: 'linear',
                    position: metric === 'semua' ? 'right' : 'left',
                    grid: metric === 'pendaftaran' ? { color: '#F1F5F9' } : { display: false },
                    beginAtZero: true,
                    ticks: {
                        font: { size: 11, weight: '700' },
                        color: '#3B82F6',
                        precision: 0,
                        callback: v => v + ' Siswa'
                    }
                };
            }

            chartCombo = new Chart(canvasCombo, {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    if (ctx.dataset.label.includes('Pendapatan')) {
                                        return ` Pendapatan: Rp ${Number(ctx.parsed.y).toLocaleString('id')}`;
                                    }
                                    return ` Pendaftaran: ${ctx.parsed.y} Siswa/i`;
                                }
                            }
                        }
                    },
                    scales: scales
                }
            });
        } catch (err) {
            console.error('Chart combo error:', err);
        }
    }

    async function loadPie() {
        const { api = {} } = window.PAGE_DATA || {};
        const BASE = api.base || '/admin/api';
        const canvasJenis = document.getElementById('chartJenis');
        if (!canvasJenis) return;

        try {
            const rJenis = await fetch(`${BASE}/chart/kegiatan`).then(r => r.json());
            if (typeof Chart !== 'undefined') {
                const existing = Chart.getChart(canvasJenis);
                if (existing) existing.destroy();
            }
            if (chartJenis) {
                try { chartJenis.destroy(); } catch (_) {}
                chartJenis = null;
            }

            if (rJenis.datasets && rJenis.datasets[0]) {
                rJenis.datasets[0].backgroundColor = ['#6366F1', '#EC4899'];
                rJenis.datasets[0].borderWidth = 0;
                rJenis.datasets[0].hoverOffset = 6;
            }

            chartJenis = new Chart(canvasJenis, {
                type: 'doughnut',
                data: rJenis,
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } },
                    },
                },
            });

            const legend = document.getElementById('jenis-legend');
            if (legend && rJenis.labels) {
                legend.innerHTML = rJenis.labels.map((l, i) => `
                    <span class="jenis-legend-item" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:#475569;">
                        <span class="jenis-legend-dot"
                              style="width:10px;height:10px;border-radius:50%;background:${rJenis.datasets[0].backgroundColor[i]}"></span>
                        ${l}: ${rJenis.datasets[0].data[i]}
                    </span>`
                ).join('');
            }
        } catch (_) {}
    }

    async function loadStatusPendaftar() {
        const { api = {} } = window.PAGE_DATA || {};
        const BASE = api.base || '/admin/api';
        const canvasStatus = document.getElementById('chartStatusPendaftar');
        if (!canvasStatus) return;

        try {
            const rStatus = await fetch(`${BASE}/chart/status-pendaftar`).then(r => r.json());
            if (typeof Chart !== 'undefined') {
                const existing = Chart.getChart(canvasStatus);
                if (existing) existing.destroy();
            }
            if (chartStatusPendaftar) {
                try { chartStatusPendaftar.destroy(); } catch (_) {}
                chartStatusPendaftar = null;
            }

            chartStatusPendaftar = new Chart(canvasStatus, {
                type: 'doughnut',
                data: rStatus,
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } },
                    },
                },
            });

            const legend = document.getElementById('status-pendaftar-legend');
            if (legend && rStatus.labels) {
                const total = rStatus.datasets[0].data.reduce((a, b) => a + b, 0);
                legend.innerHTML = rStatus.labels.map((l, i) => {
                    const count = rStatus.datasets[0].data[i];
                    const pct = total > 0 ? Math.round((count / total) * 100) : 0;
                    return `
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:5px 0;border-bottom:1px dashed #F1F5F9;font-size:12px;">
                            <span style="display:inline-flex;align-items:center;gap:6px;font-weight:600;color:#475569;">
                                <span style="width:8px;height:8px;border-radius:50%;background:${rStatus.datasets[0].backgroundColor[i]}"></span>
                                ${l}
                            </span>
                            <span style="font-weight:800;color:#0F172A;">${count} <span style="font-size:10.5px;color:#94A3B8;font-weight:600;">(${pct}%)</span></span>
                        </div>`;
                }).join('');
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

    async function ensureChartJsLoaded() {
        if (typeof Chart !== 'undefined') return true;
        if (window.ChartJsPromise) return window.ChartJsPromise;

        window.ChartJsPromise = new Promise((resolve) => {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
            script.onload = () => resolve(true);
            script.onerror = () => resolve(false);
            document.head.appendChild(script);
        });

        return window.ChartJsPromise;
    }

    let initTimer;
    async function initDashboard() {
        const canvas = document.getElementById('chartPendapatanPendaftaran') || document.getElementById('chartPendapatan') || document.getElementById('chartPendaftaran');
        if (!canvas) return;

        clearTimeout(initTimer);
        initTimer = setTimeout(async () => {
            await ensureChartJsLoaded();

            await Promise.all([
                loadCharts(),
                loadPie(),
                loadStatusPendaftar(),
                updateStats()
            ]);

            document.getElementById('chart-year')?.removeEventListener('change', loadCharts);
            document.getElementById('chart-year')?.addEventListener('change', loadCharts);
            document.getElementById('chart-metric')?.removeEventListener('change', loadCharts);
            document.getElementById('chart-metric')?.addEventListener('change', loadCharts);

            // Resize trigger after skeleton overlay fades out
            setTimeout(() => {
                if (chartCombo) try { chartCombo.resize(); } catch(_) {}
                if (chartStatusPendaftar) try { chartStatusPendaftar.resize(); } catch(_) {}
                if (chartJenis) try { chartJenis.resize(); } catch(_) {}
            }, 480);
        }, 50);
    }

    window.loadCharts = loadCharts;
    window.initDashboard = initDashboard;

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        initDashboard();
    } else {
        document.addEventListener('DOMContentLoaded', initDashboard);
    }
    window.addEventListener('load', initDashboard);
    document.addEventListener('livewire:navigated', initDashboard);
    document.addEventListener('livewire:load', initDashboard);
    window.addEventListener('popstate', initDashboard);
})();

window.loadCalendarMonth = function (targetMonth) {
    const container = document.getElementById('mini-calendar-widget');
    if (!container) return;

    const { api = {} } = window.PAGE_DATA || {};
    const url = api.calendar || '/admin/api/calendar';

    container.style.opacity = '0.5';

    fetch(`${url}?month=${targetMonth}`)
        .then(res => res.json())
        .then(data => {
            container.style.opacity = '1';

            const labelEl = document.getElementById('cal-month-label');
            if (labelEl) labelEl.textContent = data.month_label;

            const resetBtn = document.getElementById('cal-reset-btn');
            if (resetBtn) {
                resetBtn.style.display = data.is_current_real_month ? 'none' : 'inline-block';
            }

            const prevBtn = document.getElementById('cal-prev-btn');
            if (prevBtn) prevBtn.setAttribute('onclick', `loadCalendarMonth('${data.prev_month}')`);

            const nextBtn = document.getElementById('cal-next-btn');
            if (nextBtn) nextBtn.setAttribute('onclick', `loadCalendarMonth('${data.next_month}')`);

            const daysGrid = document.getElementById('cal-days-grid');
            if (!daysGrid) return;

            let html = '';

            // Empty leading cells
            for (let i = 0; i < data.start_day_of_week; i++) {
                html += `<div style="padding:6px;font-size:12px;color:#CBD5E1;"></div>`;
            }

            // Days
            for (let day = 1; day <= data.days_in_month; day++) {
                const isToday = data.is_current_real_month && (day === data.today_day);
                const activities = data.kegiatan_map[day] || [];
                const hasActivity = activities.length > 0;
                const activityTitles = activities.join(', ');

                const tooltipAttr = hasActivity ? `data-tooltip="${activityTitles.replace(/"/g, '&quot;')}"` : '';
                const titleAttr = hasActivity ? activityTitles : (isToday ? 'Hari ini' : '');

                let dotsHtml = '';
                if (hasActivity) {
                    const dotsCount = Math.min(3, activities.length);
                    let dotsSpans = '';
                    for (let d = 0; d < dotsCount; d++) {
                        dotsSpans += `<span style="width:4px;height:4px;border-radius:50%;background:${isToday ? '#131218' : '#FFC81A'};border:${isToday ? 'none' : '1px solid #131218'};"></span>`;
                    }
                    dotsHtml = `<div style="position:absolute;bottom:2px;left:50%;transform:translateX(-50%);display:flex;gap:2.5px;align-items:center;">${dotsSpans}</div>`;
                }

                const bg = isToday ? '#FFC81A' : 'transparent';
                const color = isToday ? '#131218' : '#334155';
                const border = isToday ? '1.5px solid #131218' : 'none';
                const shadow = isToday ? '0 4px 12px rgba(255, 200, 26, 0.35)' : 'none';

                html += `
                    <div class="calendar-day-cell" title="${titleAttr}" ${tooltipAttr}
                         style="position:relative;padding:7px 0;font-size:12px;font-weight:${isToday || hasActivity ? '900' : '600'};border-radius:10px;cursor:${hasActivity ? 'pointer' : 'default'};
                                background:${bg};color:${color};border:${border};box-shadow:${shadow};">
                        ${day}
                        ${dotsHtml}
                    </div>
                `;
            }

            daysGrid.innerHTML = html;
        })
        .catch(err => {
            container.style.opacity = '1';
            console.error('Calendar AJAX error:', err);
        });
};
