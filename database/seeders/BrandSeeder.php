<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Limpiando y recreando el directorio de imágenes de marcas (logos)...');
        $this->clearDirectory(storage_path('app/public/brand'));

        // Intentar buscar logos en una carpeta específica, si no, usar la general
        $logoPath = public_path('imagenes de muestra/brands');
        if (!File::isDirectory($logoPath)) {
            $logoPath = public_path('imagenes de muestra');
        }
        $sampleLogos = File::files($logoPath);

        if (empty($sampleLogos)) {
            $this->command->warn('No se encontraron imágenes de logos. Las marcas se crearán sin logo.');
        }

        $brands = [
            'Sony', 'Microsoft', 'Nintendo', 'Valve', 'Logitech', 'Razer', 
            'Corsair', 'HyperX', 'Alienware', 'HP Omen', 'Samsung', 'Apple',
            'Google', 'OnePlus', 'Xiaomi'
        ];

        $this->command->info('Creando marcas y asignando logos...');

        foreach ($brands as $brandName) {
            $brand = Brand::create(['name' => $brandName]);

            if (!empty($sampleLogos)) {
                // Para un seeder, una imagen aleatoria es suficiente.
                $randomLogo = $sampleLogos[array_rand($sampleLogos)];
                $this->addLogoToBrand($brand, $randomLogo->getRealPath());
            }
        }

        $this->command->info('Marcas y logos creados exitosamente.');
    }

    private function addLogoToBrand(Brand $brand, string $imagePath): void
    {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $fileName = $brand->slug . '.' . $extension;

        try {
            $brand->addMedia($imagePath)
                  ->preservingOriginal()
                  ->usingFileName($fileName)
                  ->toMediaCollection('brand-logo');

            $this->command->line("  - Logo '{$fileName}' asignado a la marca '{$brand->name}'.");

        } catch (\Exception $e) {
            $this->command->error("  - No se pudo agregar el logo a la marca '{$brand->name}': " . $e->getMessage());
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
