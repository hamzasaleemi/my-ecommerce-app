<?php

namespace App\Contracts\Services;

interface OrderServiceInterface extends BaseServiceInterface
{
    public function getOrdersCount(): int;
}
