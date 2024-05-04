<?php

namespace App\Repositories\Mysql;

use App\Models\DelayReport;
use App\Repositories\BaseRepository;
use App\Repositories\DelayReportRepositoryInterface;

class DelayReportRepository extends BaseRepository implements DelayReportRepositoryInterface
{
    public function model(): string
    {
        return DelayReport::class;
    }

    public function findByOrderId(int $orderId): ?DelayReport
    {
        return $this->query
            ->where('order_id', $orderId)
            ->first();
    }

    public function create(array $data): DelayReport
    {
        return $this->query->create($data);
    }

    public function findByAgentIdAndCheckedAtNull(int $agentId): ?DelayReport
    {
        return $this->query
            ->where('agent_id', $agentId)
            ->whereNull('checked_at')
            ->first();
    }

    public function findByAgentIdNullAndCheckedAtNullAndOrderByCreatedAt(): ?DelayReport
    {
        return $this->query
            ->whereNull('agent_id')
            ->whereNull('checked_at')
            ->orderBy('created_at')
            ->first();
    }

    public function update(array $data, int $id): void
    {
        $this->query
            ->where('id', $id)
            ->update($data);
    }
}
