import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // ── Core
                'resources/css/app.css',
                'resources/js/app.js',

                // ── Page-specific JS (dimuat per halaman via @vite di Blade)
                'resources/js/pages/landing-index.js',
                'resources/js/pages/landing-search.js',
                'resources/js/pages/landing-jelajahi.js',
                'resources/js/pages/admin-dashboard.js',
                'resources/js/pages/admin-qr.js',
                'resources/js/pages/admin-pengguna.js',
                'resources/js/pages/auth-login.js',
                'resources/js/pages/peserta-pembayaran.js',
                'resources/js/pages/landing-pendaftaran.js',
                'resources/js/pages/admin-kategori.js',
                'resources/js/pages/admin-pelatihan-form.js',
            ],
            refresh: [
                'resources/views/**',
                'resources/css/**',
                'resources/js/**',
            ],
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: { host: 'localhost' },
    },
});
