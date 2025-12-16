<?php

namespace Database\Factories;

use App\Enums\DiscountAppliesTo;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    protected $model = Discount::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['percentage', 'fixed']);
        $value = $type === 'percentage' ? $this->faker->numberBetween(5, 50) : $this->faker->randomFloat(2, 5, 50);
        
        // Usar los valores correctos del enum
        $appliesTo = $this->faker->randomElement(array_column(DiscountAppliesTo::cases(), 'value'));

        $productIds = null;
        $categoryIds = null;

        if ($appliesTo === DiscountAppliesTo::Products->value) {
            $productIds = Product::inRandomOrder()->limit($this->faker->numberBetween(1, 3))->pluck('id')->toArray();
        } elseif ($appliesTo === DiscountAppliesTo::Categories->value) {
            $categoryIds = Category::inRandomOrder()->limit($this->faker->numberBetween(1, 2))->pluck('id')->toArray();
        }

        return [
            'code' => $this->faker->unique()->word() . $this->faker->randomNumber(3),
            'type' => $type,
            'value' => $value,
            'min_amount' => $this->faker->boolean(30) ? $this->faker->randomFloat(2, 20, 100) : null,
            'max_uses' => $this->faker->boolean(50) ? $this->faker->numberBetween(10, 100) : null,
            'uses' => $this->faker->numberBetween(0, 5),
            'starts_at' => $this->faker->dateTimeBetween('-1 month', '+1 week'),
            'expires_at' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween('+1 week', '+6 months') : null,
            'is_active' => $this->faker->boolean(80),
            'applies_to' => $appliesTo,
            'product_ids' => $productIds,
            'category_ids' => $categoryIds,
        ];
    }
}
