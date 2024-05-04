<?php

namespace Tests\Unit\Services;

use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;
use App\Services\User\DelayReport\DelayReportContent;
use App\Services\User\DelayReport\Pipes\CheckOrder;
use Tests\TestCase;

class CheckOrderPipeTest extends TestCase
{
    public function test_it_sets_order_in_content()
    {
        // Arrange
        $orderId = 1;
        $userId = 1;
        $order = (new Order())
            ->setAttribute('id', $orderId)
            ->setAttribute('user_id', $userId);

        $orderRepository = $this->mock(OrderRepositoryInterface::class);
        $orderRepository->shouldReceive('findByIdAndUserId')
            ->once()
            ->with($orderId, $userId)
            ->andReturn($order);

        $content = new DelayReportContent($orderId, $userId);
        $checkOrder = resolve(CheckOrder::class);

        // Act
        $result = $checkOrder->handle($content, function ($content) {
            return $content;
        });

        // Assert
        $this->assertEquals($order, $result->getOrder());
    }
}
