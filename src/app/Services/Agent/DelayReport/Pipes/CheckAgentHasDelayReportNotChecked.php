<?php

namespace App\Services\Agent\DelayReport\Pipes;

use App\Exceptions\DelayReportException;
use App\Models\DelayReport;
use App\Services\Agent\DelayReport\DelayReportContent;
use App\Services\Agent\DelayReport\DelayReportInterface;

class CheckAgentHasDelayReportNotChecked implements DelayReportInterface
{
    public function handle(DelayReportContent $content, \Closure $next)
    {
        $delayReport = DelayReport::query()
            ->where('agent_id', $content->getAgentId())
            ->whereNull('checked_at')
            ->first();

        if ($delayReport) {
            DelayReportException::agentHasDelayReportNotChecked();
        }

        return $next($content);
    }
}
