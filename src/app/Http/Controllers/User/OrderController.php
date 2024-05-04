<?php

namespace App\Http\Controllers\User;

use App\Enums\TripStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vendor;
use App\Services\User\DelayReport\DelayReportService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function create(OrderCreateRequest $request): JsonResponse
    {
        $order = Order::factory()
            ->for(User::factory())
            ->for(Vendor::factory())
            ->state(['created_at' => $request->created_at])
            ->create([
                'name' => $request->name,
                'delivery_time' => $request->delivery_time,
                'estimate_delivered_at' => Carbon::parse($request->created_at)->addMinutes($request->delivery_time)->toDateTimeString(),
            ]);

        if ($request->trip_status) {
            Trip::factory()
                ->state([
                    'delivered_at' => TripStatus::tryFrom($request->trip_status) === TripStatus::DELIVERED ? now() : null,
                    'status' => $request->trip_status
                ])
                ->for($order)
                ->create();
        }

        return response()->json([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'estimate_delivered_at' => $order->estimate_delivered_at,
        ]);
    }

    public function delayReport(int $userId, int $orderId): JsonResponse
    {
        $message = resolve(DelayReportService::class)->handle($orderId, $userId);

        return response()->json(compact('message'));
    }
}
