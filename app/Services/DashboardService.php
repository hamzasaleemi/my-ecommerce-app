<?php

namespace App\Services;

use App\Contracts\Services\DashboardServiceInterface as ServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Services\OrderServiceInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\Contracts\Services\AuthServiceInterface;

class DashboardService extends BaseService implements ServiceInterface
{
    private UserServiceInterface $userService;
    private OrderServiceInterface $orderService;
    private ProductServiceInterface $productService;
    private AuthServiceInterface $authService;

    public function __construct(UserServiceInterface $userService, OrderServiceInterface $orderService, ProductServiceInterface $productService, AuthServiceInterface $authService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->productService = $productService;
        $this->authService = $authService;
    }

    public function getDashboardData(): array
    {
        $data = [];
        if ($this->authService->getAuthenticatedUser()->role === 'admin') {
            $data['usersCount'] = $this->userService->getUsersCount();
            $data['ordersCount'] = $this->orderService->getOrdersCount();
            $data['lowStockProductsCount'] = $this->productService->getLowStockProductsCount();
        }
        $data['products'] = $this->productService->getForListing();
        return $data;
    }
}
