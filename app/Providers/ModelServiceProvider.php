<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\CartItemServiceInterface;
use App\Contracts\Services\OrderServiceInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\Contracts\Services\SettingServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Services\CartItemService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SettingService;
use App\Services\UserService;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CartItemServiceInterface::class, CartItemService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(SettingServiceInterface::class, SettingService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
