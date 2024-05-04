<?php

namespace App\Services\User\DelayReport\Pipes;

use App\Enums\TripStatus;
use App\Models\DelayReport;
use App\Services\User\DelayReport\DelayReportContent;
use App\Services\User\DelayReport\DelayReportInterface;

class CheckDelayReport implements DelayReportInterface
{
    public function handle(DelayReportContent $content, \Closure $next)
    {
        $trip = $content->getTrip();

        $delayReport = DelayReport::query()
            ->where('order_id', $content->getOrderId())
            ->first();

        if ($delayReport && ! $delayReport->checked_at) {
            $content->setMessage('Delay report already submitted.');

            return $next($content);
        }

        if (! $trip || ! in_array($trip->status, [TripStatus::ASSIGNED, TripStatus::AT_VENDOR, TripStatus::PICKED])) {
            DelayReport::query()->create([
                'order_id' => $content->getOrderId(),
            ]);

            $content->setMessage('Delay report submitted.');
        }

        return $next($content);
    }
}
