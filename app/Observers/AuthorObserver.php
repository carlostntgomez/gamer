<?php

namespace App\Observers;

use App\Models\Author;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthorObserver
{
    /**
     * Handle the Author "saving" event.
     */
    public function saving(Author $author)
    {
        $this->processImage($author, 'avatar');
    }

    /**
     * Handle the Author "deleted" event.
     */
    public function deleted(Author $author)
    {
        if (!empty($author->avatar)) {
            Storage::disk('public')->delete($author->avatar);
        }
    }

    /**
     * Processes the image upload, conversion, and cleanup.
     */
    private function processImage(Author $author, string $imageField)
    {
        $originalValue = $author->getOriginal($imageField);
        $currentValue = $author->{$imageField};

        if ($author->isDirty($imageField) && is_string($currentValue) && Str::contains($currentValue, 'temp-uploads')) {
            $tempPath = $currentValue;

            if (!Storage::disk('public')->exists($tempPath)) {
                $author->{$imageField} = $originalValue;
                return;
            }

            $baseName = Str::slug($author->name);
            $randomSuffix = Str::lower(Str::random(4));
            $newFileName = "{$baseName}-{$randomSuffix}.webp";

            $finalDirectory = 'authors';
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

                $author->{$imageField} = $finalPath;

                if ($originalValue) {
                    Storage::disk('public')->delete($originalValue);
                }

            } catch (\Exception $e) {
                logger()->error("Image conversion failed for author {$author->id}: " . $e->getMessage());
                $author->{$imageField} = $originalValue;
            } finally {
                Storage::disk('public')->delete($tempPath);
            }
        }
        else if ($author->isDirty($imageField) && empty($currentValue) && !empty($originalValue)) {
            Storage::disk('public')->delete($originalValue);
        }
    }
}
