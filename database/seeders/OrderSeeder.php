<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::inRandomOrder()->take(10)->get();
        $products = Product::inRandomOrder()->take(10)->get();

        foreach (range(1, 20) as $i) {
            $user = $users->random();

            $order = Order::create(attributes: [
                'order_number' => 'ORD-' . Str::upper(Str::random(8)),
                'user_id' => $user->id,
                'total_amount' => 0, // will calculate after items
                'payment_status' => fake()->randomElement(['paid', 'unpaid']),
                'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
                'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            ]);

            $itemsTotal = 0;
            foreach ($products->random(rand(2, 5)) as $product) {
                $price = $product->price;
                $qty = rand(1, 3);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $price,
                    'quantity' => $qty,
                ]);

                $itemsTotal += $price * $qty;
            }

            $order->update(['total_amount' => $itemsTotal]);
        }
    }
}
