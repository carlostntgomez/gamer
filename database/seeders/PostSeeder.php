<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Iniciando el seeder de posts...');

        $this->command->info('Limpiando tablas y directorios relacionados con los posts...');
        Schema::disableForeignKeyConstraints();
        Post::truncate();
        Tag::truncate();
        DB::table('post_tag')->truncate();
        Schema::enableForeignKeyConstraints();

        $storagePath = storage_path('app/public/posts');
        $this->clearDirectory($storagePath);

        $sampleImagesPath = public_path('imagenes de muestra/posts');
        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->error('No se encontraron imágenes en la carpeta de muestra: ' . $sampleImagesPath);
            $this->command->error('El seeder no puede continuar sin imágenes. Por favor, añada imágenes a esa ruta.');
            return;
        }
        $sampleImages = File::files($sampleImagesPath);
        $this->command->info(count($sampleImages) . ' imágenes de muestra encontradas.');

        $this->command->info('Creando 10 etiquetas de prueba...');
        $tags = Tag::factory()->count(10)->create();
        $tagIds = $tags->pluck('id')->toArray();

        $this->command->info('Creando 20 posts de prueba...');
        Post::factory()->count(20)->create()->each(function (Post $post) use ($tagIds, $sampleImages, $storagePath) {
            $this->command->line("Post '{$post->title}' creado. Procesando imagen y etiquetas...");

            // Asignar etiquetas
            $post->tags()->attach(fake()->randomElements($tagIds, rand(1, 3)));

            // Asignar imagen destacada
            $imageFile = $sampleImages[array_rand($sampleImages)];
            $sourcePath = $imageFile->getRealPath();
            $imageType = @exif_imagetype($sourcePath);

            $newFileName = $post->slug . '-' . uniqid() . '.webp';
            $destinationPath = $storagePath . '/' . $newFileName;

            $image = null;
            $processed = false;

            switch ($imageType) {
                case IMAGETYPE_JPEG: $image = imagecreatefromjpeg($sourcePath); break;
                case IMAGETYPE_PNG: 
                    $image = imagecreatefrompng($sourcePath);
                    imagepalettetotruecolor($image); 
                    imagealphablending($image, true); 
                    imagesavealpha($image, true); 
                    break;
                case IMAGETYPE_GIF: $image = imagecreatefromgif($sourcePath); break;
                case IMAGETYPE_WEBP: 
                    File::copy($sourcePath, $destinationPath); 
                    $processed = true; 
                    break;
            }

            if ($image !== null) {
                imagewebp($image, $destinationPath, 80);
                imagedestroy($image);
                $processed = true;
            }

            if ($processed) {
                $dbPath = 'posts/' . $newFileName;
                $post->image_path = $dbPath;
                $post->save();
                $this->command->line("  - Imagen destacada: {$dbPath}");
            }
        });

        $this->command->info('Seeder de posts finalizado con éxito.');
    }

    private function clearDirectory(string $path): void
    {
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        File::makeDirectory($path, 0755, true, true);
    }
}
