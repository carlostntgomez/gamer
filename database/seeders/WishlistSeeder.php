<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('wishlists')->truncate();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Ensure there are enough users and products
        if (User::count() === 0) {
            User::factory()->count(5)->create();
        }
        if (Product::count() === 0) {
            Product::factory()->count(5)->create();
        }

        $userIds = User::pluck('id');
        $productIds = Product::pluck('id');

        // Create some unique wishlists
        foreach ($userIds as $userId) {
            $numProducts = fake()->numberBetween(1, min(3, $productIds->count()));
            $productsToAdd = fake()->randomElements($productIds->toArray(), $numProducts);

            foreach ($productsToAdd as $productId) {
                Wishlist::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);
            }
        }
    }
}
