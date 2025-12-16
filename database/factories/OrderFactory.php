<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Address;
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
        $status = $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']);

        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => $this->faker->boolean(70) ? User::factory() : null,
            'status' => $status,
            'total' => 0, // Will be calculated after order items are attached
            'shipping_address_id' => Address::factory()->shipping(),
            'billing_address_id' => Address::factory()->billing(),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
