<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(rand(2, 4)),
            'url' => $this->faker->boolean(70) ? $this->faker->url() : null,
            'order' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(80),
            'starts_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'expires_at' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween('now', '+6 months') : null,
        ];
    }
}
