<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Iniciando el seeder de testimonios...');

        $this->command->info('Limpiando la tabla y el directorio de testimonios...');
        Schema::disableForeignKeyConstraints();
        Testimonial::truncate();
        Schema::enableForeignKeyConstraints();

        $storagePath = storage_path('app/public/testimonials');
        $this->clearDirectory($storagePath);

        $sampleImagesPath = public_path('imagenes de muestra/posts'); // Corrected path
        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->error('No se encontraron imágenes en la carpeta de muestra: ' . $sampleImagesPath);
            $this->command->error('El seeder no puede continuar sin imágenes. Por favor, añada imágenes a esa ruta.');
            return;
        }
        $sampleImages = File::files($sampleImagesPath);
        $this->command->info(count($sampleImages) . ' imágenes de muestra encontradas.');

        $this->command->info('Creando 10 testimonios de prueba...');
        Testimonial::factory()->count(10)->create()->each(function (Testimonial $testimonial) use ($sampleImages, $storagePath) {
            $this->command->line("Testimonio de '{$testimonial->author_name}' creado. Procesando imagen...");

            // Asignar imagen
            $imageFile = $sampleImages[array_rand($sampleImages)];
            $sourcePath = $imageFile->getRealPath();
            $imageType = @exif_imagetype($sourcePath);

            $newFileName = Str::slug($testimonial->author_name) . '-' . uniqid() . '.webp';
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
                $dbPath = 'testimonials/' . $newFileName;
                $testimonial->image_path = $dbPath;
                $testimonial->save();
                $this->command->line("  - Imagen: {$dbPath}");
            }
        });

        $this->command->info('Seeder de testimonios finalizado con éxito.');
    }

    private function clearDirectory(string $path): void
    {
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        File::makeDirectory($path, 0755, true, true);
    }
}
