<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface ProductServiceInterface extends BaseServiceInterface
{
    public function getLowStockProductsCount(): int;
    public function getProductsForListing(): Collection;
}
