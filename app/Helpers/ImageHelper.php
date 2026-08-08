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

        $mime = strtolower($file->getMimeType());
        $realPath = $file->getRealPath();

        // Load image resource via GD extension if available
        $image = null;
        if (extension_loaded('gd')) {
            $image = match ($mime) {
                'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($realPath),
                'image/png'  => @imagecreatefrompng($realPath),
                'image/webp' => @imagecreatefromwebp($realPath),
                'image/gif'  => @imagecreatefromgif($realPath),
                'image/bmp'  => @imagecreatefrombmp($realPath),
                default      => null,
            };
        }

        // Fallback: If non-image or GD error, store as original file
        if (!$image) {
            return $file->store($folder, 'public');
        }

        $origW = imagesx($image);
        $origH = imagesy($image);

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
            mkdir($targetDir, 0755, true);
        }

        $fullPath = "{$targetDir}/{$filename}";

        // Save compressed WebP directly
        imagewebp($image, $fullPath, $quality);
        imagedestroy($image);

        return "{$relativeFolder}/{$filename}";
    }
}
