<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function findByIdAndUserId(int $id, int $userId): ?Order;

    public function update(array $data, Order $order): Order;

    public function getVendorsGroupByDelayInMinutes(): Collection;
}
