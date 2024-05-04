<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use App\Repositories\DelayReportRepositoryInterface;
use App\Repositories\Mysql\DelayReportRepository;
use App\Repositories\Mysql\OrderLogRepository;
use App\Repositories\Mysql\OrderRepository;
use App\Repositories\Mysql\TripRepository;
use App\Repositories\OrderLogRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\TripRepositoryInterface;
use App\Services\EstimateDeliveryTime\ConstantEstimateDeliveryTimeService;
use App\Services\EstimateDeliveryTime\EstimateDeliveryTimeInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EstimateDeliveryTimeInterface::class, ConstantEstimateDeliveryTimeService::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(TripRepositoryInterface::class, TripRepository::class);
        $this->app->bind(DelayReportRepositoryInterface::class, DelayReportRepository::class);
        $this->app->bind(OrderLogRepositoryInterface::class, OrderLogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);
    }
}
