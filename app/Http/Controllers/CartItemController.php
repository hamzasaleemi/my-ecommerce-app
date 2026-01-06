<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Contracts\Services\CartItemServiceInterface;

class CartItemController extends Controller
{
    private CartItemServiceInterface $cartItemService;

    public function __construct(CartItemServiceInterface $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function index()
    {
        $parameters['cartItems'] = $this->cartItemService->getForListing();
        return inertia('Cart/View', $parameters);
    }

    public function store(AddCartItemRequest $request)
    {
        $validated = $request->validated();
        $this->cartItemService->store($validated);
        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }

    public function update(UpdateCartItemRequest $request, int $id)
    {
        $validated = $request->validated();
        if ($this->cartItemService->update($id, $validated)) {
            return redirect()->back()->with('success', 'Cart item updated successfully.');
        }
        return redirect()->back()->with('error', 'Failed to update cart item.');
    }

    public function destroy(int $id)
    {
        if ($this->cartItemService->destroy($id)) {
            return redirect()->back()->with('success', 'Cart item removed successfully.');
        }
        return redirect()->back()->with('error', 'Failed to remove cart item.');
    }
}
