<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Compress & convert uploaded image file to WebP format automatically.
     *
     * @param UploadedFile|null $file Uploaded file object
     * @param string $folder Target storage folder (e.g. 'foto-peserta', 'bukti-bayar')
     * @param int $quality Compression quality (1-100, default 80)
     * @param int|null $maxWidth Maximum width to resize if larger (default 1600px)
     * @return string|null Relative stored path (e.g. 'foto-peserta/random.webp')
     */
    public static function compressToWebp(?UploadedFile $file, string $folder = 'uploads', int $quality = 80, ?int $maxWidth = 1400): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        try {
            $realPath = $file->getRealPath();
            if (!$realPath || !file_exists($realPath)) {
                return $file->store($folder, 'public');
            }

            $mime = strtolower($file->getMimeType() ?: '');

            // Load image resource via GD extension if available
            $image = null;
            if (extension_loaded('gd') && function_exists('imagewebp')) {
                $image = match ($mime) {
                    'image/jpeg', 'image/jpg' => function_exists('imagecreatefromjpeg') ? @imagecreatefromjpeg($realPath) : null,
                    'image/png'  => function_exists('imagecreatefrompng') ? @imagecreatefrompng($realPath) : null,
                    'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($realPath) : null,
                    'image/gif'  => function_exists('imagecreatefromgif') ? @imagecreatefromgif($realPath) : null,
                    'image/bmp'  => function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($realPath) : null,
                    default      => null,
                };
            }

            // Fallback: If non-image, GD error, or false return, store as original file
            if (!$image || $image === false) {
                return $file->store($folder, 'public');
            }

            $origW = imagesx($image);
            $origH = imagesy($image);

            if ($origW <= 0 || $origH <= 0) {
                imagedestroy($image);
                return $file->store($folder, 'public');
            }

            // Direct Resize if width exceeds $maxWidth (preserving native orientation as uploaded)
            if ($maxWidth && $origW > $maxWidth) {
                $newW = $maxWidth;
                $newH = (int) round(($origH / $origW) * $newW);

                $resized = imagecreatetruecolor($newW, $newH);

                if (in_array($mime, ['image/png', 'image/webp', 'image/gif'])) {
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                }

                imagecopyresampled($resized, $image, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                imagedestroy($image);
                $image = $resized;
            } elseif (in_array($mime, ['image/png', 'image/webp', 'image/gif'])) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }

            // Target path & WebP Save
            $filename = Str::random(40) . '.webp';
            $relativeFolder = trim($folder, '/');
            $targetDir = storage_path("app/public/{$relativeFolder}");

            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }

            $fullPath = "{$targetDir}/{$filename}";

            // Save compressed WebP directly
            $saved = @imagewebp($image, $fullPath, $quality);
            imagedestroy($image);

            if ($saved && file_exists($fullPath)) {
                return "{$relativeFolder}/{$filename}";
            }

            return $file->store($folder, 'public');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("ImageHelper::compressToWebp error: " . $e->getMessage());
            try {
                return $file->store($folder, 'public');
            } catch (\Throwable $ex) {
                \Illuminate\Support\Facades\Log::error("ImageHelper fallback store error: " . $ex->getMessage());
                return null;
            }
        }
    }
}
