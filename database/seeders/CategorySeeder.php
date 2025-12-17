<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Limpiando y recreando el directorio de imágenes de categorías...');
        $this->clearDirectory(storage_path('app/public/categories'));

        $sampleImagesPath = public_path('imagenes de muestra');
        $sampleImages = File::files($sampleImagesPath);

        if (empty($sampleImages)) {
            $this->command->warn('No se encontraron imágenes de muestra. Las categorías se crearán sin imágenes.');
        }

        $this->command->info('Creando categorías y asignando imágenes...');

        $categories = [
            ['name' => 'Videojuegos', 'children' => [
                ['name' => 'Juegos', 'children' => [
                    ['name' => 'Juegos para PlayStation 5'],
                    ['name' => 'Juegos para Xbox Series X'],
                    ['name' => 'Juegos para Nintendo Switch'],
                ]],
                ['name' => 'Consolas', 'children' => [
                    ['name' => 'PlayStation'],
                    ['name' => 'Xbox'],
                    ['name' => 'Nintendo'],
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

        $this->createCategories($categories, null, $sampleImages);

        $this->command->info('Categorías creadas y con imágenes asociadas exitosamente.');
    }

    private function createCategories(array $categories, ?int $parentId, array $sampleImages): void
    {
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'parent_id' => $parentId,
            ]);

            if (!empty($sampleImages)) {
                $randomImage = $sampleImages[array_rand($sampleImages)];
                $this->addImageToCategory($category, $randomImage->getRealPath());
            }

            if (!empty($categoryData['children'])) {
                $this->createCategories($categoryData['children'], $category->id, $sampleImages);
            }
        }
    }

    private function addImageToCategory(Category $category, string $imagePath): void
    {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $fileName = $category->slug . '.' . $extension;

        try {
            $category->addMedia($imagePath)
                ->preservingOriginal()
                ->usingFileName($fileName)
                ->toMediaCollection('categories');
            
            $this->command->line("  - Imagen '{$fileName}' asignada a la categoría '{$category->name}'.");

        } catch (\Exception $e) {
            $this->command->error("  - No se pudo agregar la imagen a la categoría '{$category->name}': " . $e->getMessage());
        }
    }

    private function clearDirectory(string $path): void
    {
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        File::makeDirectory($path, 0755, true, true);
    }
}
