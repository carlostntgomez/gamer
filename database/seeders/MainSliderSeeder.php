<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MainSlider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MainSliderSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Iniciando el seeder del Main Slider...');

        // 1. Limpieza inicial
        MainSlider::truncate();
        Storage::disk('public')->deleteDirectory('main-sliders');
        Storage::disk('public')->deleteDirectory('temp-uploads');
        Storage::disk('public')->makeDirectory('main-sliders');
        Storage::disk('public')->makeDirectory('temp-uploads');

        // 2. Definir datos de los sliders con enfoque en gaming y Medellín
        $sliders = [
            [
                'subtitle' => '<h2>Potencia Extrema para tu PC</h2>',
                'title' => 'Componentes y periféricos para el gamer de verdad.',
                'button_text' => 'ARMA TU SETUP',
                'button_link' => '/constructor-pc',
                'image_name' => 'home8-slider1.jpg',
                'image_name_mobile' => 'home8-mobile-slider1.jpg',
            ],
            [
                'subtitle' => '<h2>¡Domicilios en todo Medellín!</h2>',
                'title' => 'Recibe tus gadgets en horas y domina la partida.',
                'button_text' => 'VER NOVEDADES',
                'button_link' => '/shop',
                'image_name' => 'home8-slider2.jpg',
                'image_name_mobile' => 'home8-mobile-slider2.png', 
            ],
        ];

        $sampleImagesPath = public_path('imagenes de muestra/sliders');

        foreach ($sliders as $sliderData) {
            $sourceFile = $sampleImagesPath . '/' . $sliderData['image_name'];
            $sourceFileMobile = $sampleImagesPath . '/' . $sliderData['image_name_mobile'];

            if (!File::exists($sourceFile) || !File::exists($sourceFileMobile)) {
                $this->command->error("No se encontraron las imágenes de muestra para el slider: " . strip_tags($sliderData['subtitle']));
                continue;
            }

            // 3. Simular subida de imágenes
            $tempPath = 'temp-uploads/' . Str::random(40) . '.' . File::extension($sourceFile);
            File::copy($sourceFile, Storage::disk('public')->path($tempPath));

            $tempPathMobile = 'temp-uploads/' . Str::random(40) . '.' . File::extension($sourceFileMobile);
            File::copy($sourceFileMobile, Storage::disk('public')->path($tempPathMobile));

            // 4. Crear el modelo (el observer se encarga de las imágenes)
            MainSlider::create([
                'title' => $sliderData['title'],
                'subtitle' => $sliderData['subtitle'],
                'button_text' => $sliderData['button_text'],
                'button_link' => $sliderData['button_link'],
                'image_path' => $tempPath,
                'image_path_mobile' => $tempPathMobile,
            ]);

            $this->command->info("Slider '" . strip_tags($sliderData['subtitle']) . "' creado. El observer procesará las imágenes.");
        }

        $this->command->info('Seeder del Main Slider finalizado con éxito.');
    }
}
