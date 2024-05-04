<?php

namespace App\Services\User\DelayReport;

interface DelayReportInterface
{
    public function handle(DelayReportContent $content, \Closure $next);
}
