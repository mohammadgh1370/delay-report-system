<?php

namespace Tests\Feature\Panel;

use App\Enums\TripStatus;
use App\Models\Order;
use App\Models\Trip;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_list_of_vendor_by_delay_orders_in_minutes()
    {
        $vendor1 = Vendor::factory()->create();
        $vendor2 = Vendor::factory()->create();
        $vendor3 = Vendor::factory()->create();
        $vendor4 = Vendor::factory()->create();
        $vendor5 = Vendor::factory()->create();

        Order::factory()
            ->sequence(
                ['created_at' => now()->subDay()->hour(12)->minute(0), 'delivery_time' => 15, 'vendor_id' => $vendor1->id],
                ['created_at' => now()->subDay()->hour(12)->minute(0), 'delivery_time' => 15, 'vendor_id' => $vendor2->id],
                ['created_at' => now()->subDay()->hour(12)->minute(0), 'delivery_time' => 15, 'vendor_id' => $vendor3->id],
                ['created_at' => now()->subDay()->hour(12)->minute(0), 'delivery_time' => 15, 'vendor_id' => $vendor4->id],
                ['created_at' => now()->subDay()->hour(12)->minute(0), 'delivery_time' => 15, 'vendor_id' => $vendor5->id],
            )
            ->has(
                Trip::factory()
                ->sequence(
                    ['delivered_at' => now()->subDay()->hour(12)->minute(10), 'status' =>TripStatus::DELIVERED],
                    ['delivered_at' => now()->subDay()->hour(12)->minute(15), 'status' =>TripStatus::DELIVERED],
                    ['delivered_at' => now()->subDay()->hour(12)->minute(20), 'status' =>TripStatus::DELIVERED],
                    ['delivered_at' => now()->subDay()->hour(12)->minute(25), 'status' =>TripStatus::DELIVERED],
                    ['delivered_at' => now()->subDay()->hour(12)->minute(30), 'status' =>TripStatus::DELIVERED],
                )
            )
            ->count(5)
            ->create();

        $response = $this->getJson(route('panel.orders.report'));

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertExactJson([
            ['id' => $vendor5->id, 'name' => $vendor5->name, 'delay_minutes' => '15'],
            ['id' => $vendor4->id, 'name' => $vendor4->name, 'delay_minutes' => '10'],
            ['id' => $vendor3->id, 'name' => $vendor3->name, 'delay_minutes' => '5'],
        ]);
    }
}