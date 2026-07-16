/**
 * FCC Admin Sidebar
 * - Collapse/expand sidebar
 * - Close notification dropdown on outside click
 */
(function () {
    'use strict';

    let collapsed = false;

    window.toggleSidebar = function () {
        collapsed = !collapsed;
        const sb   = document.getElementById('sidebar');
        const logo = document.getElementById('sb-brand');
        if (!sb) return;

        sb.style.width    = collapsed ? '64px' : '256px';
        sb.style.minWidth = collapsed ? '64px' : '256px';

        document.querySelectorAll('.sb-lbl, .sb-section-label').forEach(el => {
            el.style.display = collapsed ? 'none' : 'block';
        });
        if (logo) logo.style.display = collapsed ? 'none' : 'block';
    };

    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('click', e => {
            const drop = document.getElementById('notif-drop');
            if (drop && !e.target.closest('#notif-drop') && !e.target.closest('[data-notif-toggle]')) {
                drop.classList.add('hidden');
            }
        });
    });
})();
