<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\AddOrderRequest;
use App\Contracts\Services\OrderServiceInterface;
use App\Exceptions\StockNotAvailableException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderServiceInterface $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $parameters = [];
        if ($request->user()->role === 'admin') {
            $parameters['orders'] = $this->orderService->getForListing();
        } else {
            $parameters['orders'] = $this->orderService->getMyOrders();
        }
        return inertia('Order/View', $parameters);
    }

    public function store(AddOrderRequest $request)
    {
        $validated = $request->validated();
        try {
            $this->orderService->store($validated);
        } catch (StockNotAvailableException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }
}
