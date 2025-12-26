<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting Banner Seeder with WebP conversion...');

        // 1. Check for GD library
        if (!extension_loaded('gd')) {
            $this->command->error('The GD library extension is required, but it is not enabled.');
            return;
        }

        // 2. Cleanup
        Banner::query()->truncate();
        $storagePath = storage_path('app/public/banners');
        if (File::isDirectory($storagePath)) {
            File::deleteDirectory($storagePath);
        }
        File::makeDirectory($storagePath, 0755, true, true);
        $this->command->info('Cleaned up banners table and directory.');

        // 3. Get sample images
        $sampleImagesPath = public_path('imagenes de muestra/banners');
        if (!File::exists($sampleImagesPath)) {
            $this->command->error('Sample images directory not found: ' . $sampleImagesPath);
            return;
        }
        $sampleImages = File::files($sampleImagesPath);
        if (empty($sampleImages)) {
            $this->command->warn('No sample images found in ' . $sampleImagesPath);
            return; // Salir si no hay imágenes
        }

        // 4. Create Banner entries with specific images
        $bannerData = [
            ['name' => 'Banner Principal 1', 'order' => 1],
            ['name' => 'Banner Secundario 2', 'order' => 2],
            ['name' => 'Banner de Promoción 3', 'order' => 3],
        ];

        foreach ($sampleImages as $index => $sampleImage) {
            if (!isset($bannerData[$index])) continue; // Evita errores si hay más imágenes que datos

            $data = $bannerData[$index];
            $imagePath = null;
            $sourcePath = $sampleImage->getPathname();
            $originalFileName = $sampleImage->getFilename();

            $newWebpFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . uniqid() . '.webp';
            $destinationPath = $storagePath . '/' . $newWebpFileName;

            try {
                $image = @imagecreatefromstring(File::get($sourcePath));

                if ($image !== false) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    imagewebp($image, $destinationPath, 85); // 85% quality
                    imagedestroy($image);

                    $imagePath = 'banners/' . $newWebpFileName;
                    $this->command->info("Converted image for banner '{$data['name']}' -> {$imagePath}");
                } else {
                    $this->command->warn("Could not create image from string for banner '{$data['name']}'. File: " . $originalFileName);
                }
            } catch (\Exception $e) {
                $this->command->error("Failed to process image for banner '{$data['name']}': " . $e->getMessage());
            }

            Banner::create([
                'name' => $data['name'],
                'order' => $data['order'],
                'url' => '#',
                'is_active' => true,
                'image_path' => $imagePath,
            ]);
        }

        $this->command->info('Banner seeder finished successfully.');
    }
}
