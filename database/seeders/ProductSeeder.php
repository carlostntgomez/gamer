<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Enums\ProductType;
use App\Enums\ProductCondition;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Productos (Colaborando con Observer) ---');

        $faker = Faker::create();
        $brands = Brand::pluck('id');
        $categories = Category::pluck('id');

        if ($brands->isEmpty() || $categories->isEmpty()) {
            $this->command->error('No hay marcas o categorías. Ejecuta los seeders correspondientes.');
            return;
        }

        $sampleImages = $this->getSampleImages();
        if (empty($sampleImages)) {
            $this->command->error('No se encontraron imágenes de muestra en \'public/imagenes de muestra/products\'.');
            return;
        }

        $this->cleanupBeforeSeeding();

        $this->command->info('Creando 70 productos de prueba...');

        for ($i = 0; $i < 70; $i++) {
            $productName = $faker->words($faker->numberBetween(2, 4), true);
            $uniqueSlug = Str::slug($productName . '-' . $i);

            // 1. Simular la subida a temp-uploads
            $mainImageTempPath = $this->storeInTempDir($sampleImages[array_rand($sampleImages)]);
            
            $galleryTempPaths = [];
            $galleryImageCount = $faker->numberBetween(2, 5);
            $selectedIndexes = (array) array_rand($sampleImages, $galleryImageCount);
            foreach ($selectedIndexes as $index) {
                $galleryTempPaths[] = $this->storeInTempDir($sampleImages[$index]);
            }

            // 2. Pasar rutas temporales al crear el producto
            $product = Product::create([
                'name' => ucfirst($productName),
                'slug' => $uniqueSlug,
                'brand_id' => $brands->random(),
                'main_image_path' => $mainImageTempPath, // El observer se encargará de esto
                'gallery_image_paths' => $galleryTempPaths, // Y de esto
                
                // --- Otros datos del producto ---
                'price' => round($faker->numberBetween(50000, 3000000) / 1000) * 1000,
                'short_description' => $faker->sentence(),
                'long_description' => '<p>' . implode('</p><p>', $faker->paragraphs(3)) . '</p>',
                'stock_quantity' => $faker->numberBetween(0, 100),
                'sku' => 'TEC-' . strtoupper(Str::random(8)),
                'type' => $faker->randomElement(ProductType::class),
                'condition' => $faker->randomElement(ProductCondition::class),
                'is_visible' => true,
                'is_featured' => $faker->boolean(20),
            ]);

            $product->categories()->attach($categories->random($faker->numberBetween(1, 3))->all());
        }

        $this->command->info('Se han creado 70 productos. El ProductObserver ha procesado las imágenes.');
        $this->command->info('--- Seeder de Productos finalizado ---');
    }

    private function cleanupBeforeSeeding(): void
    {
        $this->command->info('Limpiando productos y archivos antiguos...');
        Product::query()->delete();

        Storage::disk('public')->deleteDirectory('products');
        Storage::disk('public')->deleteDirectory('temp-uploads');
        Storage::disk('public')->makeDirectory('products');
        Storage::disk('public')->makeDirectory('temp-uploads');

        $this->command->info('Limpieza completada.');
    }

    private function getSampleImages(): array
    {
        $sourceDirectory = public_path('imagenes de muestra/products');
        return File::isDirectory($sourceDirectory) ? File::files($sourceDirectory) : [];
    }
    
    private function storeInTempDir(\SplFileInfo $file): string
    {
        // CORRECCIÓN: Asegurarse de que el directorio de destino exista.
        $tempDirectory = 'temp-uploads';
        Storage::disk('public')->makeDirectory($tempDirectory);
        
        $tempPath = $tempDirectory . '/' . Str::random(20) . '.' . $file->getExtension();
        
        $content = $file->getContents();
        Storage::disk('public')->put($tempPath, $content);

        return $tempPath;
    }
}
