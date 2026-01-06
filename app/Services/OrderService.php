<?php

namespace App\Services;

use App\Contracts\Services\OrderServiceInterface as ServiceInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\PaymentRepositoryInterface;
use App\Contracts\Repositories\CartItemRepositoryInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;
use App\Exceptions\StockNotAvailableException;
use App\Contracts\Services\ProductServiceInterface;
use App\Contracts\Services\CartItemServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Contracts\Services\AuthServiceInterface;
use App\Jobs\SendLowStockEmail;

class OrderService extends BaseService implements ServiceInterface
{
    private OrderRepositoryInterface $orderRepository;
    private PaymentRepositoryInterface $paymentRepository;
    private CartItemRepositoryInterface $cartItemRepository;
    private SettingRepositoryInterface $settingRepository;
    private ProductServiceInterface $productService;
    private CartItemServiceInterface $cartItemService;
    private AuthServiceInterface $authService;

    public function __construct(
            OrderRepositoryInterface $orderRepository,
            PaymentRepositoryInterface $paymentRepository,
            CartItemRepositoryInterface $cartItemRepository,
            SettingRepositoryInterface $settingRepository,
            ProductServiceInterface $productService,
            CartItemServiceInterface $cartItemService,
            AuthServiceInterface $authService
        )
    {
        $this->orderRepository = $orderRepository;
        $this->paymentRepository = $paymentRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->settingRepository = $settingRepository;
        $this->productService = $productService;
        $this->cartItemService = $cartItemService;
        $this->authService = $authService;
    }

    public function getOrdersCount(): int
    {
        return $this->orderRepository->count();
    }

    public function getForListing()
    {
        return $this->orderRepository->get([
            'relations' => ['user', 'orderItems.product.productImages', 'payments'],
            'order_by' => ['created_at' => 'desc'],
            'paginate' => true,
        ]);
    }

    public function getMyOrders()
    {
        return $this->orderRepository->get([
            'relations' => ['orderItems.product.productImages', 'payments'],
            'whereConditions' => [
                ['field' => 'user_id', 'operator' => '=', 'value' => $this->authService->getAuthenticatedUser()->id],
            ],
            'order_by' => ['created_at' => 'desc'],
            'paginate' => true,
        ]);
    }

    public function store(array $data): void
    {
        DB::transaction(function () use ($data) {

            $lowStockThreshold = $this->settingRepository->first()->low_stock_threshold;
            $products = $this->productService->lockProductsForUpdate(array_column($data['order_items'], 'product_id'));
            $lowStockProducts = [];

            $orderData = [
                'user_id' => $this->authService->getAuthenticatedUser()->id,
                'total_amount' => 0,
                'status' => 'completed',
                'orderItems' => [],
            ];

            foreach ($products as $product) {
                $orderedItem = collect($data['order_items'])->firstWhere('product_id', $product->id);
                if ($product->stock_quantity < $orderedItem['quantity'])
                {
                    throw new StockNotAvailableException('Insufficient stock available for the product: ' . $product->name . '. Only ' . $product->stock_quantity . ' left in stock.');
                }
                if ($product->stock_quantity - $orderedItem['quantity'] <= $lowStockThreshold) {
                    $lowStockProducts[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'stock_quantity' => $product->stock_quantity - $orderedItem['quantity'],
                    ];
                }
                $orderData['total_amount'] += $product->price * $orderedItem['quantity'];
                $orderData['orderItems'][] = [
                    'product_id' => $product->id,
                    'quantity' => $orderedItem['quantity'],
                    'price_at_time_of_purchase' => $product->price,
                ];
                $this->productService->decreaseStockQuantity($product->id, $orderedItem['quantity']);
            }

            $order = $this->orderRepository->create($orderData);
            $this->paymentRepository->create([
                'order_id' => $order->id,
                'transaction_id' => uniqid('txn_'),
                'amount_paid' => $order->total_amount,
            ]);

            $cartItemIds = $this->cartItemService->getMyCartItemsIds();
            $this->cartItemRepository->destroy($cartItemIds);

            if (!empty($lowStockProducts)) {
                dispatch(new SendLowStockEmail($lowStockProducts))->afterCommit();
            }
        });
    }
}
