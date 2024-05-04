<?php

namespace App\Services\Agent\DelayReport;

interface DelayReportInterface
{
    public function handle(DelayReportContent $content, \Closure $next);
}
