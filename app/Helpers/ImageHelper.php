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
    public static function compressToWebp(?UploadedFile $file, string $folder = 'uploads', int $quality = 80, ?int $maxWidth = 1600): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        $mime = $file->getMimeType();
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

        // Preserve alpha transparency for PNG / WebP / GIF
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        // Auto resize if width exceeds $maxWidth
        $origWidth = imagesx($image);
        $origHeight = imagesy($image);

        if ($maxWidth && $origWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(($origHeight / $origWidth) * $newWidth);
            $resized = imagecreatetruecolor($newWidth, $newHeight);

            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
            imagedestroy($image);
            $image = $resized;
        }

        // Target path: storage/app/public/{folder}
        $filename = Str::random(40) . '.webp';
        $relativeFolder = trim($folder, '/');
        $targetDir = storage_path("app/public/{$relativeFolder}");

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fullPath = "{$targetDir}/{$filename}";

        // Convert & compress to WebP
        imagewebp($image, $fullPath, $quality);
        imagedestroy($image);

        return "{$relativeFolder}/{$filename}";
    }
}
