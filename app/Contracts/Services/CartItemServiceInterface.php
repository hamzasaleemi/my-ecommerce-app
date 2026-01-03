<?php

namespace App\Contracts\Services;

interface CartItemServiceInterface extends BaseServiceInterface
{
    public function getCartItemsCount(): int;
    public function add($user, $productId, $quantity): void;
    public function update($user, $productId, $quantity): void;
    public function delete($user, $productId): void;
}
