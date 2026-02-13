<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Marcas (Estilo Estandarizado) ---');

        $this->cleanup();

        $sampleImages = $this->getSampleImages();
        if (empty($sampleImages)) {
            $this->command->error('No se encontraron imágenes en \'public/imagenes de muestra/brands\'. Abortando seeder.');
            return;
        }
        $this->command->info(count($sampleImages) . ' imágenes de muestra de marcas encontradas.');

        foreach ($sampleImages as $image) {
            $fileName = $image->getFilename();
            $brandName = Str::of(pathinfo($fileName, PATHINFO_FILENAME))->replace('-', ' ')->replace('logo', ' ')->replace('home4', ' ')->title()->trim();

            $this->command->comment("Procesando: {$fileName} -> {$brandName}");

            // Copiar la imagen al directorio temporal estandarizado
            $tempImageName = Str::random(10) . '.' . $image->getExtension();
            $tempPath = 'temp-uploads/' . $tempImageName;
            Storage::disk('public')->put($tempPath, file_get_contents($image->getRealPath()));

            // Crear la marca
            Brand::create([
                'name' => $brandName,
                'slug' => Str::slug($brandName),
                'logo_path' => $tempPath, // Guardar la ruta del directorio temporal
                'description' => 'Descripción de ejemplo para la marca ' . $brandName,
                'is_visible' => 1, // <-- CAMBIO A 1 PARA MÁXIMA COMPATIBILIDAD
            ]);
        }

        $this->command->info('Seeder de Marcas finalizado con éxito, siguiendo el patrón del proyecto.');
        $this->command->info('--- Seeder de Marcas finalizado ---');
    }

    private function cleanup(): void
    {
        $this->command->info('Limpiando datos y archivos de marcas antiguas...');
        Brand::query()->delete();
        
        $directoriesToClean = ['brands', 'temp-uploads']; 
        foreach ($directoriesToClean as $dir) {
            if (Storage::disk('public')->exists($dir)) {
            }
        }
        $this->command->info('Tabla de marcas limpiada.');
    }

    private function getSampleImages(): array
    {
        $sourceDirectory = public_path('imagenes de muestra/brands');
        if (!File::isDirectory($sourceDirectory)) {
            return [];
        }
        return File::files($sourceDirectory);
    }
}
