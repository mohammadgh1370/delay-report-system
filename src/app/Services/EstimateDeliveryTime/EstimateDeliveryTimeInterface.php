<?php

namespace App\Services\EstimateDeliveryTime;

interface EstimateDeliveryTimeInterface
{
    public function estimateTime(): int;
}
