<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MainSlider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MainSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Iniciando el seeder del Main Slider...');

        MainSlider::truncate();

        $storagePath = storage_path('app/public/main-slider');
        if (File::isDirectory($storagePath)) {
            File::deleteDirectory($storagePath);
        }
        File::makeDirectory($storagePath, 0755, true, true);

        $sliders = [
            [
                'title' => '* Starting price $120.00',
                'subtitle' => '<h2><span>Portable wireless</span></h2>',
                'image_path' => 'home8-slider1.jpg',
                'image_path_mobile' => 'home8-mobile-slider1.jpg',
                'button_text' => 'Shop now',
                'button_link' => '#',
            ],
            [
                'title' => '* Starting price $120.00',
                'subtitle' => '<h2><span>Smart in 4k desk</span></h2>',
                'image_path' => 'home8-slider2.jpg',
                'image_path_mobile' => 'home8-mobile-slider2.png',
                'button_text' => 'Shop now',
                'button_link' => '#',
            ],
        ];

        foreach ($sliders as &$sliderData) { // Use reference to modify array directly
            foreach (['image_path', 'image_path_mobile'] as $key) {
                if (empty($sliderData[$key])) continue;

                $originalFileName = $sliderData[$key];
                $sourcePath = public_path('imagenes de muestra/sliders/' . $originalFileName);

                if (!File::exists($sourcePath)) {
                    $this->command->warn("No se encontró la imagen de muestra: {$sourcePath}");
                    $sliderData[$key] = null;
                    continue;
                }

                $newWebpFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . uniqid() . '.webp';
                $destinationPath = $storagePath . '/' . $newWebpFileName;

                try {
                    $image = imagecreatefromstring(File::get($sourcePath));
                    if ($image === false) {
                         $sliderData[$key] = null;
                         continue;
                    }

                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    imagewebp($image, $destinationPath, 80);
                    imagedestroy($image);

                    $sliderData[$key] = 'main-slider/' . $newWebpFileName;
                    $this->command->info("Imagen del slider procesada: {$newWebpFileName}");

                } catch (\Exception $e) {
                    $this->command->error("No se pudo procesar la imagen del slider: {$sourcePath}. Error: " . $e->getMessage());
                    $sliderData[$key] = null;
                }
            }

            MainSlider::create($sliderData);
        }
        $this->command->info('Seeder del Main Slider finalizado con éxito.');
    }
}
