<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandObserver
{
    /**
     * Handle the Brand "saving" event.
     */
    public function saving(Brand $brand)
    {
        $this->processImage($brand, 'logo_path');
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand)
    {
        if (!empty($brand->logo_path)) {
            Storage::disk('public')->delete($brand->logo_path);
        }
    }

    /**
     * Processes the image upload, conversion, and cleanup for the logo.
     */
    private function processImage(Brand $brand, string $imageField)
    {
        $originalValue = $brand->getOriginal($imageField);
        $currentValue = $brand->{$imageField};

        if ($brand->isDirty($imageField) && is_string($currentValue) && Str::contains($currentValue, 'temp-uploads')) {
            $tempPath = $currentValue;

            if (!Storage::disk('public')->exists($tempPath)) {
                $brand->{$imageField} = $originalValue;
                return;
            }

            $baseName = Str::slug($brand->name);
            $randomSuffix = Str::lower(Str::random(4));
            $newFileName = "{$baseName}-logo-{$randomSuffix}.webp";

            $finalDirectory = 'brands';
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

                $brand->{$imageField} = $finalPath;

                if ($originalValue) {
                    Storage::disk('public')->delete($originalValue);
                }

            } catch (\Exception $e) {
                logger()->error("Image conversion failed for brand {$brand->id}: " . $e->getMessage());
                $brand->{$imageField} = $originalValue;
            } finally {
                Storage::disk('public')->delete($tempPath);
            }
        }
        else if ($brand->isDirty($imageField) && empty($currentValue) && !empty($originalValue)) {
            Storage::disk('public')->delete($originalValue);
        }
    }
}
