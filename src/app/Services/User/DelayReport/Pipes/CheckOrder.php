<?php

namespace App\Services\User\DelayReport\Pipes;

use App\Exceptions\OrderException;
use App\Repositories\OrderRepositoryInterface;
use App\Services\User\DelayReport\DelayReportContent;
use App\Services\User\DelayReport\DelayReportInterface;

class CheckOrder implements DelayReportInterface
{
    public function __construct(private OrderRepositoryInterface $orderRepository)
    {
    }

    public function handle(DelayReportContent $content, \Closure $next)
    {
        $order = $this->orderRepository->findByIdAndUserId($content->getOrderId(), $content->getUserId());

        if (! $order) {
            OrderException::notFound();
        }

        $content->setOrder($order);

        return $next($content);
    }
}
