<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class AsyncMail
{
    /**
     * Dispatch pengiriman email ke background process OS (0 ms delay untuk web request)
     */
    public static function dispatch(string $type, string|int $id, ?string $extra = null): void
    {
        try {
            $artisan    = base_path('artisan');
            $typeArg    = escapeshellarg($type);
            $idArg      = escapeshellarg((string) $id);
            $extraArg   = $extra !== null ? ' ' . escapeshellarg($extra) : '';

            $cmd = "php \"{$artisan}\" email:send {$typeArg} {$idArg}{$extraArg}";

            if (str_starts_with(strtoupper(PHP_OS), 'WIN')) {
                pclose(popen("start /B {$cmd}", "r"));
            } else {
                exec("{$cmd} > /dev/null 2>&1 &");
            }
        } catch (\Throwable $e) {
            Log::warning("AsyncMail dispatch error [{$type}]: " . $e->getMessage());
        }
    }
}
