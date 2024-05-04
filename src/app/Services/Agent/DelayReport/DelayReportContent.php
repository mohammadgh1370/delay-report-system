<?php

namespace App\Services\Agent\DelayReport;

use App\Models\DelayReport;

class DelayReportContent
{
    private DelayReport $delayReport;

    public function __construct(
        private ?int $agentId = null,
    ) {
    }

    public function getAgentId(): ?int
    {
        return $this->agentId;
    }

    public function getDelayReport(): DelayReport
    {
        return $this->delayReport;
    }

    public function setDelayReport(DelayReport $delayReport): void
    {
        $this->delayReport = $delayReport;
    }
}
