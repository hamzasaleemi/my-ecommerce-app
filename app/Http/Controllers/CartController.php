<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartAddItemRequest;
use App\Http\Requests\Cart\CartUpdateItemRequest;
use App\Http\Requests\Cart\CartRemoveItemRequest;
use App\Contracts\Services\CartItemServiceInterface;

class CartController extends Controller
{
    private CartItemServiceInterface $cartItemService;

    public function __construct(CartItemServiceInterface $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function view()
    {
        return inertia('Cart/View');
    }

    public function addItem(CartAddItemRequest $request)
    {
        $validated = $request->validated();
        $this->cartItemService->add($request->user()->id, $validated['product_id'], $validated['quantity']);
        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }

    public function updateItem(CartUpdateItemRequest $request)
    {
        $validated = $request->validated();
        $this->cartItemService->update($request->user()->id, $validated['product_id'], $validated['quantity']);
        return redirect()->back()->with('success', 'Item updated in cart successfully.');
    }

    public function removeItem(CartRemoveItemRequest $request)
    {
        $validated = $request->validated();
        $this->cartItemService->delete($request->user()->id, $validated['product_id']);
        return redirect()->back()->with('success', 'Item removed from cart successfully.');
    }
}
