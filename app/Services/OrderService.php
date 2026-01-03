<?php

namespace App\Services;

use App\Contracts\Services\OrderServiceInterface as ServiceInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;

class OrderService extends BaseService implements ServiceInterface
{
    private OrderRepositoryInterface $orderRepository;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrdersCount(): int
    {
        return $this->orderRepository->count();
    }
}
