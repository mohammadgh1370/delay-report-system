<?php

namespace App\Repositories;

use App\Models\OrderLog;

interface OrderLogRepositoryInterface
{
    public function create(array $data): OrderLog;
}
