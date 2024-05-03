<?php

namespace App\Enums;

enum DelayReportStatus: int
{
    use Enums;

    case INIT = 1;
    case DONE = 2;
}