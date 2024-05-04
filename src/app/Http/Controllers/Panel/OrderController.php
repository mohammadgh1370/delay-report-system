<?php

namespace App\Http\Controllers\Panel;

use App\Enums\TripStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function report(): JsonResponse
    {
        $list = Order::query()
            ->select(['vendors.id', 'vendors.name', DB::raw('SUM(TIMESTAMPDIFF(MINUTE, orders.created_at, trips.delivered_at)) - SUM(orders.delivery_time) AS delay_minutes')])
            ->join('vendors', 'vendors.id', '=', 'orders.vendor_id')
            ->join('trips', 'orders.id', '=', 'trips.order_id')
            ->where('status', TripStatus::DELIVERED)
            ->whereNotNull('delivered_at')
            ->whereBetween('orders.created_at', [now()->subDays(7), now()])
            ->groupBy('vendor_id')
            ->havingRaw('delay_minutes > 0')
            ->orderByDesc('delay_minutes')
            ->get();

        return response()->json($list);
    }
}
