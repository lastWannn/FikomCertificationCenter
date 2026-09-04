<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class AsyncMail
{
    /**
     * Dispatch pengiriman email ke background process OS (atau fallback sync jika exec diblokir hosting)
     */
    public static function dispatch(string $type, string|int $id, ?string $extra = null): void
    {
        try {
            $disabledFunctions = explode(',', ini_get('disable_functions') ?: '');
            $disabledFunctions = array_map('trim', $disabledFunctions);
            $canExec = function_exists('exec') && !in_array('exec', $disabledFunctions);

            if ($canExec) {
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
            } else {
                // Fallback jika exec() diblokir oleh shared hosting / cPanel
                Artisan::call('email:send', [
                    'type'  => $type,
                    'id'    => (string) $id,
                    'extra' => $extra,
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning("AsyncMail dispatch error [{$type}]: " . $e->getMessage());
        }
    }
}
