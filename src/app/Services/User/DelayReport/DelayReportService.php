<?php

namespace App\Services\User\DelayReport;

use App\Services\User\DelayReport\Pipes\CheckDelayReport;
use App\Services\User\DelayReport\Pipes\CheckDeliveryTimeOrder;
use App\Services\User\DelayReport\Pipes\CheckOrder;
use App\Services\User\DelayReport\Pipes\CheckTrip;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class DelayReportService
{
    public function handle(int $orderId, ?int $userId = null): string
    {
        $content = resolve(DelayReportContent::class, compact('orderId', 'userId'));

        DB::beginTransaction();
        try {
            resolve(Pipeline::class)
                ->send($content)
                ->through([
                    CheckOrder::class,
                    CheckDeliveryTimeOrder::class,
                    CheckTrip::class,
                    CheckDelayReport::class,
                ])
                ->thenReturn();

            DB::commit();

            return $content->getMessage();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
