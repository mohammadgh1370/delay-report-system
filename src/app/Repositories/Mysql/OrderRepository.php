<?php

namespace App\Repositories\Mysql;

use App\Enums\TripStatus;
use App\Models\Order;
use App\Repositories\BaseRepository;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function model(): string
    {
        return Order::class;
    }

    public function findByIdAndUserId(int $id, int $userId): ?Order
    {
        return $this->query
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function update(array $data, int $id): void
    {
        $this->query
            ->where('id', $id)
            ->update($data);
    }

    public function getVendorsGroupByDelayInMinutes(): Collection
    {
        return $this->query
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
    }
}
