<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reducir a 5 usuarios de prueba
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@tecnnygames.com',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            PostSeeder::class,
            OrderSeeder::class,
            PageSeeder::class,
            TicketSeeder::class,
            DiscountSeeder::class,
            BannerSeeder::class,
            WishlistSeeder::class,
            TestimonialSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
