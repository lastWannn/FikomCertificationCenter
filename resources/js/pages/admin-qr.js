/**
 * FCC Admin QR Code Display
 * Data dari window.PAGE_DATA.qrList (array of {id, url})
 * Membutuhkan qrcode.js via CDN
 */
(function () {
    'use strict';

    const { qrList = [], qrSize = 120 } = window.PAGE_DATA || {};

    function renderQrCodes() {
        if (!window.QRCode) {
            console.warn('QRCode library not loaded.');
            return;
        }
        qrList.forEach(item => {
            const el = document.getElementById(`qr-${item.id}`);
            if (!el || el.dataset.rendered) return;
            new QRCode(el, {
                text:         item.url,
                width:        qrSize,
                height:       qrSize,
                colorDark:    '#131218',
                colorLight:   '#FFFFFF',
                correctLevel: QRCode.CorrectLevel.H,
            });
            el.dataset.rendered = '1';
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Tunggu sampai QRCode CDN ter-load
        if (window.QRCode) {
            renderQrCodes();
        } else {
            const script = document.querySelector('script[src*="qrcode"]');
            if (script) script.addEventListener('load', renderQrCodes);
            else setTimeout(renderQrCodes, 800);
        }
    });
})();
