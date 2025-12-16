<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ProductType;
use App\Enums\ProductCondition;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'is_featured' => $this->faker->boolean,
            'sku' => $this->faker->unique()->ean13,
            'sale_price' => $this->faker->optional(0.3)->randomFloat(2, 5, 500),
            'type' => $this->faker->randomElement(ProductType::cases()),
            'condition' => $this->faker->randomElement(ProductCondition::cases()),
            'other_content' => ['key1' => $this->faker->word, 'key2' => $this->faker->sentence],
            'colors' => json_encode($this->faker->optional(0.5)->randomElements(['Rojo', 'Verde', 'Azul', 'Negro', 'Blanco'], $this->faker->numberBetween(1, 3))),
            'video_url' => $this->faker->optional(0.2)->url,
            'additional_info' => $this->faker->boolean(70) ? implode("\n\n", $this->faker->paragraphs(2)) : null,
            'delivery_date_message' => 'Entrega estimada en ' . $this->faker->numberBetween(2, 7) . ' días',
            'seo_title' => $this->faker->sentence(4),
            'seo_description' => $this->faker->sentence(10),
            'seo_keywords' => json_encode($this->faker->words(5, false)),
        ];
    }
}
