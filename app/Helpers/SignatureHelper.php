<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class SignatureHelper
{
    /**
     * Hapus background putih/terang dari gambar TTD secara otomatis dan simpan sebagai PNG transparan
     */
    public static function processTransparent(UploadedFile $file, string $destinationPath): string
    {
        $raw = file_get_contents($file->getRealPath());
        $img = @imagecreatefromstring($raw);

        if (!$img) {
            // Fallback jika GD gagal parse: simpan file biasa
            return $file->store($destinationPath, 'public');
        }

        $width  = imagesx($img);
        $height = imagesy($img);

        // Buat canvas gambar baru dengan alpha channel
        $transparentImg = imagecreatetruecolor($width, $height);
        imagealphablending($transparentImg, false);
        imagesavealpha($transparentImg, true);

        $transparentColor = imagecolorallocatealpha($transparentImg, 0, 0, 0, 127);
        imagefill($transparentImg, 0, 0, $transparentColor);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // Hitung kecerahan (luminance) piksel (0 - 255)
                $luminance = ($r * 0.299 + $g * 0.587 + $b * 0.114);

                if ($luminance >= 210) {
                    // Piksel latar belakang putih/terang -> buat transparan penuh (alpha 127)
                    $color = imagecolorallocatealpha($transparentImg, 255, 255, 255, 127);
                } elseif ($luminance >= 150) {
                    // Soft edge anti-aliasing untuk pinggiran tinta tanda tangan
                    $alpha = (int) (($luminance - 150) / (210 - 150) * 127);
                    $color = imagecolorallocatealpha($transparentImg, $r, $g, $b, min(127, max(0, $alpha)));
                } else {
                    // Piksel tinta tanda tangan (gelap) -> tetap pekat transparan 0
                    $color = imagecolorallocatealpha($transparentImg, $r, $g, $b, 0);
                }

                imagesetpixel($transparentImg, $x, $y, $color);
            }
        }

        imagedestroy($img);

        // Generate filename unik .png
        $filename = md5(uniqid(microtime(), true)) . '.png';
        $fullRelPath = trim($destinationPath, '/') . '/' . $filename;
        $fullAbsPath = storage_path('app/public/' . $fullRelPath);

        $dir = dirname($fullAbsPath);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        imagepng($transparentImg, $fullAbsPath, 9);
        imagedestroy($transparentImg);

        return $fullRelPath;
    }
}
