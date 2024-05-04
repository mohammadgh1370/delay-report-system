<?php

namespace App\Services\User\DelayReport;

use App\Models\Order;
use App\Models\Trip;

class DelayReportContent
{
    private Order $order;

    private ?Trip $trip = null;

    private string $message;

    public function __construct(
        private int $orderId,
        private ?int $userId = null,
    ) {
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(?Trip $trip): void
    {
        $this->trip = $trip;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
