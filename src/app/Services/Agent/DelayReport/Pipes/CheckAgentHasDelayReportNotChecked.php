<?php

namespace App\Services\Agent\DelayReport\Pipes;

use App\Exceptions\DelayReportException;
use App\Repositories\DelayReportRepositoryInterface;
use App\Services\Agent\DelayReport\DelayReportContent;
use App\Services\Agent\DelayReport\DelayReportInterface;

class CheckAgentHasDelayReportNotChecked implements DelayReportInterface
{
    public function __construct(private DelayReportRepositoryInterface $delayReportRepository)
    {
    }

    public function handle(DelayReportContent $content, \Closure $next)
    {
        $delayReport = $this->delayReportRepository->findByAgentIdAndCheckedAtNull($content->getAgentId());

        if ($delayReport) {
            DelayReportException::agentHasDelayReportNotChecked();
        }

        return $next($content);
    }
}
