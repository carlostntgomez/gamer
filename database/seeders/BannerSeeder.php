<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->command->info('Starting Banner Seeder...');

        $storagePath = storage_path('app/public/banners');
        $this->clearDirectory($storagePath);

        $this->command->warn('Deleting all existing banners from the database...');
        Banner::query()->delete();

        $sampleImagesPath = public_path('imagenes de muestra/banners');
        if (!File::exists($sampleImagesPath) || count(File::files($sampleImagesPath)) === 0) {
            $this->command->warn('! Sample images directory not found or is empty at "public/imagenes de muestra/banners".');
            $this->command->info('Creating 5 banners without images as a fallback.');
            Banner::factory()->count(5)->create();
            $this->command->info('Banner seeder finished.');
            return;
        }

        $sampleImages = File::files($sampleImagesPath);
        $this->command->info('Creating 5 banners and assigning random images (converted to WebP)...');

        Banner::factory()->count(5)->create()->each(function (Banner $banner) use ($sampleImages, $storagePath) {
            $randomImageFile = $sampleImages[array_rand($sampleImages)];
            $sourcePath = $randomImageFile->getRealPath();

            // Use exif_imagetype to determine the real image type
            $imageType = @exif_imagetype($sourcePath);

            $newFileName = Str::slug($banner->name) . '-' . uniqid() . '.webp';
            $destinationPath = $storagePath . '/' . $newFileName;

            $image = null;
            $processed = false;

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
                    $this->command->line("  - Image '{$randomImageFile->getFilename()}' (already webp) assigned to banner '{$banner->name}'.");
                    $processed = true;
                    break;
                default:
                    // Try to get extension for error message if imagetype fails
                    $sourceExtension = strtolower($randomImageFile->getExtension());
                    $this->command->error("  - Unsupported or corrupt image type '{$sourceExtension}' for '{$randomImageFile->getFilename()}'. Banner '{$banner->name}' will have no image.");
                    return; // Continue to the next banner
            }

            if ($image !== null) {
                imagewebp($image, $destinationPath, 80); // 80% quality
                imagedestroy($image);
                $processed = true;
                $this->command->line("  - Image '{$randomImageFile->getFilename()}' converted to webp and assigned to banner '{$banner->name}'.");
            }

            if ($processed) {
                $banner->image_path = 'banners/' . $newFileName;
                $banner->save();
            }
        });

        $this->command->info('Banner seeder finished successfully.');
    }

    private function clearDirectory(string $path): void
    {
        if (File::isDirectory($path)) {
            $this->command->info('Cleaning and recreating the banner images directory...');
            File::deleteDirectory($path);
        }
        File::makeDirectory($path, 0755, true, true);
    }
}
