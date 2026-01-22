<?php

namespace App\Observers;

use App\Models\Banner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerObserver
{
    /**
     * Handle the Banner "saving" event.
     */
    public function saving(Banner $banner)
    {
        $this->processImage($banner, 'image_path');
    }

    /**
     * Handle the Banner "deleted" event.
     */
    public function deleted(Banner $banner)
    {
        if (!empty($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }
    }

    /**
     * Processes the image upload, conversion, and cleanup.
     */
    private function processImage(Banner $banner, string $imageField)
    {
        $originalValue = $banner->getOriginal($imageField);
        $currentValue = $banner->{$imageField};

        if ($banner->isDirty($imageField) && is_string($currentValue) && Str::contains($currentValue, 'temp-uploads')) {
            $tempPath = $currentValue;

            if (!Storage::disk('public')->exists($tempPath)) {
                $banner->{$imageField} = $originalValue;
                return;
            }

            $baseName = Str::slug($banner->name);
            $randomSuffix = Str::lower(Str::random(4));
            $newFileName = "{$baseName}-{$randomSuffix}.webp";

            $finalDirectory = 'banners';
            $finalPath = $finalDirectory . '/' . $newFileName;

            try {
                $sourcePath = Storage::disk('public')->path($tempPath);
                $destinationPath = Storage::disk('public')->path($finalPath);

                if (!File::isDirectory(dirname($destinationPath))) {
                    File::makeDirectory(dirname($destinationPath), 0755, true, true);
                }

                $image = imagecreatefromstring(File::get($sourcePath));
                if ($image === false) throw new \Exception('Failed to create image from file.');

                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                imagewebp($image, $destinationPath, 80);
                imagedestroy($image);

                $banner->{$imageField} = $finalPath;

                if ($originalValue) {
                    Storage::disk('public')->delete($originalValue);
                }

            } catch (\Exception $e) {
                logger()->error("Image conversion failed for banner {$banner->id}: " . $e->getMessage());
                $banner->{$imageField} = $originalValue;
            } finally {
                Storage::disk('public')->delete($tempPath);
            }
        }
        else if ($banner->isDirty($imageField) && empty($currentValue) && !empty($originalValue)) {
            Storage::disk('public')->delete($originalValue);
        }
    }
}
