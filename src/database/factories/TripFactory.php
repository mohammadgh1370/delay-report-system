<?php

namespace Database\Factories;

use App\Enums\TripStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    public function definition(): array
    {
        $order = Order::factory()->create();

        return [
            'delivery_id' => User::factory(),
            'order_id' => $order,
            'status' => TripStatus::ASSIGNED,
            'delivered_at' => null,
        ];
    }
}
