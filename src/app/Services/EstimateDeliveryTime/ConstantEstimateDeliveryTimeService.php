<?php

namespace App\Services\EstimateDeliveryTime;

class ConstantEstimateDeliveryTimeService implements EstimateDeliveryTimeInterface
{
    public function estimateTime(): int
    {
        return 15;
    }
}
