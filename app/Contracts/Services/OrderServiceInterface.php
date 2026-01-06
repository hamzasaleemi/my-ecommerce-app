<?php

namespace App\Contracts\Services;

interface OrderServiceInterface extends BaseServiceInterface
{
    public function getOrdersCount(): int;
    public function getForListing();
    public function getMyOrders();
    public function store(array $data): void;
}
