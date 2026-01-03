<?php

namespace App\Contracts\Services;

interface DashboardServiceInterface extends BaseServiceInterface
{
    public function getDashboardData(): array;
}
