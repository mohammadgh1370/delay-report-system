<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DelayReport>
 */
class DelayReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'agent_id' => null,
            'checked_at' => null,
        ];
    }
}
