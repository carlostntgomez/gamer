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

        // Solo crear el usuario administrador si no existe
        if (!User::where('email', 'admin@tecnnygames.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@tecnnygames.com',
                'password' => Hash::make('password'),
            ]);
        }

        $this->call([
            CategorySeeder::class,
            TopCategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            OfferSeeder::class, // <-- Added here
            PostSeeder::class,
            OrderSeeder::class,
            TicketSeeder::class,
            DiscountSeeder::class,
            BannerSeeder::class,
            WishlistSeeder::class,
            TestimonialSeeder::class,
            ReviewSeeder::class,
            MainSliderSeeder::class,
        ]);
    }
}
