<?php

namespace App\Services;

use App\Contracts\Services\OrderServiceInterface as ServiceInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;

class OrderService extends BaseService implements ServiceInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getOrdersCount(): int
    {
        return $this->productRepository->count();
    }
}
