<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // --- Creación del Usuario Administrador ---
        $this->command->comment('Creando usuario administrador principal...');
        User::firstOrCreate(
            ['email' => 'admin@tecnny.com'],
            [
                'name' => 'Admin Tecnny',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('Usuario administrador: admin@tecnny.com | Contraseña: password');
        // --- Fin Creación ---

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
