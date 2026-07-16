/**
 * FCC Auth Login — Toggle password visibility
 */
(function () {
    'use strict';

    const ICON_SHOW = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    const ICON_HIDE = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';

    window.togglePw = function () {
        const field  = document.getElementById('pw-inp');
        const svg    = document.getElementById('eye-svg');
        if (!field) return;

        const isHidden = field.type === 'password';
        field.type     = isHidden ? 'text'     : 'password';
        if (svg) svg.innerHTML = isHidden ? ICON_HIDE : ICON_SHOW;
    };
})();
