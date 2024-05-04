<?php

namespace App\Services\Agent\DelayReport;

use App\Models\DelayReport;
use App\Services\Agent\DelayReport\Pipes\AssignDelayReport;
use App\Services\Agent\DelayReport\Pipes\CheckAgentHasDelayReportNotChecked;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class DelayReportService
{
    public function handle(int $agentId): DelayReport
    {
        $content = resolve(DelayReportContent::class, compact('agentId'));

        DB::beginTransaction();
        try {
            resolve(Pipeline::class)
                ->send($content)
                ->through([
                    CheckAgentHasDelayReportNotChecked::class,
                    AssignDelayReport::class,
                ])
                ->thenReturn();

            DB::commit();

            return $content->getDelayReport();
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
