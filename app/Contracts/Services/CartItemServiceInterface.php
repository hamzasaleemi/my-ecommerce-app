<?php

namespace App\Contracts\Services;

interface CartItemServiceInterface extends BaseServiceInterface
{
    public function getCartItemsCount(): int;
    public function getMyCartItemsIds(): array;
    public function getById($id);
    public function getForListing();
    public function store(array $data): void;
    public function update($id, $data): bool;
    public function destroy($id): bool;
    public function isStockAvailable($cartItemId, $requestedQuantity): bool;
}
