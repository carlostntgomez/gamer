<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductObserver
{
    public function saving(Product $product)
    {
        // Process the single main image
        if ($product->isDirty('main_image_path')) {
            $this->processSingleImage($product, 'main_image_path');
        }

        // Process the array of gallery images
        if ($product->isDirty('gallery_image_paths')) {
            $this->processGalleryImages($product);
        }
    }

    public function deleted(Product $product)
    {
        // Use getAttributes to get the paths before the model is gone
        $attributes = $product->getAttributes();

        // Delete main image
        if (!empty($attributes['main_image_path'])) {
            Storage::disk('public')->delete($attributes['main_image_path']);
        }

        // Delete gallery images
        if (!empty($attributes['gallery_image_paths'])) {
            $galleryPaths = json_decode($attributes['gallery_image_paths'], true);
            if (is_array($galleryPaths)) {
                foreach ($galleryPaths as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
    }

    /**
     * Processes a single image field (upload, conversion, cleanup).
     */
    private function processSingleImage(Product $product, string $fieldName)
    {
        $originalPath = $product->getOriginal($fieldName);
        $tempPath = $product->{$fieldName};

        // No change, or not a temp file, do nothing.
        if (!$product->isDirty($fieldName) || !is_string($tempPath) || !Str::contains($tempPath, 'temp-uploads')) {
            return;
        }
        
        // If the new path is empty, it means the user removed the image
        if (empty($tempPath) && !empty($originalPath)) {
            Storage::disk('public')->delete($originalPath);
            return;
        }

        $finalPath = $this->moveAndConvertImage($tempPath, $product->name, 'main');

        if ($finalPath) {
            $product->{$fieldName} = $finalPath;
            // Delete the old image if a new one was successfully uploaded
            if ($originalPath) {
                Storage::disk('public')->delete($originalPath);
            }
        } else {
            // If processing failed, revert to the original path
            $product->{$fieldName} = $originalPath;
        }
    }

    /**
     * Processes an array of gallery images.
     */
    private function processGalleryImages(Product $product)
    {
        $originalPaths = json_decode($product->getOriginal('gallery_image_paths'), true) ?: [];
        $tempPaths = $product->gallery_image_paths ?: []; // This comes as an array from Filament

        $finalPaths = [];

        // Identify which old images to keep (they won't be in the temp path array)
        $keptPaths = array_intersect($tempPaths, $originalPaths);
        $finalPaths = array_merge($finalPaths, $keptPaths);

        // Identify new images to process (they will have 'temp-uploads' in their path)
        $newTempPaths = array_filter($tempPaths, fn ($path) => is_string($path) && Str::contains($path, 'temp-uploads'));

        foreach ($newTempPaths as $index => $tempPath) {
            $finalPath = $this->moveAndConvertImage($tempPath, $product->name, 'gallery-' . ($index + 1));
            if ($finalPath) {
                $finalPaths[] = $finalPath;
            }
        }

        // Identify and delete images that were removed by the user
        $deletedPaths = array_diff($originalPaths, $keptPaths);
        foreach ($deletedPaths as $path) {
            Storage::disk('public')->delete($path);
        }

        // Update the model attribute with the final array of paths
        $product->gallery_image_paths = $finalPaths;
    }

    /**
     * Helper to move, convert image to WebP, and return the new path.
     */
    private function moveAndConvertImage(string $tempPath, string $productName, string $imageType): ?string
    {
        if (!Storage::disk('public')->exists($tempPath)) {
            return null;
        }

        $baseName = Str::slug($productName);
        $randomSuffix = Str::lower(Str::random(6));
        $newFileName = "{$baseName}-{$imageType}-{$randomSuffix}.webp";
        $finalPath = 'products/' . $newFileName;

        try {
            $sourceFile = Storage::disk('public')->path($tempPath);
            $destinationFile = Storage::disk('public')->path($finalPath);

            if (!File::exists(dirname($destinationFile))) {
                File::makeDirectory(dirname($destinationFile), 0755, true);
            }

            $image = imagecreatefromstring(File::get($sourceFile));
            if ($image === false) throw new \Exception('Failed to create image from source.');

            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            imagewebp($image, $destinationFile, 80);
            imagedestroy($image);

            return $finalPath;
        } catch (\Exception $e) {
            logger()->error("Image conversion failed for temp path {$tempPath}: " . $e->getMessage());
            return null;
        } finally {
            // Always clean up the temp file
            Storage::disk('public')->delete($tempPath);
        }
    }
}
