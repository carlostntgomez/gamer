<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Enums\ProductType;
use App\Enums\ProductCondition;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Iniciando el seeder de productos...');

        // 1. Preparar el entorno
        $this->command->info('Limpiando tablas y directorios relacionados con productos...');
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        DB::table('category_product')->truncate();
        Schema::enableForeignKeyConstraints();
        
        $storagePath = storage_path('app/public/products');
        $this->clearDirectory($storagePath);

        // 2. Verificar dependencias (Imágenes, Marcas, Categorías)
        $sampleImages = $this->getSampleImages();
        if (empty($sampleImages)) return;

        $brands = Brand::all();
        $categories = Category::all();
        if ($brands->isEmpty() || $categories->isEmpty()) {
            $this->command->error('No se encontraron marcas o categorías. Ejecute los seeders de Brand y Category primero.');
            return;
        }

        $this->command->info('Creando 40 productos de prueba completos...');

        // 3. Crear productos en un bucle
        for ($i = 0; $i < 40; $i++) {
            $name = fake()->unique()->words(rand(2, 4), true);
            $slug = Str::slug($name);
            $brand = $brands->random();
            $category = $categories->random();

            // --- Precios Realistas (COP) ---
            $basePrice = round(fake()->numberBetween(50000, 5000000) / 1000) * 1000;
            $salePrice = fake()->boolean(40) ? $this->calculateSalePrice($basePrice) : null;

            // --- Atributos y SEO ---
            $isVisible = fake()->boolean(95);
            $availableColors = ['Rojo', 'Azul', 'Verde', 'Negro', 'Blanco', 'Gris', 'Plata', 'Dorado'];

            $productData = [
                'name' => ucfirst($name),
                'slug' => $slug,
                'description' => fake()->paragraphs(5, true),
                'price' => $basePrice,
                'sale_price' => $salePrice,
                'sku' => strtoupper(substr(str_replace(' ', '-', $name), 0, 8)) . '-' . fake()->unique()->numberBetween(1000, 9999),
                'stock_quantity' => fake()->numberBetween(0, 150),
                'is_visible' => $isVisible,
                'is_featured' => $isVisible ? fake()->boolean(25) : false, // Un producto no puede ser destacado si no es visible
                'is_new' => fake()->boolean(30),
                'brand_id' => $brand->id,
                'type' => fake()->randomElement(ProductType::cases())->value,
                'condition' => fake()->randomElement(ProductCondition::cases())->value,
                'colors' => fake()->randomElements($availableColors, rand(1, 4)),
                'seo_title' => ucfirst($name) . ' | ' . $brand->name,
                'seo_description' => fake()->sentence(20),
                'seo_keywords' => array_values(array_unique([$brand->name, $category->name, ...fake()->words(rand(2, 4))])),
            ];

            // 4. Crear Producto y Asociar Imágenes/Categorías
            $product = Product::create($productData);
            $product->categories()->attach($category->id);
            $this->addImagesToProduct($product, $sampleImages, $storagePath);

            $this->command->line("  - Producto '{$product->name}' creado.");
        }

        $this->command->info('Seeder de productos finalizado con éxito.');
    }

    private function calculateSalePrice(int $basePrice): int
    {
        $discount = fake()->numberBetween(10, 40) / 100;
        $salePrice = $basePrice * (1 - $discount);
        return round($salePrice / 1000) * 1000;
    }

    private function getSampleImages(): array
    {
        $sampleImagesPath = public_path('imagenes de muestra/products');
        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->error("La carpeta de imágenes de muestra está vacía o no existe: {$sampleImagesPath}");
            $this->command->error("El seeder no puede continuar. Añada imágenes a esa ruta para generar los productos.");
            return [];
        }
        $this->command->info('Imágenes de muestra encontradas. Continuando...');
        return File::files($sampleImagesPath);
    }

    private function addImagesToProduct(Product $product, array $sampleImages, string $storagePath): void
    {
        $numImages = rand(3, 6);
        $selectedImageKeys = array_rand($sampleImages, $numImages);
        $selectedImages = array_map(fn($key) => $sampleImages[$key], (array)$selectedImageKeys);

        $mainImageDbPath = null;
        $galleryImageDbPaths = [];

        foreach ($selectedImages as $index => $imageFile) {
            $sourcePath = $imageFile->getRealPath();
            $newFileName = Str::slug($product->name) . '-' . uniqid() . '.webp';
            $destinationPath = $storagePath . '/' . $newFileName;

            try {
                $image = imagecreatefromstring(File::get($sourcePath));
                if ($image !== false) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    imagewebp($image, $destinationPath, 80);
                    imagedestroy($image);
                    
                    $dbPath = 'products/' . $newFileName;
                    if ($index === 0) {
                        $mainImageDbPath = $dbPath;
                    } else {
                        $galleryImageDbPaths[] = $dbPath;
                    }
                }
            } catch (\Exception $e) {
                $this->command->warn("No se pudo procesar la imagen: {$sourcePath}. Error: " . $e->getMessage());
            }
        }

        $product->main_image_path = $mainImageDbPath;
        $product->gallery_image_paths = $galleryImageDbPaths;
        $product->save();
    }

    private function clearDirectory(string $path): void
    {
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        File::makeDirectory($path, 0755, true, true);
    }
}
