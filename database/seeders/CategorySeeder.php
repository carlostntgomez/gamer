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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting category seeder...');

        $this->clearImageDirectory();
        $this->truncateCategories();

        $sampleImages = $this->getSampleImages();
        if (empty($sampleImages)) {
            return;
        }

        $this->seedCategories($sampleImages);

        $this->command->info('Category seeder finished successfully.');
    }

    /**
     * Clear the category image directory.
     */
    private function clearImageDirectory(): void
    {
        $this->command->info('Clearing and recreating the category images directory...');
        $directory = 'categories';
        if (Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->deleteDirectory($directory);
        }
        Storage::disk('public')->makeDirectory($directory);
    }

    /**
     * Truncate the categories table.
     */
    private function truncateCategories(): void
    {
        $this->command->info('Deleting all existing categories...');
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Get the sample images from the public directory.
     *
     * @return array
     */
    private function getSampleImages(): array
    {
        $sampleImagesPath = public_path('imagenes de muestra/categories');

        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->error('No sample images found in: ' . $sampleImagesPath);
            $this->command->error('Seeder cannot continue without images. Please add images to that path.');
            return [];
        }

        $this->command->info(count(File::files($sampleImagesPath)) . ' sample images found.');
        return File::files($sampleImagesPath);
    }

    /**
     * Seed the categories into the database.
     *
     * @param array $sampleImages
     */
    private function seedCategories(array $sampleImages): void
    {
        $this->command->info('Creating categories and assigning images...');
        $categories = $this->getCategoryData();
        $this->createCategoryHierarchy($categories, null, $sampleImages);
        $this->command->info('Categories and associated images created successfully.');
    }

    /**
     * Get the category data structure.
     *
     * @return array
     */
    private function getCategoryData(): array
    {
        return [
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
    }

    /**
     * Create the category hierarchy recursively.
     *
     * @param array $categories
     * @param int|null $parentId
     * @param array $sampleImages
     */
    private function createCategoryHierarchy(array $categories, ?int $parentId, array $sampleImages): void
    {
        foreach ($categories as $categoryData) {
            $imagePath = $this->processAndStoreImage($categoryData['name'], $sampleImages);

            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'parent_id' => $parentId,
                'image_path' => $imagePath,
            ]);

            if (!empty($categoryData['children'])) {
                $this->createCategoryHierarchy($categoryData['children'], $category->id, $sampleImages);
            }
        }
    }

    /**
     * Process and store an image for a given category.
     *
     * @param string $categoryName
     * @param array $sampleImages
     * @return string|null
     */
    private function processAndStoreImage(string $categoryName, array $sampleImages): ?string
    {
        if (empty($sampleImages)) {
            return null;
        }

        $randomImage = $sampleImages[array_rand($sampleImages)];
        $sourcePath = $randomImage->getRealPath();
        $slug = Str::slug($categoryName);
        $newFileName = $slug . '-' . uniqid() . '.webp';
        $destinationPath = storage_path('app/public/categories/' . $newFileName);

        try {
            $this->convertImageToWebp($sourcePath, $destinationPath);
            $this->command->line("  - Image '{$newFileName}' assigned to category '{$categoryName}'.");
            return 'categories/' . $newFileName;
        } catch (\Exception $e) {
            $this->command->error("  - Failed to process image for category '{$categoryName}': " . $e->getMessage());
            return null;
        }
    }

    /**
     * Convert an image to WebP format.
     *
     * @param string $sourcePath
     * @param string $destinationPath
     */
    private function convertImageToWebp(string $sourcePath, string $destinationPath): void
    {
        $imageType = @exif_imagetype($sourcePath);
        $image = null;

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($sourcePath);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_WEBP:
                File::copy($sourcePath, $destinationPath);
                return; // Already a WebP file
        }

        if ($image !== null) {
            imagewebp($image, $destinationPath, 80);
            imagedestroy($image);
        } else {
            // If the image type is not supported, just copy the file
            File::copy($sourcePath, $destinationPath);
        }
    }
}
