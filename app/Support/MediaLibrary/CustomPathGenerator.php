<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    /*
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    /*
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    /*
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        // Use the model's table name as the base directory
        // e.g., 'products', 'categories'
        $model = $media->model;
        if ($model) {
            // Convert class name to snake_case and pluralize for directory name
            $directory = \Illuminate\Support\Str::of(class_basename($model))->snake()->plural();
            return $directory . '/' . $media->getKey();
        }

        // Fallback to default if model is not available or unrecognized
        return 'misc/' . $media->getKey();
    }
}
