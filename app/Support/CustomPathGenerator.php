<?php

namespace App\Support;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Illuminate\Support\Str;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    protected function getBasePath(Media $media): string
    {
        $modelType = Str::kebab(class_basename($media->model_type));

        // Usar el ID del modelo para robustez, y el nombre para legibilidad.
        // Esto evita errores si el nombre no está disponible durante el ciclo de vida de Livewire.
        $modelIdentifier = $media->model->id . '-' . Str::kebab($media->model->name);

        return "{$modelType}/{$modelIdentifier}";
    }
}
