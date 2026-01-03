<?php

namespace App\Services;

use App\Contracts\Services\CartItemServiceInterface as ServiceInterface;
use App\Contracts\Repositories\CartItemRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;

class CartItemService extends BaseService implements ServiceInterface
{
    private CartItemRepositoryInterface $cartItemRepository;
    private AuthServiceInterface $authService;

    public function __construct(CartItemRepositoryInterface $cartItemRepository, AuthServiceInterface $authService)
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->authService = $authService;
    }

    public function getCartItemsCount(): int
    {
        return $this->cartItemRepository->get([
            'scopeMethods' => [
                'whereUser' => [$this->authService->getAuthenticatedUser()->id],
                'itemsCount' => null,
            ],
            'first' => true,
        ])->items_count ?? 0;
    }

    public function add($userId, $productId, $quantity): void
    {
        $cart = $this->cartItemRepository->get([
            'scopeMethods' => [
                'whereUser' => [$userId],
                'whereProduct' => [$productId]
            ],
            'first' => true,
        ]);
        if ($cart) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            $this->cartItemRepository->create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
    }

    public function update($userId, $productId, $quantity): void
    {
        $cartItem = $this->cartItemRepository->get([
            'scopeMethods' => [
                'whereUser' => [$userId],
                'whereProduct' => [$productId]
            ],
            'first' => true,
        ]);
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }
    }

    public function delete($userId, $productId): void
    {
        $cartItem = $this->cartItemRepository->get([
            'scopeMethods' => [
                'whereUser' => [$userId],
                'whereProduct' => [$productId]
            ],
            'first' => true,
        ]);
        if ($cartItem) {
            $cartItem->delete();
        }
    }
}
