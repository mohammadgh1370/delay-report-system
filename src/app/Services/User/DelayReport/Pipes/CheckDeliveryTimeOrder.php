<?php

namespace App\Services\User\DelayReport\Pipes;

use App\Exceptions\OrderException;
use App\Services\User\DelayReport\DelayReportContent;
use App\Services\User\DelayReport\DelayReportInterface;
use Carbon\Carbon;

class CheckDeliveryTimeOrder implements DelayReportInterface
{
    public function handle(DelayReportContent $content, \Closure $next)
    {
        $order = $content->getOrder();

        if (! Carbon::parse($order->estimate_delivered_at)->isPast()) {
            OrderException::deliveryTimeIsNotPast();
        }

        return $next($content);
    }
}
