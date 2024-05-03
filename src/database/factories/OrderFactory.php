<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $deliveryTime = fake()->numberBetween(30, 100);
        $createdAt = now();

        return [
            'user_id' => User::factory(),
            'vendor_id' => Vendor::factory(),
            'name' => 'order-'.random_int(1, 1000),
            'delivery_time' => $deliveryTime,
            'estimate_delivered_at' => $createdAt->addMinutes($deliveryTime),
            'created_at' => $createdAt,
        ];
    }
}
