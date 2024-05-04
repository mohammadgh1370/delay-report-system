<?php

namespace App\Observers;

use App\Models\Order;
use App\Repositories\OrderLogRepositoryInterface;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->isDirty('estimate_delivered_at')) {
            resolve(OrderLogRepositoryInterface::class)->create([
                'order_id' => $order->id,
                'estimate_delivered_at' => $order->estimate_delivered_at
            ]);
        }
    }
}