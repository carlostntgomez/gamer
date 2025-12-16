<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Limpiando y recreando el directorio de imágenes de posts...');
        $this->clearDirectory(storage_path('app/public/post'));

        $this->command->info('Creando etiquetas para los posts...');
        Tag::factory()->count(10)->create();
        $tagIds = Tag::pluck('id')->toArray();

        $sampleImagesPath = public_path('imagenes de muestra');
        $sampleImages = File::files($sampleImagesPath);

        if (empty($sampleImages)) {
            $this->command->warn('No se encontraron imágenes de muestra. Los posts se crearán sin imagen destacada.');
        }

        $this->command->info('Creando 20 posts con imágenes y etiquetas...');
        Post::factory()->count(20)->create()->each(function (Post $post) use ($tagIds, $sampleImages) {
            // Asignar etiquetas
            $post->tags()->attach(fake()->randomElements($tagIds, rand(1, 3)));
            $this->command->line(" - Etiquetas asignadas al post: '{$post->title}'");

            // Asignar imagen destacada
            if (!empty($sampleImages)) {
                $randomImage = $sampleImages[array_rand($sampleImages)];
                $this->addFeaturedImage($post, $randomImage->getRealPath());
            }
        });

        $this->command->info('Posts, etiquetas e imágenes destacadas creados exitosamente.');
    }

    private function addFeaturedImage(Post $post, string $imagePath): void
    {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $fileName = $post->slug . '.' . $extension;

        try {
            $post->addMedia($imagePath)
                 ->preservingOriginal()
                 ->usingFileName($fileName)
                 ->toMediaCollection('featured_image');

            $this->command->line("   - Imagen '{$fileName}' asignada como destacada.");

        } catch (\Exception $e) {
            $this->command->error("   - No se pudo agregar la imagen al post '{$post->title}': " . $e->getMessage());
        }
    }

    private function clearDirectory(string $path): void
    {
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        File::makeDirectory($path, 0755, true, true);
    }
}
