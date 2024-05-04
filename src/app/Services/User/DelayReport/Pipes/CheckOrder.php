<?php

namespace App\Services\User\DelayReport\Pipes;

use App\Exceptions\OrderException;
use App\Models\Order;
use App\Services\User\DelayReport\DelayReportContent;
use App\Services\User\DelayReport\DelayReportInterface;

class CheckOrder implements DelayReportInterface
{
    public function handle(DelayReportContent $content, \Closure $next)
    {
        $order = Order::query()
            ->where('id', $content->getOrderId())
            ->where('user_id', $content->getUserId())
            ->first();

        if (! $order) {
            OrderException::notFound();
        }

        $content->setOrder($order);

        return $next($content);
    }
}
