<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // <--- AÑADIDO

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Iniciando el seeder de reseñas mejorado...');

        // 1. Limpieza inicial de la tabla de reseñas (de forma agnóstica a la BD)
        Schema::disableForeignKeyConstraints();
        Review::truncate();
        Schema::enableForeignKeyConstraints();
        $this->command->info('Tabla de reseñas limpiada.');

        // 2. Obtener todos los productos y usuarios
        $products = Product::all();
        $userIds = User::pluck('id')->all();

        if ($products->isEmpty() || empty($userIds)) {
            $this->command->error('No se puede ejecutar el ReviewSeeder. No se encontraron productos o usuarios.');
            return;
        }

        $this->command->info("Se encontraron {" . $products->count() . "} productos y " . count($userIds) . " usuarios. Generando 1-2 reseñas para cada producto.");

        // 3. Crear reseñas para cada producto con una barra de progreso
        $this->command->withProgressBar($products, function ($product) use ($userIds) {
            // Número aleatorio de reseñas a crear (entre 1 y 2)
            $numberOfReviews = rand(1, 2);
            
            // Mezcla los usuarios y toma un grupo único para este producto
            $shuffledUserIds = collect($userIds)->shuffle();
            $reviewers = $shuffledUserIds->take($numberOfReviews);

            foreach ($reviewers as $userId) {
                Review::factory()->create([
                    'product_id' => $product->id,
                    'user_id' => $userId,
                ]);
            }
        });

        $this->command->info('\n\nSeeder de reseñas mejorado finalizado con éxito. Cada producto ahora tiene 1 o 2 reseñas.');
    }
}
