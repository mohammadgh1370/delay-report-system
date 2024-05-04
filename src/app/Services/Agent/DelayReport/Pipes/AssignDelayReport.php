<?php

namespace App\Services\Agent\DelayReport\Pipes;

use App\Exceptions\DelayReportException;
use App\Repositories\DelayReportRepositoryInterface;
use App\Services\Agent\DelayReport\DelayReportContent;
use App\Services\Agent\DelayReport\DelayReportInterface;

class AssignDelayReport implements DelayReportInterface
{
    public function __construct(private DelayReportRepositoryInterface $delayReportRepository)
    {
    }

    public function handle(DelayReportContent $content, \Closure $next)
    {
        $delayReport = $this->delayReportRepository->findByAgentIdNullAndCheckedAtNullAndOrderByCreatedAt();

        if (! $delayReport) {
            DelayReportException::dontExistAnyDelayReport();
        }

        $this->delayReportRepository->update([
            'agent_id' => $content->getAgentId(),
        ], $delayReport->id);

        $content->setDelayReport($delayReport);

        return $next($content);
    }
}
