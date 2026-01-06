<?php

namespace App\Contracts\Services;

interface ReportServiceInterface extends BaseServiceInterface
{
    public function getDailyProductSalesReport();
}
