<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Categorías con procesamiento de imágenes basado en Observer ---');

        $this->clearDirectories();
        $this->truncateCategories();

        $mainImages = $this->getSampleImages('main');
        $bannerImages = $this->getSampleImages('banner');

        if (empty($mainImages)) {
            $this->command->error('No se encontraron imágenes de muestra principales, el seeder no puede continuar.');
            return;
        }

        $this->seedCategories($mainImages, $bannerImages);

        $this->command->info('Seeder de Categorías finalizado con éxito. El CategoryObserver ha procesado todas las imágenes.');
        $this->command->info('--- Seeder de Categorías finalizado ---');
    }

    private function clearDirectories(): void
    {
        $this->command->info('Limpiando y recreando directorios de imágenes...');
        $directories = ['categories', 'temp-uploads'];
        foreach ($directories as $directory) {
            if (Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->deleteDirectory($directory);
            }
            Storage::disk('public')->makeDirectory($directory);
            $this->command->line("  - El directorio 'public/storage/{$directory}' está limpio y listo.");
        }
    }

    private function truncateCategories(): void
    {
        $this->command->info('Eliminando todas las categorías existentes...');
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();
    }

    private function getSampleImages(string $type): array
    {
        $sampleImagesPath = public_path('imagenes de muestra/categories/' . $type);
        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->warn('No se encontraron imágenes de muestra de tipo ' . $type . ' en: ' . $sampleImagesPath);
            return [];
        }
        $this->command->info(count(File::files($sampleImagesPath)) . ' imágenes de muestra de tipo ' . $type . ' encontradas.');
        return File::files($sampleImagesPath);
    }

    private function seedCategories(array $mainImages, array $bannerImages): void
    {
        $this->command->info('Creando categorías y activando el procesamiento de imágenes a través del CategoryObserver...');
        $categories = $this->getCategoryData();
        $this->createCategoryHierarchy($categories, null, $mainImages, $bannerImages);
    }

    private function getCategoryData(): array
    {
        return [
            ['name' => 'Videojuegos', 'children' => [
                ['name' => 'Juegos', 'children' => [
                    ['name' => 'PlayStation 5'],
                    ['name' => 'Xbox Series X'],
                    ['name' => 'Nintendo Switch'],
                    ['name' => 'PC'],
                ]],
                ['name' => 'Consolas', 'children' => [
                    ['name' => 'PlayStation'],
                    ['name' => 'Xbox'],
                    ['name' => 'Nintendo'],
                ]],
                ['name' => 'Juegos Retro', 'children' => [
                    ['name' => 'Super Nintendo (SNES)'],
                    ['name' => 'Sega Genesis (Mega Drive)'],
                    ['name' => 'Nintendo 64 (N64)'],
                    ['name' => 'PlayStation 1 (PSX)'],
                ]],
                ['name' => 'Consolas Retro', 'children' => [
                    ['name' => 'Consolas Super Nintendo'],
                    ['name' => 'Consolas Nintendo 64'],
                    ['name' => 'Consolas Sega Genesis'],
                ]],
                ['name' => 'Accesorios Gamer'],
            ]],
            ['name' => 'Celulares y Wearables', 'children' => [
                ['name' => 'Smartphones'],
                ['name' => 'Smartwatches'],
                ['name' => 'Audífonos Inalámbricos'],
            ]],
            ['name' => 'Computación', 'children' => [
                ['name' => 'Laptops'],
                ['name' => 'Monitores'],
                ['name' => 'Componentes de PC'],
            ]],
        ];
    }

    private function createCategoryHierarchy(array $categories, ?int $parentId, array $mainImages, array $bannerImages, array $parentNames = []): void
    {
        foreach ($categories as $categoryData) {
            $categoryName = $categoryData['name'];
            
            $this->command->line("Procesando categoría: {$categoryName}");

            $tempImagePath = $this->simulateUpload($mainImages, $categoryName);
            $tempBannerPath = $this->simulateUpload($bannerImages, $categoryName . '-banner');

            $seoTitle = $this->generateSeoTitle($categoryName, $parentNames);
            $seoDescription = $this->generateSeoDescription($categoryName, $parentNames);
            $seoKeywords = $this->generateSeoKeywords($categoryName, $parentNames);

            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'parent_id' => $parentId,
                'image_path' => $tempImagePath,
                'banner_path' => $tempBannerPath,
                'seo_title' => $seoTitle,
                'seo_description' => $seoDescription,
                'seo_keywords' => $seoKeywords,
            ]);

            if (!empty($categoryData['children'])) {
                $newParentNames = array_merge($parentNames, [$categoryName]);
                $this->createCategoryHierarchy($categoryData['children'], $category->id, $mainImages, $bannerImages, $newParentNames);
            }
        }
    }
    
    private function simulateUpload(array $sampleImages, string $contextName): ?string
    {
        if (empty($sampleImages)) {
            return null;
        }

        $sourceFile = $sampleImages[array_rand($sampleImages)];
        $sourcePath = $sourceFile->getRealPath();

        $tempDir = 'temp-uploads';
        $tempFileName = Str::slug($contextName) . '-' . Str::random(8) . '.' . $sourceFile->getExtension();
        $tempPath = $tempDir . '/' . $tempFileName;

        Storage::disk('public')->put($tempPath, File::get($sourcePath));
        
        $this->command->line("  - Subida simulada: '{$sourceFile->getFilename()}' copiado a '{$tempPath}'");

        return $tempPath;
    }

    private function generateSeoTitle(string $categoryName, array $parentNames): string
    {
        $storeName = config('app.name', 'TecnnyGames');
        if (!empty($parentNames)) {
            $parentChain = implode(' > ', $parentNames);
            return "Compra {$categoryName} en {$parentChain} | {$storeName}";
        }
        return "Compra lo mejor en {$categoryName} | {$storeName}";
    }

    private function generateSeoDescription(string $categoryName, array $parentNames): string
    {
        $storeName = config('app.name', 'TecnnyGames');
        $description = !empty($parentNames)
            ? "Descubre la mejor selección de {$categoryName} en la sección de {".end($parentNames)."}. Ofertas exclusivas y envío rápido en {$storeName}. ¡Explora ahora!"
            : "Encuentra la mejor selección de {$categoryName} en {$storeName}. Calidad, variedad y precios increíbles. ¡Compra ahora y no te pierdas nuestras ofertas!";

        if (mb_strlen($description) > 160) {
            $description = mb_substr($description, 0, 157) . '...';
        }
        return $description;
    }

    private function generateSeoKeywords(string $categoryName, array $parentNames): array
    {
        $keywords = array_map('strtolower', array_merge([$categoryName], $parentNames));
        return array_values(array_unique(array_merge($keywords, ['comprar', 'ofertas', 'online', 'tienda', 'mejores precios'])));
    }
}
