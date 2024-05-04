<?php

namespace App\Providers;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
