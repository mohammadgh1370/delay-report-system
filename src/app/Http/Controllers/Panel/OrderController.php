<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\VendorResource;
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

        $data = VendorResource::collection($list);

        return response()->json($data);
    }
}
