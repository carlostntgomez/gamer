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

        $mainImages = $this->getSampleImages('main');
        $bannerImages = $this->getSampleImages('banner');

        if (empty($mainImages)) {
            $this->command->error('Main images not found, seeder cannot continue.');
            return;
        }

        $this->seedCategories($mainImages, $bannerImages);

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
     * @param string $type 'main' or 'banner'
     * @return array
     */
    private function getSampleImages(string $type): array
    {
        $sampleImagesPath = public_path('imagenes de muestra/categories/' . $type);

        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->error('No sample ' . $type . ' images found in: ' . $sampleImagesPath);
            return [];
        }

        $this->command->info(count(File::files($sampleImagesPath)) . ' sample ' . $type . ' images found.');
        return File::files($sampleImagesPath);
    }

    /**
     * Seed the categories into the database.
     *
     * @param array $mainImages
     * @param array $bannerImages
     */
    private function seedCategories(array $mainImages, array $bannerImages): void
    {
        $this->command->info('Creating categories, assigning images, and generating SEO content...');
        $categories = $this->getCategoryData();
        $this->createCategoryHierarchy($categories, null, $mainImages, $bannerImages);
        $this->command->info('Categories and associated data created successfully.');
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
     * @param array $mainImages
     * @param array $bannerImages
     * @param array $parentNames
     */
    private function createCategoryHierarchy(array $categories, ?int $parentId, array $mainImages, array $bannerImages, array $parentNames = []): void
    {
        foreach ($categories as $categoryData) {
            $categoryName = $categoryData['name'];

            $imagePath = $this->processAndStoreImage($categoryName, $mainImages, 'main');
            $bannerPath = $this->processAndStoreImage($categoryName . ' banner', $bannerImages, 'banner');

            // Generate SEO Content
            $seoTitle = $this->generateSeoTitle($categoryName, $parentNames);
            $seoDescription = $this->generateSeoDescription($categoryName, $parentNames);
            $seoKeywords = $this->generateSeoKeywords($categoryName, $parentNames);

            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'parent_id' => $parentId,
                'image_path' => $imagePath,
                'banner_path' => $bannerPath,
                'seo_title' => $seoTitle,
                'seo_description' => $seoDescription,
                'seo_keywords' => $seoKeywords,
            ]);

            $this->command->line("  - SEO content generated for category '{$categoryName}'.");

            if (!empty($categoryData['children'])) {
                $newParentNames = array_merge($parentNames, [$categoryName]);
                $this->createCategoryHierarchy($categoryData['children'], $category->id, $mainImages, $bannerImages, $newParentNames);
            }
        }
    }

    /**
     * Generate an optimized SEO title.
     *
     * @param string $categoryName
     * @param array $parentNames
     * @return string
     */
    private function generateSeoTitle(string $categoryName, array $parentNames): string
    {
        $storeName = config('app.name', 'Tu Tienda Online');
        if (!empty($parentNames)) {
            $parentChain = implode(' > ', $parentNames);
            return "Compra {$categoryName} en {$parentChain} | {$storeName}";
        }
        return "Compra lo mejor en {$categoryName} | {$storeName}";
    }

    /**
     * Generate an attractive SEO description.
     *
     * @param string $categoryName
     * @param array $parentNames
     * @return string
     */
    private function generateSeoDescription(string $categoryName, array $parentNames): string
    {
        $storeName = config('app.name', 'Tu Tienda Online');
        $maxLength = 160;
        $ellipsis = '...';
        $truncatedLength = $maxLength - mb_strlen($ellipsis);

        if (!empty($parentNames)) {
            $lastParent = end($parentNames);
            $description = "Descubre la mejor selección de {$categoryName} en la sección de {$lastParent}. Ofertas exclusivas y envío rápido en {$storeName}. ¡Explora ahora!";
        } else {
            $description = "Encuentra la mejor selección de {$categoryName} en {$storeName}. Calidad, variedad y precios increíbles. ¡Compra ahora y no te pierdas nuestras ofertas!";
        }

        if (mb_strlen($description) > $maxLength) {
            $description = mb_substr($description, 0, $truncatedLength);
            // Ensure not to break words
            $lastSpace = mb_strrpos($description, ' ');
            if ($lastSpace !== false) {
                $description = mb_substr($description, 0, $lastSpace);
            }
            $description .= $ellipsis;
        }

        return $description;
    }

    /**
     * Generate relevant SEO keywords.
     *
     * @param string $categoryName
     * @param array $parentNames
     * @return array
     */
    private function generateSeoKeywords(string $categoryName, array $parentNames): array
    {
        $keywords = array_merge([$categoryName], $parentNames);
        $keywords = array_map('strtolower', $keywords);
        $additionalKeywords = ['comprar', 'ofertas', 'online', 'tienda', 'mejores precios'];
        return array_values(array_unique(array_merge($keywords, $additionalKeywords)));
    }

    /**
     * Process and store an image for a given category.
     *
     * @param string $categoryName
     * @param array $sampleImages
     * @param string $type
     * @return string|null
     */
    private function processAndStoreImage(string $categoryName, array $sampleImages, string $type): ?string
    {
        if (empty($sampleImages)) {
            if ($type === 'banner') return null; // Banners are optional
            $this->command->error('No images available for processing for type: ' . $type);
            return null;
        }

        $randomImage = $sampleImages[array_rand($sampleImages)];
        $sourcePath = $randomImage->getRealPath();
        $slug = Str::slug($categoryName);
        $newFileName = $slug . '-' . uniqid() . '.webp';
        $destinationPath = storage_path('app/public/categories/' . $newFileName);

        try {
            $this->convertImageToWebp($sourcePath, $destinationPath);
            $this->command->line("  - " . ucfirst($type) . " image '{$newFileName}' assigned to category '{$categoryName}'.");
            return 'categories/' . $newFileName;
        } catch (\Exception $e) {
            $this->command->error("  - Failed to process " . $type . " image for category '{$categoryName}': " . $e->getMessage());
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