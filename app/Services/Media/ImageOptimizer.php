<?php

namespace App\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Tiny GD-based image optimizer. No external deps required (GD ships with
 * most PHP builds). Resizes to fit within $maxWidth x $maxHeight while
 * preserving aspect ratio, then re-encodes as JPEG/PNG/WebP at the chosen
 * quality. Strips EXIF metadata as a side effect.
 *
 * For more advanced needs (cropping, filters, format negotiation),
 * swap in `intervention/image`.
 */
class ImageOptimizer
{
    public function __construct(
        public readonly int $maxWidth = 1600,
        public readonly int $maxHeight = 1600,
        public readonly int $quality = 82,
    ) {
    }

    /**
     * Store an uploaded image, resized + recompressed, on the given disk.
     * Returns the relative path (suitable for asset('storage/' . $path)).
     */
    public function storeAs(
        UploadedFile $file,
        string $directory,
        ?string $filename = null,
        string $disk = 'public',
    ): string {
        if (! function_exists('imagecreatefromstring')) {
            // GD missing — fall back to raw store
            return $file->store($directory, $disk);
        }

        $raw = file_get_contents($file->getRealPath());
        if ($raw === false) {
            throw new RuntimeException('Could not read upload.');
        }

        $src = @imagecreatefromstring($raw);
        if (! $src) {
            // Not a real image — let the caller deal with it via raw store.
            return $file->store($directory, $disk);
        }

        $w = imagesx($src);
        $h = imagesy($src);
        [$nw, $nh] = $this->fitDimensions($w, $h);

        if ($nw === $w && $nh === $h) {
            $resized = $src;
        } else {
            $resized = imagecreatetruecolor($nw, $nh);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
            imagedestroy($src);
        }

        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $ext = in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true) ? $ext : 'jpg';

        $name = $filename ?: now()->format('YmdHis') . '_' . Str::random(6) . '.' . $ext;
        $relativePath = trim($directory, '/') . '/' . $name;
        $absolute = Storage::disk($disk)->path($relativePath);

        if (! is_dir(dirname($absolute))) {
            @mkdir(dirname($absolute), 0775, true);
        }

        $ok = match ($ext) {
            'png' => imagepng($resized, $absolute, 6),
            'webp' => imagewebp($resized, $absolute, $this->quality),
            default => imagejpeg($resized, $absolute, $this->quality),
        };

        imagedestroy($resized);

        if (! $ok) {
            throw new RuntimeException('Failed to encode optimized image.');
        }

        return $relativePath;
    }

    /**
     * @return array{0: int, 1: int}
     */
    private function fitDimensions(int $w, int $h): array
    {
        $ratio = min($this->maxWidth / $w, $this->maxHeight / $h, 1);
        return [(int) round($w * $ratio), (int) round($h * $ratio)];
    }
}
