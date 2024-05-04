<?php

namespace App\Services\User\DelayReport\Pipes;

use App\Enums\TripStatus;
use App\Repositories\DelayReportRepositoryInterface;
use App\Services\User\DelayReport\DelayReportContent;
use App\Services\User\DelayReport\DelayReportInterface;

class CheckDelayReport implements DelayReportInterface
{
    public function __construct(private DelayReportRepositoryInterface $delayReportRepository)
    {
    }

    public function handle(DelayReportContent $content, \Closure $next)
    {
        $trip = $content->getTrip();

        $delayReport = $this->delayReportRepository->findByOrderId($content->getOrderId());

        if ($delayReport && ! $delayReport->checked_at) {
            $content->setMessage('Delay report already submitted.');

            return $next($content);
        }

        if (! $trip || ! in_array($trip->status, [TripStatus::ASSIGNED, TripStatus::AT_VENDOR, TripStatus::PICKED])) {
            $this->delayReportRepository->create([
                'order_id' => $content->getOrderId(),
            ]);

            $content->setMessage('Delay report submitted.');
        }

        return $next($content);
    }
}
