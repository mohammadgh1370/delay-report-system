<?php

use App\Http\Controllers\Agent\OrderController as AgentOrderController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\Panel\OrderController as PanelOrderController;
use Illuminate\Support\Facades\Route;

Route::post('user/orders/', [UserOrderController::class, 'create'])
    ->name('user.orders.create');

Route::put('user/{user_id}/orders/{order_id}', [UserOrderController::class, 'delayReport'])
    ->name('user.orders.delay-report');

Route::put('agent/orders/assign', [AgentOrderController::class, 'assign'])
    ->name('agent.orders.assign');

Route::get('panel/orders/report', [PanelOrderController::class, 'report'])
    ->name('panel.orders.report');
