<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BannerSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->command->info('Limpiando y recreando el directorio de imágenes de banners...');
        $this->clearDirectory(storage_path('app/public/banner'));

        $sampleImagesPath = public_path('imagenes de muestra');
        $sampleImages = File::files($sampleImagesPath);

        if (empty($sampleImages)) {
            $this->command->warn('No se encontraron imágenes de muestra. Los banners se crearán sin imágenes.');
            return; // Salir si no hay imágenes
        }

        $this->command->info('Creando 5 banners y asignando imágenes...');

        for ($i = 1; $i <= 5; $i++) {
            $banner = Banner::factory()->create([
                'order' => $i, // Asignar un orden secuencial
            ]);

            $randomImage = $sampleImages[array_rand($sampleImages)];
            $this->addImageToBanner($banner, $randomImage->getRealPath(), $i);
        }

        $this->command->info('Banners creados exitosamente.');
    }

    private function addImageToBanner(Banner $banner, string $imagePath, int $index): void
    {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        // Usar un nombre de archivo secuencial y descriptivo
        $fileName = 'banner-' . $index . '.' . $extension;

        try {
            $banner->addMedia($imagePath)
                   ->preservingOriginal()
                   ->usingFileName($fileName)
                   ->toMediaCollection('banner_image');

            $this->command->line("  - Imagen '{$fileName}' asignada al banner '{$banner->name}'.");

        } catch (\Exception $e) {
            $this->command->error("  - No se pudo agregar la imagen al banner '{$banner->name}': " . $e->getMessage());
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
