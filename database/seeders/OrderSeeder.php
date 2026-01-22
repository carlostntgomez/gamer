<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->truncate();
        DB::table('order_items')->truncate();

        Order::factory()
            ->count(3) // Create 3 orders
            ->create()
            ->each(function (Order $order) {
                OrderItem::factory()
                    ->count(fake()->numberBetween(1, 3)) // 1 to 3 items per order
                    ->create(['order_id' => $order->id]);

                // Calculate subtotal based on order items
                $subtotal = $order->orderItems->sum(fn ($item) => $item->quantity * $item->price);
                
                // Generate a random shipping cost for demonstration
                $shippingCost = fake()->randomFloat(2, 5000, 20000); // Example: between 5,000 and 20,000 COP

                // Calculate total
                $total = $subtotal + $shippingCost;

                $order->update([
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total' => $total,
                ]);
            });
    }
}