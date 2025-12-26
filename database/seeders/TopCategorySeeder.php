<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\TopCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Top Category Seeder with WebP conversion...');

        // 1. Check for GD library
        if (!extension_loaded('gd')) {
            $this->command->error('The GD library extension is required, but it is not enabled.');
            return;
        }

        // 2. Cleanup
        TopCategory::query()->truncate();
        $storagePath = storage_path('app/public/top-categories');
        if (File::isDirectory($storagePath)) {
            File::deleteDirectory($storagePath);
        }
        File::makeDirectory($storagePath, 0755, true, true);
        $this->command->info('Cleaned up top_categories table and directory.');

        // 3. Get sample images
        $sampleImagesPath = public_path('imagenes de muestra/top-categories');
        if (!File::exists($sampleImagesPath)) {
            $this->command->error('Sample images directory not found: ' . $sampleImagesPath);
            return;
        }
        $sampleImages = File::files($sampleImagesPath);
        if (empty($sampleImages)) {
            $this->command->warn('No sample images found in ' . $sampleImagesPath);
        }

        // 4. Get categories
        $categories = Category::query()->take(count($sampleImages))->get();

        // 5. Create TopCategory entries with images
        foreach ($categories as $index => $category) {
            $imagePath = null;
            if (isset($sampleImages[$index])) {
                $sampleImage = $sampleImages[$index];
                $sourcePath = $sampleImage->getPathname();
                $originalFileName = $sampleImage->getFilename();

                $newWebpFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '-' . uniqid() . '.webp';
                $destinationPath = $storagePath . '/' . $newWebpFileName;

                try {
                    $image = @imagecreatefromstring(File::get($sourcePath));

                    if ($image !== false) {
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);

                        imagewebp($image, $destinationPath, 80); // 80 is quality
                        imagedestroy($image);

                        $imagePath = 'top-categories/' . $newWebpFileName;
                        $this->command->info("Converted image for '{$category->name}' -> {$imagePath}");
                    } else {
                        $this->command->warn("Could not create image from string for '{$category->name}'. The file might be corrupt or an unsupported format: " . $originalFileName);
                    }
                } catch (\Exception $e) {
                    $this->command->error("Failed to process image for '{$category->name}': " . $e->getMessage());
                }
            }

            TopCategory::create([
                'category_id' => $category->id,
                'sort_order' => $index + 1,
                'image' => $imagePath,
            ]);
        }

        $this->command->info('Top Category Seeder finished successfully.');
    }
}
