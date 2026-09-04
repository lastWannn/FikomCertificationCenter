<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class AsyncMail
{
    /**
     * Dispatch pengiriman email sistem secara terjamin di web server
     */
    public static function dispatch(string $type, string|int $id, ?string $extra = null): void
    {
        try {
            Artisan::call('email:send', [
                'type'  => $type,
                'id'    => (string) $id,
                'extra' => $extra,
            ]);
        } catch (\Throwable $e) {
            Log::warning("AsyncMail dispatch error [{$type}]: " . $e->getMessage());
        }
    }
}
