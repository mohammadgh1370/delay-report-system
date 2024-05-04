<?php

namespace App\Services\Agent\DelayReport\Pipes;

use App\Exceptions\DelayReportException;
use App\Models\DelayReport;
use App\Services\Agent\DelayReport\DelayReportContent;
use App\Services\Agent\DelayReport\DelayReportInterface;

class AssignDelayReport implements DelayReportInterface
{
    public function handle(DelayReportContent $content, \Closure $next)
    {
        $delayReport = DelayReport::query()
            ->whereNull('agent_id')
            ->whereNull('checked_at')
            ->orderBy('created_at')
            ->first();

        if (! $delayReport) {
            DelayReportException::dontExistAnyDelayReport();
        }

        $delayReport->update(['agent_id' => $content->getAgentId()]);

        $content->setDelayReport($delayReport);

        return $next($content);
    }
}
