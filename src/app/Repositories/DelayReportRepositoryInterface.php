<?php

namespace App\Repositories;

use App\Models\DelayReport;

interface DelayReportRepositoryInterface
{
    public function findByOrderId(int $orderId): ?DelayReport;

    public function create(array $data): DelayReport;

    public function findByAgentIdAndCheckedAtNull(int $agentId): ?DelayReport;

    public function findByAgentIdNullAndCheckedAtNullAndOrderByCreatedAt(): ?DelayReport;

    public function update(array $data, int $id): void;
}
