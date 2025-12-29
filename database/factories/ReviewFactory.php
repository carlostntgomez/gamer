<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->bs(),
            'rating' => $this->faker->numberBetween(4, 5),
            'content' => $this->faker->realText(200), // <--- CORREGIDO de 'comment' a 'content'
            'is_approved' => true,
        ];
    }
}
