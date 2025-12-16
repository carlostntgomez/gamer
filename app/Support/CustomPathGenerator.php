<?php

namespace App\Support;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Illuminate\Support\Str;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $modelType = Str::plural(Str::lower(class_basename($media->model_type)));
        return $modelType . '/' . $media->getKey() . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        $modelType = Str::plural(Str::lower(class_basename($media->model_type)));
        return $modelType . '/' . $media->getKey() . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        $modelType = Str::plural(Str::lower(class_basename($media->model_type)));
        return $modelType . '/' . $media->getKey() . '/responsive-images/';
    }
}
