<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->command->info('Limpiando el directorio de imágenes de productos...');
        $this->clearProductsDirectory();

        $this->command->info('Creando 5 productos...');
        Product::factory()->count(5)
            ->sequence(fn ($sequence) => ['name' => $name = fake()->words(3, true), 'slug' => Str::slug($name)])
            ->create()->each(function ($product) {
            $this->command->info("Procesando producto: {$product->name}");
            $this->addImagesToProduct($product);
        });

        $this->command->info('Productos creados y con imágenes asociadas.');
    }

    private function addImagesToProduct(Product $product)
    {
        $sampleImagesPath = public_path('imagenes de muestra');
        $imageFiles = glob($sampleImagesPath . '/*.{jpg,png,jpeg,webp}', GLOB_BRACE);

        if (empty($imageFiles)) {
            $this->command->warn("No se encontraron imágenes de muestra en: {$sampleImagesPath}");
            return;
        }

        $numberOfImages = rand(3, 6);
        $randomImages = (array) array_rand(array_flip($imageFiles), $numberOfImages);

        // Procesar la imagen principal
        $mainImagePath = array_shift($randomImages);
        if ($mainImagePath) {
            $this->addImage($product, $mainImagePath, 'main_image');
        }

        // Procesar las imágenes de la galería
        $galleryIndex = 1;
        foreach ($randomImages as $galleryImagePath) {
            $this->addImage($product, $galleryImagePath, 'gallery_images', $galleryIndex);
            $galleryIndex++;
        }
    }

    private function addImage(Product $product, string $imagePath, string $collectionName, int $index = 0)
    {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $fileName = $this->generateFileName($product, $collectionName, $extension, $index);

        try {
            $product->addMedia($imagePath)
                ->preservingOriginal()
                ->usingFileName($fileName)
                ->toMediaCollection($collectionName);

            $this->command->info("  - Imagen agregada a '{$collectionName}': {$fileName}");
        } catch (\Exception $e) {
            $this->command->error("  - No se pudo agregar la imagen {$imagePath}: " . $e->getMessage());
        }
    }

    private function generateFileName(Product $product, string $collectionName, string $extension, int $index): string
    {
        $slug = Str::slug($product->name);

        if ($collectionName === 'main_image') {
            return "{$slug}-main.{$extension}";
        }

        return "{$slug}-gallery-{$index}.{$extension}";
    }

    private function clearProductsDirectory()
    {
        $directory = storage_path('app/public/product');

        if (File::isDirectory($directory)) {
            File::deleteDirectory($directory);
        }
        
        File::makeDirectory($directory, 0755, true, true);
    }
}
