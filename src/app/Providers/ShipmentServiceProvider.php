<?php

namespace VCComponent\Laravel\Shipment\Providers;

use Illuminate\Support\ServiceProvider;
use VCComponent\Laravel\Shipment\Repositories\ShipmentRepository;
use VCComponent\Laravel\Shipment\Repositories\ShipmentRepositoryEloquent;
use VCComponent\Laravel\Shipment\Repositories\ShipmentStatusHistoryRepository;
use VCComponent\Laravel\Shipment\Repositories\ShipmentStatusHistoryRepositoryEloquent;

class ShipmentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->publishes([
            __DIR__ . '/../../config/shipment.php' => config_path('shipment.php'),
        ], 'config');
    }

    /**
     * Register any package services
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ShipmentRepository::class, ShipmentRepositoryEloquent::class);
        $this->app->bind(ShipmentStatusHistoryRepository::class, ShipmentStatusHistoryRepositoryEloquent::class);
        $this->app->bind('shipment_status_history', StatusHistory::class);
    }
}
