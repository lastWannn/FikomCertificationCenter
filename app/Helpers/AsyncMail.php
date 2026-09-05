<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class AsyncMail
{
    /**
     * Dispatch pengiriman email sistem ke background process OS (0 ms delay untuk web request),
     * dengan fallback synchronous jika fungsi exec/popen dinonaktifkan di server.
     */
    public static function dispatch(string $type, string|int $id, ?string $extra = null): void
    {
        try {
            $disabledFunctions = explode(',', (string) ini_get('disable_functions'));
            $disabledFunctions = array_map('trim', $disabledFunctions);

            $isWindows = str_starts_with(strtoupper(PHP_OS), 'WIN');
            $canPopen  = function_exists('popen') && !in_array('popen', $disabledFunctions, true);
            $canExec   = function_exists('exec') && !in_array('exec', $disabledFunctions, true);

            // Deteksi path binary PHP yang valid (PHP_BINARY lebih akurat daripada sekadar string 'php' pada cPanel/Linux)
            $phpBinary = defined('PHP_BINARY') && PHP_BINARY && @is_executable(PHP_BINARY)
                ? PHP_BINARY
                : 'php';

            $artisan  = base_path('artisan');
            $typeArg  = escapeshellarg($type);
            $idArg    = escapeshellarg((string) $id);
            // Sanitasi extra arg agar tidak mengandung karakter pipe yang dapat memecah shell command
            $sanitizedExtra = $extra !== null ? str_replace('|', ':', $extra) : null;
            $extraArg = $sanitizedExtra !== null ? ' ' . escapeshellarg($sanitizedExtra) : '';

            $ranAsync = false;

            if ($isWindows && $canPopen) {
                // Di Windows gunakan start /B dengan binary php
                $cmd = "start /B php \"{$artisan}\" email:send {$typeArg} {$idArg}{$extraArg}";
                $handle = @popen($cmd, 'r');
                if ($handle !== false) {
                    pclose($handle);
                    $ranAsync = true;
                }
            } elseif (!$isWindows && $canExec) {
                // Di Linux/cPanel gunakan PHP_BINARY path lengkap ke background
                $cmd = escapeshellarg($phpBinary) . " \"{$artisan}\" email:send {$typeArg} {$idArg}{$extraArg} > /dev/null 2>&1 &";
                @exec($cmd);
                $ranAsync = true;
            }

            // Fallback synchronous jika background process gagal atau fungsi exec/popen dinonaktifkan di server
            if (!$ranAsync) {
                Artisan::call('email:send', [
                    'type'  => $type,
                    'id'    => (string) $id,
                    'extra' => $sanitizedExtra ?? $extra,
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning("AsyncMail dispatch error [{$type}]: " . $e->getMessage());
        }
    }
}
