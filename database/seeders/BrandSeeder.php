<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Brand seeder...');

        $storagePath = storage_path('app/public/brands');
        $sampleImagesPath = public_path('imagenes de muestra/brand-logo');

        // 1. Cleanup operations
        $this->command->comment('Performing cleanup...');
        Schema::disableForeignKeyConstraints();
        Brand::truncate();
        Schema::enableForeignKeyConstraints();

        if (File::isDirectory($storagePath)) {
            File::deleteDirectory($storagePath);
        }
        File::makeDirectory($storagePath, 0755, true);
        $this->command->comment('Cleanup complete.');

        // 2. Define Brand Data with specific logos
        $brandsData = [
            ['name' => 'Sony', 'file' => 'home8-brand-logo1.png'],
            ['name' => 'Microsoft', 'file' => 'home8-brand-logo2.png'],
            ['name' => 'Nintendo', 'file' => 'home8-brand-logo3.png'],
            ['name' => 'Valve', 'file' => 'home8-brand-logo4.png'],
            ['name' => 'Logitech', 'file' => 'home8-brand-logo5.png'],
            ['name' => 'Razer', 'file' => 'home8-brand-logo6.png'],
        ];
        
        $moreBrands = [
            'Corsair', 'HyperX', 'Alienware', 'HP Omen', 'Samsung', 'Apple',
            'Google', 'OnePlus', 'Xiaomi'
        ];

        // 3. Verify sample images directory
        if (!File::exists($sampleImagesPath)) {
            $this->command->error('Sample images directory not found: ' . $sampleImagesPath);
            $this->command->info('Creating brands without logos.');
            foreach (array_merge($brandsData, array_map(fn($name) => ['name' => $name, 'file' => null], $moreBrands)) as $brandData) {
                Brand::create(['name' => $brandData['name']]);
            }
            return;
        }

        // 4. Create Brands and Process Logos
        $this->command->info('Creating brands and processing logos...');
        foreach ($brandsData as $brandData) {
            $logoPath = $this->copyLogo($sampleImagesPath, $storagePath, $brandData['file'], $brandData['name']);
            
            Brand::create([
                'name' => $brandData['name'],
                'logo_path' => $logoPath,
            ]);
        }
        
        // Create additional brands without logos
        foreach ($moreBrands as $brandName) {
            Brand::create(['name' => $brandName]);
            $this->command->line("Created brand '{$brandName}' without a logo.");
        }

        $this->command->info('Brand seeding completed successfully.');
    }

    /**
     * Copies a logo image.
     */
    private function copyLogo(string $samplePath, string $storagePath, ?string $fileName, string $brandName): ?string
    {
        if (!$fileName) {
            return null;
        }

        $sourceFile = $samplePath . '/' . $fileName;
        if (!File::exists($sourceFile)) {
            $this->command->warn("  - Logo file not found for '{$brandName}': {$fileName}");
            return null;
        }

        $newFileName = Str::slug($brandName) . '-' . uniqid() . '.png';
        $destinationFile = $storagePath . '/' . $newFileName;
        
        try {
            File::copy($sourceFile, $destinationFile);
            $this->command->line("  - Copied logo for '{$brandName}'.");
            return 'brands/' . $newFileName;
        } catch (\Exception $e) {
            $this->command->error("  - Failed to copy logo for '{$brandName}': " . $e->getMessage());
            return null;
        }
    }
}
