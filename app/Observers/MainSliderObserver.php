<?php

namespace App\Observers;

use App\Models\MainSlider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MainSliderObserver
{
    /**
     * Handle the MainSlider "saving" event.
     */
    public function saving(MainSlider $slider)
    {
        $imageFields = ['image_path', 'image_path_mobile'];

        foreach ($imageFields as $field) {
            $this->processImage($slider, $field);
        }
    }

    /**
     * Handle the MainSlider "deleted" event.
     */
    public function deleted(MainSlider $slider)
    {
        if (!empty($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }
        if (!empty($slider->image_path_mobile)) {
            Storage::disk('public')->delete($slider->image_path_mobile);
        }
    }

    /**
     * Processes the image upload, conversion, and cleanup for a given field.
     */
    private function processImage(MainSlider $slider, string $imageField)
    {
        $originalValue = $slider->getOriginal($imageField);
        $currentValue = $slider->{$imageField};

        // Condition to process new temporary uploads
        if ($slider->isDirty($imageField) && is_string($currentValue) && Str::contains($currentValue, 'temp-uploads')) {
            $tempPath = $currentValue;

            // If temp file doesn't exist, revert to original value
            if (!Storage::disk('public')->exists($tempPath)) {
                $slider->{$imageField} = $originalValue;
                return;
            }

            // Define file naming and paths
            $baseName = Str::slug(strip_tags($slider->subtitle));
            $directory = ($imageField === 'image_path_mobile') ? 'mobile' : 'desktop';
            $randomSuffix = Str::lower(Str::random(4));
            $newFileName = "{$baseName}-{$randomSuffix}.webp";

            $finalDirectory = 'main-sliders/' . $directory;
            $finalPath = $finalDirectory . '/' . $newFileName;

            try {
                $sourcePath = Storage::disk('public')->path($tempPath);
                $destinationPath = Storage::disk('public')->path($finalPath);

                // Ensure the destination directory exists
                if (!File::isDirectory(dirname($destinationPath))) {
                    File::makeDirectory(dirname($destinationPath), 0755, true, true);
                }

                // Create image from source and convert to WEBP
                $image = imagecreatefromstring(File::get($sourcePath));
                if ($image === false) throw new \Exception('Failed to create image from file.');

                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                imagewebp($image, $destinationPath, 80);
                imagedestroy($image);

                // Update the model field with the new path
                $slider->{$imageField} = $finalPath;

                // Delete the old image if it existed
                if ($originalValue) {
                    Storage::disk('public')->delete($originalValue);
                }

            } catch (\Exception $e) {
                logger()->error("Image conversion failed for slider {$slider->id}, field {$imageField}: " . $e->getMessage());
                // Revert to original value on failure
                $slider->{$imageField} = $originalValue;
            } finally {
                // Always delete the temporary file
                Storage::disk('public')->delete($tempPath);
            }
        }
        // Condition to handle image deletion from the form
        else if ($slider->isDirty($imageField) && empty($currentValue) && !empty($originalValue)) {
            Storage::disk('public')->delete($originalValue);
        }
    }
}
