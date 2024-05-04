<?php

namespace Tests\Feature\User;

use App\Enums\TripStatus;
use App\Models\DelayReport;
use App\Models\Order;
use App\Models\Trip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_sample(): void
    {
        $response = $this->postJson(route('user.orders.create'), [
            'user_name' => 'John Doe',
            'vendor_name' => 'vendor-1',
            'name' => 'order-1',
            'delivery_time' => 10,
            'created_at' => now()->toDateTimeString(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user_id',
            'order_id',
            'estimate_delivered_at',
        ]);
    }

    public function test_delay_report_throw_exception_because_not_found_order()
    {
        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => 1, 'order_id' => 1]));

        $response->assertStatus(404);
    }

    public function test_delay_report_throw_exception_because_order_is_not_own_user()
    {
        $order = Order::factory()->create();

        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => 2, 'order_id' => $order->id]));

        $response->assertStatus(404);
    }

    public function test_delay_report_throw_exception_because_not_past_delivery_time()
    {
        $order = Order::factory()->state(['estimate_delivered_at' => now()->addMinutes(5)])->create();

        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => $order->user_id, 'order_id' => $order->id]));

        $response->assertStatus(400);
    }

    public function test_delay_report_update_estimate_delivered_at_because_trip_not_delivered()
    {
        $order = Order::factory()
            ->state(['estimate_delivered_at' => now()->subMinutes(5)])
            ->has(Trip::factory())
            ->create();

        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => $order->user_id, 'order_id' => $order->id]));

        $response->assertStatus(200);
    }

    public function test_delay_report_create_because_order_dont_have_trip()
    {
        $order = Order::factory()
            ->state(['estimate_delivered_at' => now()->subMinutes(5)])
            ->create();

        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => $order->user_id, 'order_id' => $order->id]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('delay_reports', ['order_id' => $order->id, 'checked_at' => null]);
        $this->assertDatabaseHas('orders', ['estimate_delivered_at' => $order->estimate_delivered_at]);
    }

    public function test_delay_report_create_because_order_deliver_time_past_and_not_receive_to_user_with_trip_assigned_status()
    {
        $order = Order::factory()
            ->state(['estimate_delivered_at' => now()->subMinutes(5)])
            ->has(Trip::factory()->state(['status' => TripStatus::ASSIGNED]))
            ->create();

        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => $order->user_id, 'order_id' => $order->id]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('delay_reports', ['order_id' => $order->id, 'checked_at' => null]);
    }

    public function test_delay_report_create_because_order_deliver_time_past_and_not_receive_to_user_with_trip_at_vendor_status()
    {
        $order = Order::factory()
            ->state(['estimate_delivered_at' => now()->subMinutes(5)])
            ->has(Trip::factory()->state(['status' => TripStatus::AT_VENDOR]))
            ->create();

        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => $order->user_id, 'order_id' => $order->id]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('delay_reports', ['order_id' => $order->id, 'checked_at' => null]);
    }

    public function test_delay_report_create_because_order_deliver_time_past_and_not_receive_to_user_with_trip_at_picked_status()
    {
        $order = Order::factory()
            ->state(['estimate_delivered_at' => now()->subMinutes(5)])
            ->has(Trip::factory()->state(['status' => TripStatus::PICKED]))
            ->create();

        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => $order->user_id, 'order_id' => $order->id]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('delay_reports', ['order_id' => $order->id, 'checked_at' => null]);
    }

    public function test_delay_report_create_because_order_deliver_time_past_again_and_not_receive_to_user_again()
    {
        $order = Order::factory()
            ->state(['estimate_delivered_at' => now()->subMinutes(5)])
            ->has(Trip::factory())
            ->has(DelayReport::factory()->state(['checked_at' => now()->subMinutes(10)]))
            ->create();

        $response = $this->putJson(route('user.orders.delay-report', ['user_id' => $order->user_id, 'order_id' => $order->id]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('delay_reports', ['order_id' => $order->id, 'checked_at' => null]);
    }
}
