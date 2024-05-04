<?php

namespace App\Repositories\Mysql;

use App\Models\OrderLog;
use App\Repositories\BaseRepository;
use App\Repositories\OrderLogRepositoryInterface;

class OrderLogRepository extends BaseRepository implements OrderLogRepositoryInterface
{
    public function model(): string
    {
        return OrderLog::class;
    }

    public function create(array $data): OrderLog
    {
        return $this->query->create($data);
    }
}
