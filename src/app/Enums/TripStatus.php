<?php

namespace App\Enums;

enum TripStatus: int
{
    use Enums;

    case ASSIGNED = 1;
    case AT_VENDOR = 2;
    case PICKED = 3;
    case DELIVERED = 4;
}