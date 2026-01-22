<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryObserver
{
    /**
     * Handle the Category "saving" event.
     * This event fires whenever a model is created or updated.
     */
    public function saving(Category $category)
    {
        // We define the image fields to process
        $imageFields = ['image_path', 'banner_path'];

        foreach ($imageFields as $field) {
            $this->processImage($category, $field);
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category)
    {
        // Use getAttributes to ensure we have the data even after deletion
        $attributes = $category->getAttributes();

        if (!empty($attributes['image_path'])) {
            Storage::disk('public')->delete($attributes['image_path']);
        }
        if (!empty($attributes['banner_path'])) {
            Storage::disk('public')->delete($attributes['banner_path']);
        }
    }

    /**
     * Processes the image upload, conversion, and cleanup for a given field.
     */
    private function processImage(Category $category, string $imageField)
    {
        $originalValue = $category->getOriginal($imageField);
        $currentValue = $category->{$imageField};

        // Case 1: A new temporary file has been uploaded.
        if ($category->isDirty($imageField) && is_string($currentValue) && Str::contains($currentValue, 'temp-uploads')) {
            $tempPath = $currentValue;

            if (!Storage::disk('public')->exists($tempPath)) {
                $category->{$imageField} = $originalValue; // Revert if temp file is missing
                return;
            }
            
            // SEO Friendly File Name Generation
            $baseName = Str::slug($category->name); // Use category name for SEO
            $imageTypeSuffix = ($imageField === 'banner_path') ? '-banner' : '';
            $randomSuffix = Str::lower(Str::random(4)); // Add a short random string to prevent conflicts
            $newFileName = "{$baseName}{$imageTypeSuffix}-{$randomSuffix}.webp";

            $finalDirectory = 'categories';
            $finalPath = $finalDirectory . '/' . $newFileName;

            try {
                $sourcePath = Storage::disk('public')->path($tempPath);
                $destinationPath = Storage::disk('public')->path($finalPath);

                // Ensure the destination directory exists
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

                // Update the model with the new, final path
                $category->{$imageField} = $finalPath;

                // If there was an old image, delete it now
                if ($originalValue) {
                    Storage::disk('public')->delete($originalValue);
                }

            } catch (\Exception $e) {
                // Log error and revert to keep the old image
                logger()->error("Image conversion failed for category field {$imageField}: " . $e->getMessage());
                $category->{$imageField} = $originalValue;
            } finally {
                // Always clean up the temporary file
                Storage::disk('public')->delete($tempPath);
            }
        }
        // Case 2: The field is being cleared (set to null)
        else if ($category->isDirty($imageField) && empty($currentValue) && !empty($originalValue)) {
             Storage::disk('public')->delete($originalValue);
        }
    }
}
