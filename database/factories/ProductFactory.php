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
            'slug' => $this->faker->unique()->slug,
            'short_description' => $this->faker->sentence,
            'long_description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'is_featured' => $this->faker->boolean,
            'sku' => $this->faker->unique()->ean13,
            'sale_price' => $this->faker->optional(0.3)->randomFloat(2, 5, 500),
            'type' => $this->faker->randomElement(ProductType::cases()),
            'condition' => $this->faker->randomElement(ProductCondition::cases()),
            'delivery_info' => $this->faker->sentence,
            'return_policy' => $this->faker->sentence,
            'colors' => $this->faker->optional(0.5)->randomElements(['Rojo', 'Verde', 'Azul', 'Negro', 'Blanco'], $this->faker->numberBetween(1, 3)),
            'specifications' => ['key1' => $this->faker->word, 'key2' => $this->faker->sentence],
            'seo_title' => $this->faker->sentence(4),
            'seo_description' => $this->faker->sentence(10),
            'seo_keywords' => $this->faker->words(5, false),
        ];
    }
}
