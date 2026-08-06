<?php

use App\Helpers\ImageHelper;
use Illuminate\Http\UploadedFile;

if (!function_exists('compress_to_webp')) {
    /**
     * Compress & convert uploaded image file to WebP format automatically.
     *
     * @param  UploadedFile|null $file
     * @param  string $folder
     * @param  int $quality
     * @param  int|null $maxWidth
     * @return string|null
     */
    function compress_to_webp(?UploadedFile $file, string $folder = 'uploads', int $quality = 80, ?int $maxWidth = 1600): ?string
    {
        return ImageHelper::compressToWebp($file, $folder, $quality, $maxWidth);
    }
}
