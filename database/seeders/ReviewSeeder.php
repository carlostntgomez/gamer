<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('--- Iniciando Seeder de Reseñas (Versión Corregida) ---');

        $this->command->comment('Limpiando la tabla de reseñas...');
        // Usar DB::table para asegurar que funciona aunque el modelo tenga inconsistencias
        DB::table('reviews')->truncate();

        $products = Product::all();
        $users = User::all();
        $faker = Faker::create('es_ES'); // Usar Faker en español para más realismo

        if ($products->isEmpty()) {
            $this->command->error('No hay productos en la base de datos para asignar reseñas. Abortando.');
            return;
        }

        $reviewCount = 150;
        $this->command->comment("Creando {$reviewCount} reseñas falsas...");

        for ($i = 0; $i < $reviewCount; $i++) {
            $product = $products->random();
            $isGuest = rand(0, 2) === 0; // 33% de probabilidad de ser un invitado

            $rating = $this->generateRealisticRating();
            [$title, $content] = $this->generateReviewContent($rating, $faker, $product->name);

            $reviewData = [
                'product_id' => $product->id,
                'rating' => $rating,
                'title' => $title,
                'content' => $content, // <-- CORRECCIÓN: 'content' en lugar de 'comment'
                'is_approved' => rand(0, 5) !== 0, // ~83% de probabilidad de ser aprobada
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($isGuest || $users->isEmpty()) {
                $reviewData['guest_name'] = $faker->name;
                $reviewData['guest_email'] = $faker->safeEmail;
            } else {
                $reviewData['user_id'] = $users->random()->id;
            }
            
            // Insertar directamente en la tabla para evitar problemas con el modelo Fillable
            DB::table('reviews')->insert($reviewData);
        }

        $this->command->info("--- Seeder de Reseñas finalizado con éxito. Se crearon {$reviewCount} reseñas. ---");
    }

    private function generateRealisticRating(): int
    {
        $rand = rand(1, 100);
        if ($rand <= 5) return 1;      // 5% de 1 estrella
        if ($rand <= 10) return 2;     // 5% de 2 estrellas
        if ($rand <= 25) return 3;     // 15% de 3 estrellas
        if ($rand <= 60) return 4;     // 35% de 4 estrellas
        return 5;                      // 40% de 5 estrellas
    }

    private function generateReviewContent(int $rating, \Faker\Generator $faker, string $productName): array
    {
        switch ($rating) {
            case 1:
                $title = $faker->randomElement(['Decepcionante', 'Producto defectuoso', 'No funciona', 'Mala calidad', 'No lo recomiendo']);
                $content = "No estoy nada contento con {$productName}. " . $faker->sentence(20, true);
                break;
            case 2:
                $title = $faker->randomElement(['Podría ser mejor', 'No cumple expectativas', 'Calidad regular']);
                $content = "Esperaba más de {$productName}. " . $faker->sentence(25, true);
                break;
            case 3:
                $title = $faker->randomElement(['Aceptable', 'Regular', 'Cumple su función', 'Ni fu ni fa']);
                $content = "Es un producto promedio. Ni bueno ni malo, simplemente cumple. " . $faker->sentence(30, true);
                break;
            case 4:
                $title = $faker->randomElement(['Muy bueno', 'Recomendado', 'Buena compra', 'Satisfecho con el producto']);
                $content = "Estoy muy satisfecho con la compra de {$productName}. Lo recomiendo sin dudarlo. " . $faker->sentence(35, true);
                break;
            default:
                $title = $faker->randomElement(['¡Excelente!', '¡Fantástico!', 'La mejor compra que he hecho', 'Superó todas mis expectativas']);
                $content = "¡Una maravilla! {$productName} es simplemente increíble. ¡Totalmente recomendado a todo el mundo! " . $faker->sentence(30, true);
                break;
        }
        return [$title, $content];
    }
}
