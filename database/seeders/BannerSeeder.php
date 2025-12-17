<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->command->info('Limpiando y recreando el directorio de imágenes de banners...');
        $this->clearDirectory(storage_path('app/public/banners'));

        $sampleImagesPath = public_path('imagenes de muestra');
        $sampleImages = File::files($sampleImagesPath);

        if (empty($sampleImages)) {
            $this->command->warn('No se encontraron imágenes de muestra. Los banners se crearán sin imágenes.');
            return; // Salir si no hay imágenes
        }

        $this->command->info('Creando 5 banners y asignando imágenes...');

        Banner::factory()->count(5)->create()->each(function (Banner $banner) use ($sampleImages) {
            $randomImage = $sampleImages[array_rand($sampleImages)];
            $this->addImageToBanner($banner, $randomImage->getRealPath());
        });

        $this->command->info('Banners creados exitosamente.');
    }

    private function addImageToBanner(Banner $banner, string $imagePath): void
    {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        // Crear un slug a partir del nombre del banner para el nombre del archivo
        $slug = Str::slug($banner->name);
        $fileName = $slug . '.' . $extension;

        try {
            $banner->addMedia($imagePath)
                   ->preservingOriginal()
                   ->usingFileName($fileName)
                   ->toMediaCollection('banners');

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
