<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Limpiando y recreando el directorio de imágenes de marcas (logos)...');
        $storagePath = storage_path('app/public/brands');
        $this->clearDirectory($storagePath);

        $this->command->info('Eliminando todas las marcas existentes...');
        Schema::disableForeignKeyConstraints();
        Brand::truncate();
        Schema::enableForeignKeyConstraints();

        $sampleImagesPath = public_path('imagenes de muestra/brands'); // BUG FIXED: Added 's' to 'brands'
        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->warn('! No se encontraron imágenes de logos. Las marcas se crearán sin logo.');
            $sampleImages = [];
        } else {
            $sampleImages = File::files($sampleImagesPath);
        }

        $brands = [
            'Sony', 'Microsoft', 'Nintendo', 'Valve', 'Logitech', 'Razer', 
            'Corsair', 'HyperX', 'Alienware', 'HP Omen', 'Samsung', 'Apple',
            'Google', 'OnePlus', 'Xiaomi'
        ];

        $this->command->info('Creando marcas y asignando logos (convertidos a WebP)...');

        foreach ($brands as $brandName) {
            $logoDbPath = null;

            if (!empty($sampleImages)) {
                $randomImageFile = $sampleImages[array_rand($sampleImages)];
                $sourcePath = $randomImageFile->getRealPath();

                $imageType = @exif_imagetype($sourcePath);

                $newFileName = Str::slug($brandName) . '-' . uniqid() . '.webp';
                $destinationPath = $storagePath . '/' . $newFileName;

                $image = null;
                $processed = false;

                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        $image = imagecreatefromjpeg($sourcePath);
                        break;
                    case IMAGETYPE_PNG:
                        $image = imagecreatefrompng($sourcePath);
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;
                    case IMAGETYPE_GIF:
                        $image = imagecreatefromgif($sourcePath);
                        break;
                    case IMAGETYPE_WEBP:
                        File::copy($sourcePath, $destinationPath);
                        $processed = true;
                        $this->command->line("  - Logo '{$randomImageFile->getFilename()}' (already webp) for '{$brandName}'.");
                        break;
                    default:
                        $this->command->error("  - Unsupported or corrupt image for '{$randomImageFile->getFilename()}'. Brand '{$brandName}' will have no logo.");
                        continue 2; // Skip to the next brand
                }

                if ($image !== null) {
                    imagewebp($image, $destinationPath, 80);
                    imagedestroy($image);
                    $processed = true;
                    $this->command->line("  - Logo '{$randomImageFile->getFilename()}' converted to webp for '{$brandName}'.");
                }

                if ($processed) {
                    $logoDbPath = 'brands/' . $newFileName;
                }
            }

            Brand::create([
                'name' => $brandName,
                'logo_path' => $logoDbPath,
            ]);
        }

        $this->command->info('Marcas y logos creados exitosamente.');
    }

    private function clearDirectory(string $path): void
    {
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        File::makeDirectory($path, 0755, true, true);
    }
}
