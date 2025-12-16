<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all product and user IDs
        $productIds = Product::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        if (empty($productIds) || empty($userIds)) {
            $this->command->info('Skipping ReviewSeeder: No products or users found.');
            return;
        }

        // Create 10 reviews
        Review::factory()->count(10)->make()->each(function ($review) use ($productIds, $userIds) {
            // Assign a random product and user to each review
            $review->product_id = $productIds[array_rand($productIds)];
            $review->user_id = $userIds[array_rand($userIds)];
            $review->save();
        });
    }
}
