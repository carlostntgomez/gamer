<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Illuminate\Support\Str;

class MediaPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $modelType = Str::lower(class_basename($media->model_type));
        $collectionName = $media->collection_name;

        // Use a consistent path structure based on the model ID, or the media UUID as a fallback.
        // This avoids relying on model properties that might be unavailable during Livewire updates.
        $basePath = $media->model_id ?? $media->uuid;

        return "{$modelType}/{$basePath}/{$collectionName}/";
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }
}
