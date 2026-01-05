<?php

namespace App\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface extends BaseServiceInterface
{
    public function getLowStockProductsCount(): int;
    public function getById(int $id);
    public function getForListing(): LengthAwarePaginator;
    public function isStockAvailable(int $productId, int $requestedQuantity): bool;
    public function lockProductsForUpdate(array $productIds);
    public function decreaseStockQuantity(int $productId, int $quantity): void;
}
