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
    private const PRODUCT_COUNT = 40;
    private array $sampleImages = [];
    private string $storagePath = '';

    public function run(): void
    {
        $this->command->info('🚀 Iniciando el seeder de productos mejorado...');

        if (!$this->prepareEnvironment()) return;

        $brands = Brand::all();
        $categories = Category::all();

        if ($brands->isEmpty() || $categories->isEmpty()) {
            $this->command->error('No se encontraron marcas o categorías. Ejecute los seeders de Brand y Category primero.');
            return;
        }

        $this->command->info('Creando ' . self::PRODUCT_COUNT . ' productos de prueba realistas...');
        $progressBar = $this->command->getOutput()->createProgressBar(self::PRODUCT_COUNT);

        for ($i = 0; $i < self::PRODUCT_COUNT; $i++) {
            $category = $categories->random();
            $brand = $brands->random();

            $productData = $this->generateProductData($category, $brand);

            $product = Product::create($productData);
            $product->categories()->attach($category->id);
            $this->addImagesToProduct($product);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->info('\n✅ Seeder de productos finalizado con éxito.');
    }

    private function prepareEnvironment(): bool
    {
        $this->command->info('🧹 Limpiando tablas y directorios antiguos...');
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        DB::table('category_product')->truncate();
        Schema::enableForeignKeyConstraints();

        $this->storagePath = storage_path('app/public/products');
        if (File::isDirectory($this->storagePath)) {
            File::deleteDirectory($this->storagePath);
        }
        File::makeDirectory($this->storagePath, 0755, true, true);

        $sampleImagesPath = public_path('imagenes de muestra/products');
        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->error("La carpeta de imágenes de muestra está vacía o no existe: {$sampleImagesPath}");
            $this->command->error("El seeder no puede continuar. Añada imágenes a esa ruta para generar los productos.");
            return false;
        }
        $this->sampleImages = File::files($sampleImagesPath);
        return true;
    }

    private function generateProductData(Category $category, Brand $brand): array
    {
        $name = $this->generateProductName($category);
        $basePrice = $this->generatePriceForCategory($category);
        $specifications = $this->generateSpecificationsForCategory($category);
        $longDescription = $this->generateLongDescription($name, $specifications);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'brand_id' => $brand->id,
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'short_description' => fake()->sentence(20),
            'long_description' => $longDescription,
            'specifications' => $specifications,
            'price' => $basePrice,
            'sale_price' => fake()->boolean(40) ? round(($basePrice * (1 - fake()->numberBetween(10, 35) / 100)) / 1000) * 1000 : null,
            'stock_quantity' => fake()->numberBetween(0, 200),
            'is_visible' => fake()->boolean(95),
            'is_featured' => fake()->boolean(25),
            'is_new' => fake()->boolean(30),
            'type' => fake()->randomElement(ProductType::cases())->value,
            'condition' => fake()->randomElement(ProductCondition::cases())->value,
            'colors' => fake()->randomElements(['Rojo', 'Azul', 'Verde', 'Negro', 'Blanco', 'Gris', 'Plata', 'Dorado'], rand(1, 4)),
            'video_url' => fake()->boolean(20) ? 'https://www.youtube.com/watch?v=0Aja_yP93PY' : null,
            'delivery_info' => $this->getSampleDeliveryInfo(),
            'return_policy' => $this->getSampleReturnPolicy(),
            'seo_title' => Str::limit($name . ' | ' . $brand->name, 60, ''),
            'seo_description' => Str::limit(fake()->sentence(25), 160, '...'),
            'seo_keywords' => array_values(array_unique([$brand->name, $category->name, ...array_values($specifications), ...fake()->words(2)])),
        ];
    }

    private function generateProductName(Category $category): string
    {
        $catName = strtolower($category->name);
        $prefix = '';

        if (str_contains($catName, 'laptop')) $prefix = 'Laptop Gamer';
        elseif (str_contains($catName, 'monitor')) $prefix = 'Monitor Curvo';
        elseif (str_contains($catName, 'juego')) $prefix = 'Juego PS5';
        elseif (str_contains($catName, 'audifono')) $prefix = 'Auriculares Inalámbricos';
        elseif (str_contains($catName, 'smartphone')) $prefix = 'Teléfono Inteligente';
        else $prefix = 'Producto';

        return fake()->unique()->words(rand(1, 2), true) . ' ' . $prefix . ' ' . fake()->lastName;
    }

    private function generatePriceForCategory(Category $category): int
    {
        $catName = strtolower($category->name);
        $priceRange = [100000, 800000]; // Default

        if (str_contains($catName, 'laptop') || str_contains($catName, 'computaci')) $priceRange = [2500000, 8000000];
        elseif (str_contains($catName, 'monitor')) $priceRange = [800000, 3000000];
        elseif (str_contains($catName, 'juego')) $priceRange = [150000, 350000];
        elseif (str_contains($catName, 'consola')) $priceRange = [1800000, 3500000];
        elseif (str_contains($catName, 'smartphone')) $priceRange = [900000, 4500000];

        return round(fake()->numberBetween(...$priceRange) / 1000) * 1000;
    }

    private function generateSpecificationsForCategory(Category $category): array
    {
        $catName = strtolower($category->name);
        $specs = [];

        $commonSpecs = [
            'Conectividad' => ['Wi-Fi 6E', 'Bluetooth 5.3', 'USB-C', 'HDMI 2.1'],
            'Garantía' => ['1 año con fabricante', '2 años extendida', '6 meses']
        ];

        if (str_contains($catName, 'laptop') || str_contains($catName, 'computaci')) {
            $specs = [
                'Procesador' => ['Intel Core i9-13900K', 'AMD Ryzen 9 7950X', 'Intel Core i7-13700K'],
                'Tarjeta Gráfica' => ['NVIDIA GeForce RTX 4090', 'AMD Radeon RX 7900 XTX', 'NVIDIA GeForce RTX 4070 Ti'],
                'Memoria RAM' => ['32GB DDR5 6000MHz', '16GB DDR5 5200MHz', '64GB DDR5 5600MHz'],
                'Almacenamiento' => ['1TB NVMe SSD Gen4', '2TB NVMe SSD Gen4', '4TB SATA SSD'],
            ];
        } elseif (str_contains($catName, 'juego')) {
            $specs = [
                'Plataforma' => ['PlayStation 5', 'Xbox Series X/S', 'Nintendo Switch', 'PC'],
                'Género' => ['Acción/Aventura', 'RPG', 'Estrategia', 'Deportes', 'Shooter'],
                'Clasificación' => ['E (Everyone)', 'T (Teen)', 'M (Mature 17+)'],
            ];
        } elseif (str_contains($catName, 'audifono')) {
            $specs = [
                'Tipo' => ['Over-ear', 'In-ear', 'On-ear'],
                'Cancelación de Ruido' => ['Activa (ANC)', 'Pasiva', 'No aplica'],
                'Duración Batería' => ['20 horas', '30 horas con estuche', '8 horas'],
            ];
        } else {
             $specs = [
                'Dimensión' => ['15 x 10 x 5 cm', '25 x 18 x 12 cm'],
                'Peso' => ['250g', '1.2kg', '5kg'],
            ];
        }

        $finalSpecs = [];
        $allSpecs = array_merge($specs, $commonSpecs);
        foreach ($allSpecs as $key => $values) {
            $finalSpecs[$key] = fake()->randomElement($values);
        }
        return $finalSpecs;
    }

    private function generateLongDescription(string $name, array $specifications): string
    {
        $description = "<h3>Descubre el " . $name . "</h3><p>" . fake()->paragraph(4) . "</p>";
        $description .= "<h4>Características Principales:</h4><ul>";
        foreach ($specifications as $key => $value) {
            $description .= "<li><strong>" . $key . ":</strong> " . $value . "</li>";
        }
        $description .= "</ul><p>" . fake()->paragraph(3) . "</p>";
        return $description;
    }
    
    private function getSampleDeliveryInfo(): string
    {
        return fake()->randomElement([
            'Envío estándar gratuito (3-5 días hábiles). Opciones express disponibles.',
            'Procesamiento en 24h. Envío rápido por Servientrega (2-4 días hábiles).',
            '¡Recíbelo mañana! Pedidos antes de las 2 PM. Costo adicional.',
        ]);
    }

    private function getSampleReturnPolicy(): string
    {
        return fake()->randomElement([
            'Devoluciones hasta 30 días después de la compra. Producto en estado original.',
            '15 días para devolución o cambio. No se aceptan productos en oferta.',
            'Devoluciones gratuitas los primeros 10 días. El producto debe estar sin usar.',
        ]);
    }

    private function addImagesToProduct(Product $product): void
    {
        if (empty($this->sampleImages)) return;

        $mainImageDbPath = $this->processAndSaveImage(fake()->randomElement($this->sampleImages), $product);

        $galleryImageDbPaths = [];
        $numGalleryImages = rand(2, 5);
        for ($i=0; $i < $numGalleryImages; $i++) { 
             $dbPath = $this->processAndSaveImage(fake()->randomElement($this->sampleImages), $product);
             if ($dbPath) {
                 $galleryImageDbPaths[] = $dbPath;
             }
        }

        $product->main_image_path = $mainImageDbPath;
        $product->gallery_image_paths = array_unique($galleryImageDbPaths);
        $product->save();
    }

    private function processAndSaveImage(\SplFileInfo $imageFile, Product $product): ?string
    {
        $sourcePath = $imageFile->getRealPath();
        $newFileName = Str::slug($product->name) . '-' . uniqid() . '.webp';
        $destinationPath = $this->storagePath . '/' . $newFileName;

        try {
            $image = imagecreatefromstring(File::get($sourcePath));
            if ($image === false) return null;

            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            imagewebp($image, $destinationPath, 80);
            imagedestroy($image);
            
            return 'products/' . $newFileName;

        } catch (\Exception $e) {
            $this->command->warn("No se pudo procesar la imagen: {$sourcePath}. Error: " . $e->getMessage());
            return null;
        }
    }
}
