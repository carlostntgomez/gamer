<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Iniciando el seeder de Ofertas...');

        // 1. Limpieza inicial
        Offer::truncate();
        Storage::disk('public')->deleteDirectory('offers');
        Storage::disk('public')->makeDirectory('offers');
        
        $tempDir = 'temp-uploads/seeder-offers';
        Storage::disk('public')->deleteDirectory($tempDir);
        Storage::disk('public')->makeDirectory($tempDir);

        $sourceImagePath = public_path('imagenes de muestra/offers');
        if (!File::isDirectory($sourceImagePath)) {
            $this->command->warn('Directorio de imágenes de muestra para ofertas no encontrado. Seeder omitido.');
            return;
        }

        $images = File::files($sourceImagePath);
        if (count($images) < 2) {
            $this->command->warn('No se encontraron suficientes imágenes de muestra para las ofertas (se requieren 2).');
            return;
        }

        $offers = [
            [
                'title' => '25% de descuento',
                'subtitle' => 'En monitores y accesorios seleccionados',
                'image_name' => $images[0]->getFilename(),
                'cta_text' => 'Comprar ahora',
                'cta_link' => '#/tienda',
                'is_active' => true,
            ],
            [
                'title' => 'Audio Inmersivo',
                'subtitle' => 'Siente cada detalle con nuestros audífonos gamer',
                'image_name' => $images[1]->getFilename(),
                'cta_text' => 'Descubrir',
                'cta_link' => '#/tienda',
                'is_active' => true,
            ],
        ];

        foreach ($offers as $offerData) {
            // 2. Simular la subida de archivos copiando la imagen de muestra a una ruta temporal
            $sourceFile = $sourceImagePath . '/' . $offerData['image_name'];
            if (!File::exists($sourceFile)) {
                $this->command->warn("No se encontró la imagen de muestra: {$sourceFile}");
                continue;
            }

            $tempFileName = Str::random(40) . '.' . pathinfo($offerData['image_name'], PATHINFO_EXTENSION);
            $tempFilePath = $tempDir . '/' . $tempFileName;
            
            Storage::disk('public')->put($tempFilePath, File::get($sourceFile));
            
            // Prepara los datos para la creación, usando la ruta temporal
            $dataToCreate = [
                'title' => $offerData['title'],
                'subtitle' => $offerData['subtitle'],
                'image_path' => $tempFilePath, // <-- La clave es usar la ruta temporal
                'cta_text' => $offerData['cta_text'],
                'cta_link' => $offerData['cta_link'],
                'is_active' => $offerData['is_active'],
            ];

            // 3. Crear el modelo. El Observer se encargará del resto.
            Offer::create($dataToCreate);
            $this->command->info("Oferta '{$offerData['title']}' creada. El observer procesará la imagen.");
        }

        $this->command->info('Seeder de Ofertas finalizado con éxito.');
    }
}
