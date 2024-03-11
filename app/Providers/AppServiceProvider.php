<?php

namespace App\Providers;

use App\Repositories\Product\Contracts\ProductRepositoryInterface;
use App\Repositories\Product\EloquentProductRepository;
use App\Services\Product\Contracts\ProductServiceInterface;
use App\Services\Product\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
    }
}
