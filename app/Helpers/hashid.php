<?php

use App\Services\HashidService;

if (!function_exists('hashid')) {
    /**
     * Encode ID numerik menjadi hashid.
     *
     * @param  int    $id    ID asli
     * @param  string $model Nama atau class Model (untuk salt berbeda)
     *
     * @example hashid(42, 'Kegiatan')  → "xk3m7qn2"
     * @example hashid($pembayaran->id, Pembayaran::class)
     */
    function hashid(int $id, string $model = 'default'): string
    {
        return app(HashidService::class)->encode($id, $model);
    }
}

if (!function_exists('unhashid')) {
    /**
     * Decode hashid kembali ke ID numerik.
     * Kembalikan null jika hash tidak valid.
     *
     * @param  string $hash
     * @param  string $model
     */
    function unhashid(string $hash, string $model = 'default'): ?int
    {
        return app(HashidService::class)->decode($hash, $model);
    }
}


if (!function_exists('route_exists')) {
    /**
     * Cek apakah route dengan nama tertentu ada.
     * Berguna untuk fitur opsional (mis. instruktur dashboard).
     */
    function route_exists(string $name): bool
    {
        return \Illuminate\Support\Facades\Route::has($name);
    }
}
