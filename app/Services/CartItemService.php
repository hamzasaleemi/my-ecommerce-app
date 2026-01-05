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

    public function getMyCartItemsIds(): array
    {
        return $this->cartItemRepository->get([
            'scopeMethods' => [
                'whereUser' => [$this->authService->getAuthenticatedUser()->id],
            ],
        ])->pluck('id')->toArray();
    }

    public function getById($id)
    {
        return $this->cartItemRepository->get([
            'relations' => [
                'product' => null,
                'product.productImages' => null
            ],
            'scopeMethods' => [
                'whereUser' => [$this->authService->getAuthenticatedUser()->id],
            ],
            'whereConditions' => [
                ['field' => 'id', 'operator' => '=', 'value' => $id],
            ],
            'first' => true,
        ]);
    }

    public function getForListing()
    {
        return $this->cartItemRepository->get([
            'relations' => [
                'product' => null,
                'product.productImages' => null
            ],
            'scopeMethods' => [
                'whereUser' => [$this->authService->getAuthenticatedUser()->id],
            ],
        ]);
    }

    public function store(array $data): void
    {
        $cart = $this->cartItemRepository->get([
            'scopeMethods' => [
                'whereUser' => [$this->authService->getAuthenticatedUser()->id],
                'whereProduct' => [$data['product_id']]
            ],
            'first' => true,
        ]);
        if ($cart) {
            $cart->quantity += $data['quantity'];
            $cart->save();
        } else {
            $this->cartItemRepository->create([
                'user_id' => $this->authService->getAuthenticatedUser()->id,
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
            ]);
        }
    }

    public function update($id, $data): bool
    {
        $cartItem = $this->cartItemRepository->get([
            'scopeMethods' => [
                'whereUser' => [$this->authService->getAuthenticatedUser()->id],
            ],
            'whereConditions' => [
                ['field' => 'id', 'operator' => '=', 'value' => $id],
            ],
            'first' => true,
        ]);
        if ($cartItem) {
            $cartItem->update(['quantity' => $data['quantity']]);
            return true;
        }
        return false;
    }

    public function destroy($id): bool
    {
        return $this->cartItemRepository->destroy([$id]) > 0 ? true : false;
    }

    public function isStockAvailable($cartItemId, $requestedQuantity): bool
    {
        $cartItem = $this->cartItemRepository->find($cartItemId);

        if ($cartItem && $cartItem->product) {
            return $requestedQuantity <= $cartItem->product->stock_quantity;
        }

        return false;
    }
}
