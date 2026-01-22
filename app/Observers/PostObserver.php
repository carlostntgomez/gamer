<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostObserver
{
    /**
     * Handle the Post "saving" event.
     */
    public function saving(Post $post)
    {
        // Solo hay un campo de imagen para procesar
        $this->processImage($post, 'main_image_path');
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post)
    {
        // Asegurarse de que la imagen de portada se elimine
        if (!empty($post->main_image_path)) {
            Storage::disk('public')->delete($post->main_image_path);
        }
    }

    /**
     * Procesa la carga, conversión y limpieza de la imagen para el campo especificado.
     */
    private function processImage(Post $post, string $imageField)
    {
        $originalValue = $post->getOriginal($imageField);
        $currentValue = $post->{$imageField};

        // Caso 1: Se ha subido un nuevo archivo temporal.
        if ($post->isDirty($imageField) && is_string($currentValue) && Str::contains($currentValue, 'temp-uploads')) {
            $tempPath = $currentValue;

            if (!Storage::disk('public')->exists($tempPath)) {
                $post->{$imageField} = $originalValue; // Revertir si el archivo temporal no se encuentra
                return;
            }

            // Generar nombre de archivo SEO amigable basado en el título del post
            $baseName = Str::slug($post->title);
            $randomSuffix = Str::lower(Str::random(4));
            $newFileName = "{$baseName}-{$randomSuffix}.webp";

            $finalDirectory = 'posts';
            $finalPath = $finalDirectory . '/' . $newFileName;

            try {
                $sourcePath = Storage::disk('public')->path($tempPath);
                $destinationPath = Storage::disk('public')->path($finalPath);

                if (!File::isDirectory(dirname($destinationPath))) {
                    File::makeDirectory(dirname($destinationPath), 0755, true, true);
                }

                $image = imagecreatefromstring(File::get($sourcePath));
                if ($image === false) throw new \Exception('No se pudo crear la imagen desde el archivo.');

                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                imagewebp($image, $destinationPath, 80); // 80% calidad
                imagedestroy($image);

                $post->{$imageField} = $finalPath; // Actualizar el modelo con la nueva ruta

                // Si había una imagen antigua, eliminarla ahora
                if ($originalValue) {
                    Storage::disk('public')->delete($originalValue);
                }

            } catch (\Exception $e) {
                logger()->error("La conversión de imagen falló para el post {$post->id}: " . $e->getMessage());
                $post->{$imageField} = $originalValue; // Revertir en caso de error
            } finally {
                // Limpiar siempre el archivo temporal
                Storage::disk('public')->delete($tempPath);
            }
        }
        // Caso 2: El campo de imagen se está vaciando (poniendo a null)
        else if ($post->isDirty($imageField) && empty($currentValue) && !empty($originalValue)) {
            Storage::disk('public')->delete($originalValue);
        }
    }
}
