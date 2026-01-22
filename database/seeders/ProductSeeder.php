<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Enums\ProductType;
use App\Enums\ProductCondition;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Productos Realistas (Versión Corregida) ---');
        $this->cleanup();

        $sampleImageFiles = $this->getSampleImages();
        $categories = Category::all()->keyBy('slug');
        $brands = Brand::all()->keyBy('name');

        if ($sampleImageFiles->isEmpty() || $categories->isEmpty() || $brands->isEmpty()) {
            $this->command->error('CRÍTICO: No se encontraron imágenes, categorías o marcas. Abortando seeder.');
            return;
        }

        $productsData = $this->getProductsData();

        foreach ($productsData as $data) {
            $this->createProduct($data, $categories, $brands, $sampleImageFiles);
        }

        $this->command->info('--- Seeder de Productos finalizado con éxito ---');
    }

    private function cleanup(): void
    {
        $this->command->comment('Limpiando datos y directorios antiguos...');
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        DB::table('category_product')->truncate();
        Product::truncate();
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        Storage::disk('public')->deleteDirectory('products');
        Storage::disk('public')->makeDirectory('products');
        Storage::disk('public')->makeDirectory('temp-uploads');
    }

    private function getSampleImages(): \Illuminate\Support\Collection
    {
        $path = public_path('imagenes de muestra/products');
        return File::isDirectory($path) ? collect(File::files($path)) : collect();
    }

    private function getProductsData(): array
    {
        // Valores corregidos según la definición de los Enums
        return [
            // Videojuegos Modernos
            ['name' => 'God of War Ragnarök', 'cat' => 'playstation-5', 'brand' => 'Sony', 'price' => 280000, 'cond' => 'nuevo', 'type' => 'videojuego'],
            ['name' => 'Starfield', 'cat' => 'xbox-series-x', 'brand' => 'Microsoft', 'price' => 300000, 'cond' => 'nuevo', 'type' => 'videojuego'],
            ['name' => 'The Legend of Zelda: Tears of the Kingdom', 'cat' => 'nintendo-switch', 'brand' => 'Nintendo', 'price' => 290000, 'cond' => 'nuevo', 'type' => 'videojuego'],
            ['name' => "Baldur's Gate 3", 'cat' => 'pc', 'brand' => 'Valve', 'price' => 250000, 'cond' => 'nuevo', 'type' => 'videojuego'],
            ['name' => 'Cyberpunk 2077: Phantom Liberty', 'cat' => 'pc', 'brand' => 'Valve', 'price' => 150000, 'cond' => 'nuevo', 'type' => 'videojuego'],

            // Consolas Modernas
            ['name' => 'Consola PlayStation 5 Edición Disco', 'cat' => 'playstation', 'brand' => 'Sony', 'price' => 2800000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'Consola Xbox Series X 1TB', 'cat' => 'xbox', 'brand' => 'Microsoft', 'price' => 2700000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'Consola Nintendo Switch OLED', 'cat' => 'nintendo', 'brand' => 'Nintendo', 'price' => 1600000, 'cond' => 'nuevo', 'type' => 'gadget'],

            // Juegos Retro
            ['name' => 'Super Metroid - Cartucho SNES', 'cat' => 'super-nintendo-snes', 'brand' => 'Nintendo', 'price' => 350000, 'cond' => 'usado', 'type' => 'videojuego'],
            ['name' => 'Sonic the Hedgehog 2 - Cartucho Genesis', 'cat' => 'sega-genesis-mega-drive', 'brand' => 'Sega', 'price' => 200000, 'cond' => 'usado', 'type' => 'videojuego'],
            ['name' => 'The Legend of Zelda: Ocarina of Time - Cartucho N64', 'cat' => 'nintendo-64-n64', 'brand' => 'Nintendo', 'price' => 400000, 'cond' => 'usado', 'type' => 'videojuego'],
            ['name' => 'Final Fantasy VII - Discos PSX', 'cat' => 'playstation-1-psx', 'brand' => 'Sony', 'price' => 250000, 'cond' => 'usado', 'type' => 'videojuego'],
            ['name' => 'Chrono Trigger - Cartucho SNES', 'cat' => 'super-nintendo-snes', 'brand' => 'Nintendo', 'price' => 600000, 'cond' => 'usado', 'type' => 'videojuego'], // Cambiado de refurbished a usado

            // Consolas Retro
            ['name' => 'Consola Super Nintendo (SNES) Classic Edition', 'cat' => 'consolas-super-nintendo', 'brand' => 'Nintendo', 'price' => 800000, 'cond' => 'usado', 'type' => 'gadget'], // Cambiado de refurbished a usado
            ['name' => 'Consola Sega Genesis Mini', 'cat' => 'consolas-sega-genesis', 'brand' => 'Sega', 'price' => 750000, 'cond' => 'usado', 'type' => 'gadget'], // Cambiado de refurbished a usado

            // Celulares y Wearables
            ['name' => 'Samsung Galaxy S24 Ultra', 'cat' => 'smartphones', 'brand' => 'Samsung', 'price' => 5500000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'iPhone 15 Pro Max', 'cat' => 'smartphones', 'brand' => 'Apple', 'price' => 6200000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'Xiaomi Redmi Note 13 Pro', 'cat' => 'smartphones', 'brand' => 'Xiaomi', 'price' => 1800000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'Google Pixel 8 Pro', 'cat' => 'smartphones', 'brand' => 'Google', 'price' => 4800000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'Apple Watch Series 9', 'cat' => 'smartwatches', 'brand' => 'Apple', 'price' => 2100000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'Samsung Galaxy Watch 6', 'cat' => 'smartwatches', 'brand' => 'Samsung', 'price' => 1500000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'Sony WH-1000XM5 Audífonos Inalámbricos', 'cat' => 'audifonos-inalambricos', 'brand' => 'Sony', 'price' => 1800000, 'cond' => 'nuevo', 'type' => 'gadget'],

            // Accesorios y Componentes
            ['name' => 'Mouse Gamer Logitech G Pro X Superlight', 'cat' => 'accesorios-gamer', 'brand' => 'Logitech', 'price' => 650000, 'cond' => 'nuevo', 'type' => 'accesorio'],
            ['name' => 'Teclado Mecánico Razer Huntsman V2', 'cat' => 'accesorios-gamer', 'brand' => 'Razer', 'price' => 900000, 'cond' => 'nuevo', 'type' => 'accesorio'],
            ['name' => 'Monitor Gamer Alienware 27" QD-OLED', 'cat' => 'monitores', 'brand' => 'Sony', 'price' => 3500000, 'cond' => 'nuevo', 'type' => 'gadget'],
            ['name' => 'Tarjeta Gráfica NVIDIA GeForce RTX 4080', 'cat' => 'componentes-de-pc', 'brand' => 'Nvidia', 'price' => 5200000, 'cond' => 'nuevo', 'type' => 'accesorio'],
            ['name' => 'Procesador AMD Ryzen 9 7950X', 'cat' => 'componentes-de-pc', 'brand' => 'AMD', 'price' => 2600000, 'cond' => 'nuevo', 'type' => 'accesorio'],
            ['name' => 'Diadema Gamer Corsair HS80 RGB Wireless', 'cat' => 'accesorios-gamer', 'brand' => 'Corsair', 'price' => 750000, 'cond' => 'nuevo', 'type' => 'accesorio'],
            ['name' => 'Control DualSense Edge para PS5', 'cat' => 'accesorios-gamer', 'brand' => 'Sony', 'price' => 950000, 'cond' => 'nuevo', 'type' => 'accesorio'],
            ['name' => 'SSD NVMe Samsung 990 Pro 2TB', 'cat' => 'componentes-de-pc', 'brand' => 'Samsung', 'price' => 900000, 'cond' => 'nuevo', 'type' => 'accesorio'],
        ];
    }
    
    private function createProduct(array $data, $categories, $brands, $sampleImageFiles): void
    {
        $category = $categories->get($data['cat']);
        $brand = $brands->get($data['brand']);
        if (!$category || !$brand) {
            $this->command->warn("Saltando producto '{$data['name']}': categoría o marca no encontrada.");
            return;
        }

        try {
            $condition = ProductCondition::from($data['cond']);
            $type = ProductType::from($data['type']);
        } catch (\ValueError $e) {
            $this->command->error("Error fatal en Enum para '{$data['name']}': " . $e->getMessage());
            return;
        }

        $onSale = rand(0, 3) === 0;
        $salePrice = $onSale ? round($data['price'] * (1 - rand(10, 30) / 100), -3) : null;

        $product = Product::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'short_description' => "La mejor opción para {$type->value}. Calidad {$brand->name} garantizada.",
            'long_description' => "<h3>Descripción de {$data['name']}</h3><p>Disfruta de la experiencia que solo <strong>{$brand->name}</strong> puede ofrecer.</p>",
            'price' => $data['price'],
            'sale_price' => $salePrice,
            'specifications' => $this->generateSpecifications($type, $brand->name, $category->name, $condition->getLabel()),
            'stock_quantity' => rand(5, 100),
            'sku' => 'SKU-' . Str::upper(Str::random(8)),
            'is_visible' => true,
            'is_featured' => rand(0, 4) === 0,
            'is_new' => $condition === ProductCondition::New,
            'type' => $type,
            'condition' => $condition,
            'brand_id' => $brand->id,
            'main_image_path' => $this->stageImage($sampleImageFiles->random()),
            'gallery_image_paths' => $this->stageImage($sampleImageFiles->random(rand(2, 4))->all()),
            'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
            'seo_title' => "Comprar {$data['name']} | {$brand->name}",
            'seo_description' => "La mejor oferta en {$data['name']}. Compra online en nuestra tienda.",
            'seo_keywords' => [$type->value, $category->name, $brand->name, 'comprar', 'oferta'],
        ]);

        $product->categories()->attach($category->id);
        $this->command->line("Creado: {$product->name} en '{$category->name}'" . ($onSale ? " (¡EN OFERTA!)" : ""));
    }

    private function stageImage($files): array|string
    {
        $tempDir = 'temp-uploads';
        $stage = function ($file) use ($tempDir) {
            $tempFileName = Str::random(20) . '.' . $file->getExtension();
            $tempPath = $tempDir . '/' . $tempFileName;
            Storage::disk('public')->put($tempPath, file_get_contents($file->getPathname()));
            return $tempPath;
        };
        return is_array($files) ? array_map($stage, $files) : $stage($files);
    }

    private function generateSpecifications(ProductType $type, string $brand, string $category, string $condition): array
    {
        $specs = [
            ['key' => 'Marca', 'value' => $brand],
            ['key' => 'Categoría', 'value' => $category],
            ['key' => 'Condición', 'value' => $condition],
            ['key' => 'Garantía', 'value' => '12 meses'],
        ];
        $extra = match ($type) {
            ProductType::Videogame => [['key' => 'Formato', 'value' => 'Físico'], ['key' => 'Género', 'value' => 'Aventura']],
            ProductType::Gadget => [['key' => 'Conectividad', 'value' => 'Bluetooth 5.3'], ['key' => 'Puertos', 'value' => 'USB-C']],
            ProductType::Accessory => [['key' => 'Compatibilidad', 'value' => 'Multiplataforma']],
        };
        return array_merge($specs, $extra);
    }
}
