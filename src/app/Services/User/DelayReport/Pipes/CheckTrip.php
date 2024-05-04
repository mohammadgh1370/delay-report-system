<?php

namespace App\Services\User\DelayReport\Pipes;

use App\Enums\TripStatus;
use App\Models\Trip;
use App\Services\EstimateDeliveryTime\EstimateDeliveryTimeInterface;
use App\Services\User\DelayReport\DelayReportContent;
use App\Services\User\DelayReport\DelayReportInterface;

class CheckTrip implements DelayReportInterface
{
    public function __construct(private EstimateDeliveryTimeInterface $estimateDeliveryTime)
    {
    }

    public function handle(DelayReportContent $content, \Closure $next)
    {
        $trip = Trip::query()
            ->where('order_id', $content->getUserId())
            ->first();

        $order = $content->getOrder();

        if ($trip && in_array($trip->status, [TripStatus::ASSIGNED, TripStatus::AT_VENDOR, TripStatus::PICKED])) {
            $estimateTime = $this->estimateDeliveryTime->estimateTime();

            $order->update(['estimate_delivered_at' => now()->addMinutes($estimateTime)]);

            $content->setMessage('Estimate delivered update and sending order for you.');

            return $next($content);
        }

        $content->setTrip($trip);

        return $next($content);
    }
}
