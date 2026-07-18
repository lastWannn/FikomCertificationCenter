/**
 * FCC Bootstrap JS
 *
 * FIX: Baris `require('axios').default` sebelumnya ada di sini namun
 * menyebabkan ReferenceError karena:
 *   1. Vite menggunakan ES Modules (ESM) — `require()` tidak tersedia
 *   2. Package `axios` tidak terinstall di project ini
 *
 * FCC menggunakan native `fetch` API untuk semua request AJAX
 * (navbar search autocomplete, chart data, dll.) sehingga axios tidak diperlukan.
 *
 * Jika suatu saat axios dibutuhkan:
 *   1. npm install axios
 *   2. import axios from 'axios';
 *   3. axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
 */
