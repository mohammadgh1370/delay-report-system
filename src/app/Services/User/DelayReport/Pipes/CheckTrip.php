<?php

namespace App\Services\User\DelayReport\Pipes;

use App\Enums\TripStatus;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\TripRepositoryInterface;
use App\Services\EstimateDeliveryTime\EstimateDeliveryTimeInterface;
use App\Services\User\DelayReport\DelayReportContent;
use App\Services\User\DelayReport\DelayReportInterface;

class CheckTrip implements DelayReportInterface
{
    public function __construct(
        private TripRepositoryInterface $tripRepository,
        private OrderRepositoryInterface $orderRepository,
        private EstimateDeliveryTimeInterface $estimateDeliveryTime
    ) {
    }

    public function handle(DelayReportContent $content, \Closure $next)
    {
        $trip = $this->tripRepository->findByOrderId($content->getOrderId());

        if ($trip && in_array($trip->status, [TripStatus::ASSIGNED, TripStatus::AT_VENDOR, TripStatus::PICKED])) {
            $estimateTime = $this->estimateDeliveryTime->estimateTime();

            $this->orderRepository->update([
                'estimate_delivered_at' => now()->addMinutes($estimateTime),
            ], $content->getOrder());

            $content->setMessage('Estimate delivered update and sending order for you.');

            return $next($content);
        }

        $content->setTrip($trip);

        return $next($content);
    }
}
