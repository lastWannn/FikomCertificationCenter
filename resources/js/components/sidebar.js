/**
 * FCC Admin Sidebar
 * - Collapse/expand sidebar
 * - Mobile drawer support
 * - Close notification dropdown on outside click
 */
(function () {
    'use strict';

    function isMobile() {
        return window.innerWidth < 1024;
    }

    let isToggling = false;
    window.toggleSidebar = function () {
        if (isToggling) return;
        isToggling = true;
        setTimeout(function() { isToggling = false; }, 300);

        if (typeof window.toggleAdminSidebar === 'function') {
            window.toggleAdminSidebar();
            return;
        }

        const sb = document.getElementById('sidebar');
        const bd = document.getElementById('sidebar-backdrop');
        if (!sb) return;

        if (isMobile()) {
            const isOpen = sb.classList.contains('mobile-open');
            if (isOpen) {
                sb.classList.remove('mobile-open');
                if (bd) bd.classList.remove('mobile-open');
            } else {
                sb.classList.add('mobile-open');
                if (bd) bd.classList.add('mobile-open');
            }
        } else {
            sb.classList.toggle('collapsed');
            sb.style.width = '';
            sb.style.minWidth = '';
        }
    };

    window.closeSidebarMobile = function () {
        if (typeof window.closeAdminSidebarDrawer === 'function') {
            window.closeAdminSidebarDrawer();
            return;
        }
        const sb = document.getElementById('sidebar');
        const bd = document.getElementById('sidebar-backdrop');
        if (sb) sb.classList.remove('mobile-open');
        if (bd) bd.classList.remove('mobile-open');
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

