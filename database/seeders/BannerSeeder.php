<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Banners ---');

        $this->cleanup();

        $sampleImages = $this->getSampleImages();
        if (count($sampleImages) < 3) { // Necesitamos al menos 3 imágenes para el caso ideal
            $this->command->error('Se necesitan al menos 3 imágenes en \'public/imagenes de muestra/banners\'. Abortando.');
            return;
        }
        $this->command->info(count($sampleImages) . ' imágenes de muestra encontradas.');

        // 3 banners activos (recomendado) + banners inactivos para pruebas.
        $bannersData = [
            // --- 3 Banners Activos Recomendados ---
            [
                'name' => 'Promoción Especial de Verano',
                'order' => 10,
                'is_active' => true, // ACTIVO 1
                'url' => '/promociones',
                'starts_at' => Carbon::now()->subWeek(),
                'expires_at' => Carbon::now()->addMonth(),
            ],
            [
                'name' => 'Nuevos Ingresos: Colección Otoño',
                'order' => 20,
                'is_active' => true, // ACTIVO 2
                'url' => '/novedades',
                'starts_at' => null,
                'expires_at' => null,
            ],
            [
                'name' => 'Envío Gratis por 48hs',
                'order' => 30,
                'is_active' => true, // ACTIVO 3
                'url' => '/carrito',
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(2),
            ],

            // --- Banners Inactivos Adicionales para Pruebas ---
            [
                'name' => 'Liquidación de Invierno (Inactiva)',
                'order' => 40,
                'is_active' => false, // Inactivo por toggle
                'url' => '/liquidacion',
                'starts_at' => null,
                'expires_at' => null,
            ],
            [
                'name' => 'Próximamente: Black Friday (Inactivo)',
                'order' => 50,
                'is_active' => false, // Inactivo, para ser activado en el futuro
                'url' => '#',
                'starts_at' => Carbon::now()->addMonth(),
                'expires_at' => Carbon::now()->addMonth()->addDays(5),
            ],
            [
                'name' => 'Oferta Flash (Expirada y Archivada)',
                'order' => 60,
                'is_active' => false, // Inactivo porque ya terminó
                'url' => '/archivo-ofertas',
                'starts_at' => Carbon::now()->subMonths(2),
                'expires_at' => Carbon::now()->subMonth(),
            ],
        ];

        $this->command->info('Creando ' . count($bannersData) . ' banners de prueba (3 activos y 3 inactivos).');

        foreach ($bannersData as $index => $data) {
            if (!isset($sampleImages[$index])) {
                $this->command->warn('No hay suficientes imágenes de muestra. Reutilizando imágenes para los banners restantes.');
            }
            $image = $sampleImages[$index % count($sampleImages)];
            
            $tempImageName = Str::random(10) . '.' . $image->getExtension();
            $tempPath = 'temp-uploads/' . $tempImageName;
            
            Storage::disk('public')->put($tempPath, file_get_contents($image->getRealPath()));

            Banner::create(array_merge($data, ['image_path' => $tempPath]));
        }

        $this->command->info('Seeder de Banners finalizado con éxito.');
        $this->command->info('--- Seeder de Banners finalizado ---');
    }

    private function cleanup(): void
    {
        $this->command->info('Limpiando datos y archivos de banners antiguos...');
        Banner::query()->delete();
        $directoriesToClean = ['banners', 'temp-uploads'];
        foreach ($directoriesToClean as $dir) {
            Storage::disk('public')->deleteDirectory($dir);
            Storage::disk('public')->makeDirectory($dir);
        }
        $this->command->info('Tabla de banners y directorios de imágenes limpiados.');
    }

    private function getSampleImages(): array
    {
        $sourceDirectory = public_path('imagenes de muestra/banners');
        if (!File::isDirectory($sourceDirectory)) {
            return [];
        }
        return File::files($sourceDirectory);
    }
}
