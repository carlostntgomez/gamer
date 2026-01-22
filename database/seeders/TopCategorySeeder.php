<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\TopCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Top Category Seeder...');

        // 1. Cleanup
        TopCategory::query()->truncate();
        
        // The observer doesn't manage files anymore, but it's good practice to ensure the directory exists.
        // We no longer clean it up because it's not the owner of the images.
        if (!Storage::disk('public')->exists('top-categories')) {
            Storage::disk('public')->makeDirectory('top-categories');
        }

        $this->command->info('Cleaned up top_categories table.');

        // 2. Get the first 6 categories that have an image
        $categories = Category::query()->whereNotNull('image_path')->take(6)->get();

        if ($categories->count() < 1) {
            $this->command->warn('Warning: No categories with images found. Cannot seed Top Categories.');
            return;
        }

        // 3. Create TopCategory entries
        // The TopCategoryObserver will automatically copy the category's image path.
        $this->command->info('Creating Top Categories... The observer will copy the image paths.');
        foreach ($categories as $index => $category) {
            TopCategory::create([
                'category_id' => $category->id,
                'sort_order' => $index + 1,
            ]);
        }

        $this->command->info('Top Category Seeder finished successfully. Created ' . $categories->count() . ' top categories.');
    }
}
