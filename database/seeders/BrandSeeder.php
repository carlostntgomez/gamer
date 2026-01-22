<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Marcas ---');

        // Definir rutas
        $finalStoragePath = storage_path('app/public/brands');
        $tempStoragePath = storage_path('app/public/temp-uploads/seeder');
        $sampleImagesPath = public_path('imagenes de muestra/brand-logo');

        // 1. Operaciones de limpieza
        $this->command->comment('Realizando limpieza de datos antiguos...');
        Schema::disableForeignKeyConstraints();
        Brand::truncate();
        Schema::enableForeignKeyConstraints();

        File::deleteDirectory($finalStoragePath);
        File::makeDirectory($finalStoragePath, 0755, true);
        File::deleteDirectory($tempStoragePath);
        File::makeDirectory($tempStoragePath, 0755, true);
        $this->command->comment('Limpieza completada.');

        // 2. Definir las marcas a crear
        $brands = [
            // Videojuegos (Moderno y PC)
            'Sony', 'Microsoft', 'Nintendo', 'Valve',
            // Videojuegos (Retro)
            'Sega',
            // Accesorios y Componentes
            'Logitech', 'Razer', 'Corsair', 'AMD', 'Nvidia',
            // Celulares y Wearables
            'Samsung', 'Apple', 'Xiaomi', 'Google'
        ];

        // 3. Obtener logos de muestra disponibles
        if (!File::isDirectory($sampleImagesPath)) {
            $this->command->error('Directorio de imágenes de muestra no encontrado: ' . $sampleImagesPath);
            $this->command->info('Como alternativa, se crearán las marcas sin logos.');
            foreach ($brands as $name) {
                Brand::create(['name' => $name]);
            }
            return;
        }

        $availableLogos = array_map(fn($file) => $file->getFilename(), File::files($sampleImagesPath));

        if (empty($availableLogos)) {
            $this->command->warn('No se encontraron logos de muestra. Se crearán las marcas sin logos.');
            foreach ($brands as $name) {
                Brand::create(['name' => $name]);
            }
            return;
        }

        // 4. Crear las marcas con logos aleatorios
        $this->command->info('Creando ' . count($brands) . ' marcas y asignando logos aleatorios...');
        foreach ($brands as $brandName) {
            $randomLogoFile = $availableLogos[array_rand($availableLogos)];
            $tempLogoPath = $this->copyToTemp($sampleImagesPath, $tempStoragePath, $randomLogoFile, $brandName);
            
            Brand::create([
                'name' => $brandName,
                'logo_path' => $tempLogoPath,
            ]);
        }
        
        $this->command->info('Seeder de Marcas finalizado con éxito.');
        $this->command->comment('El BrandObserver ha procesado, convertido (WebP) y movido los logos automáticamente.');
        $this->command->info('--- Seeder de Marcas finalizado ---');
    }

    private function copyToTemp(string $samplePath, string $tempPath, ?string $fileName, string $brandName): ?string
    {
        if (!$fileName) return null;

        $sourceFile = $samplePath . '/' . $fileName;
        if (!File::exists($sourceFile)) {
            $this->command->warn("  - Archivo de logo no encontrado para '{$brandName}': {$fileName}");
            return null;
        }

        $tempFileName = Str::random(20) . '.' . File::extension($sourceFile);
        $destinationFile = $tempPath . '/' . $tempFileName;

        File::copy($sourceFile, $destinationFile);
        $relativePath = 'temp-uploads/seeder/' . $tempFileName;

        $this->command->line("  - Logo '{$fileName}' preparado para '{$brandName}' en ubicación temporal: {$relativePath}");

        return $relativePath;
    }
}
