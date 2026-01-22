<?php

namespace App\Observers;

use App\Models\Offer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfferObserver
{
    /**
     * Handle the Offer "saving" event.
     */
    public function saving(Offer $offer)
    {
        $this->processImage($offer, 'image_path');
    }

    /**
     * Handle the Offer "deleted" event.
     */
    public function deleted(Offer $offer)
    {
        if (!empty($offer->image_path)) {
            Storage::disk('public')->delete($offer->image_path);
        }
    }

    /**
     * Processes the image upload, conversion, and cleanup.
     */
    private function processImage(Offer $offer, string $imageField)
    {
        $originalValue = $offer->getOriginal($imageField);
        $currentValue = $offer->{$imageField};

        if ($offer->isDirty($imageField) && is_string($currentValue) && Str::contains($currentValue, 'temp-uploads')) {
            $tempPath = $currentValue;

            if (!Storage::disk('public')->exists($tempPath)) {
                $offer->{$imageField} = $originalValue;
                return;
            }

            $baseName = Str::slug($offer->title);
            $randomSuffix = Str::lower(Str::random(4));
            $newFileName = "{$baseName}-{$randomSuffix}.webp";

            $finalDirectory = 'offers';
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

                $offer->{$imageField} = $finalPath;

                if ($originalValue) {
                    Storage::disk('public')->delete($originalValue);
                }

            } catch (\Exception $e) {
                logger()->error("Image conversion failed for offer {$offer->id}: " . $e->getMessage());
                $offer->{$imageField} = $originalValue;
            } finally {
                Storage::disk('public')->delete($tempPath);
            }
        }
        else if ($offer->isDirty($imageField) && empty($currentValue) && !empty($originalValue)) {
            Storage::disk('public')->delete($originalValue);
        }
    }
}
