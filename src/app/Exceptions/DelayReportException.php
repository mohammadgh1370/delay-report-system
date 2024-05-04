<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class DelayReportException extends BaseException
{
    public static function agentHasDelayReportNotChecked()
    {
        throw new self('Agent has delay report not checked.', Response::HTTP_BAD_REQUEST);
    }

    public static function dontExistAnyDelayReport()
    {
        throw new self('Dont exist any delay report to assign.', Response::HTTP_BAD_REQUEST);
    }
}
