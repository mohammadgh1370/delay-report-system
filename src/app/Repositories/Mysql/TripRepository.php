<?php

namespace App\Repositories\Mysql;

use App\Models\Trip;
use App\Repositories\BaseRepository;
use App\Repositories\TripRepositoryInterface;

class TripRepository extends BaseRepository implements TripRepositoryInterface
{
    public function model(): string
    {
        return Trip::class;
    }

    public function findByOrderId(int $orderId): ?Trip
    {
        return $this->query
            ->where('order_id', $orderId)
            ->first();
    }
}
