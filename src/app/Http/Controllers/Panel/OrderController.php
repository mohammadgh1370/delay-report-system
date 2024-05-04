<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderRepositoryInterface $orderRepository)
    {
    }

    public function report(): JsonResponse
    {
        $list = $this->orderRepository->getVendorsGroupByDelayInMinutes();

        return response()->json($list);
    }
}
