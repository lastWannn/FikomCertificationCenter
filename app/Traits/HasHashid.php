<?php

namespace App\Traits;

use App\Services\HashidService;
use Illuminate\Database\Eloquent\Model;

/**
 * HasHashid Trait
 *
 * Ditambahkan ke Eloquent Model untuk:
 *  1. Menyediakan accessor `$model->hashid`
 *  2. Mengoverride Route Model Binding agar URL menggunakan hashid
 *     bukan ID numerik asli
 *  3. Menyediakan `findByHashid()` untuk query manual
 *
 * ─── CARA PAKAI ──────────────────────────────────────────────────
 *
 * Di Model:
 *   use App\Traits\HasHashid;
 *   class Kegiatan extends Model {
 *       use HasHashid;
 *   }
 *
 * Di view (URL generation):
 *   route('admin.kegiatan.show', $kegiatan)          // ✓ otomatis pakai hashid
 *   route('admin.kegiatan.show', $kegiatan->hashid)  // ✓ eksplisit
 *
 * Di controller (sudah di-resolve otomatis via route model binding):
 *   public function show(Kegiatan $kegiatan) { ... } // ✓ $kegiatan sudah resolved
 *
 * Helper function:
 *   hashid($model->id, Kegiatan::class)              // encode
 *   unhashid('xk3m7qn2', Kegiatan::class)            // decode → int|null
 * ─────────────────────────────────────────────────────────────────
 */
trait HasHashid
{
    /* ── ACCESSOR ─────────────────────────────────────────────── */

    /**
     * Hashid dari ID model ini.
     * Accessor: $model->hashid
     */
    public function getHashidAttribute(): string
    {
        return $this->encodeHashid($this->getKey());
    }

    /**
     * Encode integer ID menjadi hashid untuk model ini.
     */
    public function encodeHashid(int $id): string
    {
        return app(HashidService::class)->encode($id, static::class);
    }

    /**
     * Decode hashid string menjadi integer ID asli.
     * Jika sudah berupa ID numerik, kembalikan integer ID secara langsung.
     */
    public static function decodeHashid(mixed $hashid): ?int
    {
        if (is_numeric($hashid)) {
            return (int) $hashid;
        }
        if (empty($hashid)) {
            return null;
        }
        return app(HashidService::class)->decode((string) $hashid, static::class);
    }

    /* ── QUERY ────────────────────────────────────────────────── */

    /**
     * Temukan model berdasarkan hashid.
     * Kembalikan null jika hash tidak valid atau model tidak ditemukan.
     */
    public static function findByHashid(string $hashid): ?static
    {
        $id = app(HashidService::class)->decode($hashid, static::class);
        return $id !== null ? static::find($id) : null;
    }

    /**
     * Temukan model berdasarkan hashid atau throw 404.
     */
    public static function findByHashidOrFail(string $hashid): static
    {
        $model = static::findByHashid($hashid);
        if (!$model) abort(404);
        return $model;
    }

    /* ── ROUTE MODEL BINDING ─────────────────────────────────── */

    /**
     * Nama key yang digunakan di URL (bukan nama kolom DB).
     * Laravel akan panggil getRouteKey() saat generate URL.
     */
    public function getRouteKeyName(): string
    {
        return 'hashid';
    }

    /**
     * Nilai yang muncul di URL saat generate route.
     * Contoh: route('admin.kegiatan.show', $kegiatan) → /admin/kegiatan/xk3m7qn2
     */
    public function getRouteKey(): mixed
    {
        return $this->hashid;
    }

    /**
     * Resolve route model binding: decode hashid → cari model by ID.
     * Dipanggil Laravel saat request masuk ke controller.
     */
    public function resolveRouteBinding($value, $field = null): ?static
    {
        $id = app(HashidService::class)->decode((string) $value, static::class);

        // Fallback: Jika $value berupa ID numerik asli (bukan hashid), coba cari langsung
        if ($id === null && is_numeric($value)) {
            $id = (int) $value;
        }

        if ($id === null) {
            return null;
        }

        return static::where($this->getKeyName(), $id)->first();
    }

    /**
     * Resolve untuk child route binding (nested resource).
     */
    public function resolveChildRouteBinding($childType, $value, $field): ?Model
    {
        $childClass = 'App\\Models\\' . ucfirst($childType);
        $id = app(HashidService::class)->decode((string) $value, $childClass);

        if ($id === null && is_numeric($value)) {
            $id = (int) $value;
        }

        return $id
            ? $this->{$childType}()->where($this->getKeyName(), $id)->first()
            : null;
    }
}
