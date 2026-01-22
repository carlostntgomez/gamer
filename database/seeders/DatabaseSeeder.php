<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('======================================================================');
        $this->command->info('    Iniciando el proceso de siembra de la base de datos completa    ');
        $this->command->info('======================================================================');

        $this->call([
            // 1. Configuración Base y Esencial
            SettingsSeeder::class,

            // 2. Estructura del E-commerce
            CategorySeeder::class,
            TopCategorySeeder::class,
            BrandSeeder::class,
            ShippingZoneSeeder::class,

            // 3. Contenido del Blog
            AuthorSeeder::class,
            TagSeeder::class,
            PostSeeder::class,

            // 4. Contenido de la Página de Inicio (Homepage)
            MainSliderSeeder::class,
            BannerSeeder::class,
            OfferSeeder::class,

            // 5. Productos y Datos Relacionados
            ProductSeeder::class,
            DiscountSeeder::class,
            ReviewSeeder::class,

            // 6. Datos Específicos de Usuario
            OrderSeeder::class, // Depende de productos y usuarios

            // 7. Otros
            TestimonialSeeder::class,
        ]);

        $this->command->info('======================================================================');
        $this->command->info('     Siembra de la base de datos completada exitosamente     ');
        $this->command->info('======================================================================');
    }
}
