<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => $this->faker->boolean(70) ? User::factory() : null,
            'payment_method' => $this->faker->randomElement(PaymentMethod::class),
            'subtotal' => 0, // Initial value, will be calculated in seeder
            'shipping_cost' => 0, // Initial value, will be calculated in seeder
            'total' => 0, // Will be calculated after order items are attached
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
