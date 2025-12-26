<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Define paths
        $sourcePath = public_path('imagenes de muestra/offers');
        $destinationDir = 'offers'; // Relative to the public disk

        // 2. Ensure the destination directory exists and is clean
        $this->command->info('Limpiando y preparando el directorio de ofertas...');
        Storage::disk('public')->deleteDirectory($destinationDir);
        Storage::disk('public')->makeDirectory($destinationDir);
        $storagePath = Storage::disk('public')->path($destinationDir);

        // 3. Check if the source directory exists
        if (!File::isDirectory($sourcePath)) {
            Log::warning('El directorio de imágenes de muestra para ofertas no existe: ' . $sourcePath);
            $this->command->warn('Source images directory for offers not found. Seeder will not run.');
            return;
        }

        // 4. Get image files
        $images = File::files($sourcePath);
        if (count($images) < 2) {
            $this->command->warn('No se encontraron suficientes imágenes en el directorio de muestra de ofertas (se requieren 2). El seeder no se ejecutará.');
            return;
        }

        // 5. Truncate the table to start fresh
        Offer::truncate();

        // 6. Define the offers data
        $offersData = [
            [
                'title' => '25% de descuento',
                'subtitle' => 'En monitores y accesorios seleccionados',
                'image_file' => $images[0], // Temporary store file info
                'cta_text' => 'Comprar ahora',
                'cta_link' => '#/tienda',
                'is_active' => true,
            ],
            [
                'title' => 'Audio Inmersivo',
                'subtitle' => 'Siente cada detalle con nuestros audífonos gamer',
                'image_file' => $images[1],
                'cta_text' => 'Descubrir',
                'cta_link' => '#/tienda',
                'is_active' => true,
            ],
        ];

        // 7. Process images and create offers
        $this->command->info('Creando ofertas y procesando imágenes...');
        foreach ($offersData as $data) {
            $imageDbPath = $this->processAndSaveImage($data['image_file'], $data['title'], $storagePath);

            if ($imageDbPath) {
                $offerToCreate = [
                    'title' => $data['title'],
                    'subtitle' => $data['subtitle'],
                    'image' => $imageDbPath,
                    'cta_text' => $data['cta_text'],
                    'cta_link' => $data['cta_link'],
                    'is_active' => $data['is_active'],
                ];
                
                Offer::create($offerToCreate);
                $this->command->line("  - Oferta '{$data['title']}' creada con imagen '{$imageDbPath}'.");
            }
        }

        $this->command->info('Seeder de ofertas ejecutado correctamente.');
    }

    private function processAndSaveImage(\SplFileInfo $imageFile, string $title, string $storagePath): ?string
    {
        $sourcePath = $imageFile->getRealPath();
        $newFileName = Str::slug($title) . '-' . uniqid() . '.webp';
        $destinationPath = $storagePath . '/' . $newFileName;

        try {
            $image = imagecreatefromstring(File::get($sourcePath));
            if ($image === false) {
                $this->command->warn("No se pudo crear el recurso de imagen desde: {$sourcePath}.");
                return null;
            }

            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            imagewebp($image, $destinationPath, 80);
            imagedestroy($image);
            
            return 'offers/' . $newFileName;

        } catch (\Exception $e) {
            $this->command->warn("No se pudo procesar la imagen: {$sourcePath}. Error: " . $e->getMessage());
            return null;
        }
    }
}
