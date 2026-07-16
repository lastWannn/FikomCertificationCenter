<?php

namespace App\Services;

use Hashids\Hashids;

/**
 * HashidService
 *
 * Mengelola encoding/decoding ID numerik menjadi hash alfanumerik
 * yang aman untuk digunakan di URL publik.
 *
 * Setiap model mendapatkan instance Hashids dengan salt berbeda,
 * mencegah korelasi ID antar resource.
 */
class HashidService
{
    /** @var Hashids[] Cache instance per model */
    private array $instances = [];

    /**
     * Encode ID numerik → hash string.
     *
     * @param  int    $id     ID asli (primary key)
     * @param  string $model  class basename atau class penuh Model
     */
    public function encode(int $id, string $model = 'default'): string
    {
        return $this->instance($model)->encode($id);
    }

    /**
     * Decode hash string → ID numerik (null jika tidak valid).
     *
     * @param  string $hash
     * @param  string $model
     */
    public function decode(string $hash, string $model = 'default'): ?int
    {
        $result = $this->instance($model)->decode($hash);
        return !empty($result) ? (int) $result[0] : null;
    }

    /**
     * Dapatkan/buat instance Hashids untuk model tertentu.
     */
    private function instance(string $model): Hashids
    {
        $basename = class_basename($model);

        if (!isset($this->instances[$basename])) {
            $baseSalt  = config('hashids.salt');
            $suffix    = config('hashids.suffixes.' . $basename, $basename);
            $salt      = $baseSalt . ':' . $suffix;

            $this->instances[$basename] = new Hashids(
                $salt,
                config('hashids.min_length', 8),
                config('hashids.alphabet')
            );
        }

        return $this->instances[$basename];
    }
}
