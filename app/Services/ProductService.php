<?php

namespace App\Services;

use App\Contracts\Services\ProductServiceInterface as ServiceInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\AuthService;

class ProductService extends BaseService implements ServiceInterface
{
    private ProductRepositoryInterface $productRepository;
    private SettingRepositoryInterface $settingRepository;
    private AuthService $authService;

    public function __construct(ProductRepositoryInterface $productRepository, SettingRepositoryInterface $settingRepository, AuthService $authService)
    {
        $this->productRepository = $productRepository;
        $this->settingRepository = $settingRepository;
        $this->authService = $authService;
    }

    public function getLowStockProductsCount(): int
    {
        $setting = $this->settingRepository->first();
        $lowStockThreshold = $setting->low_stock_threshold;
        $count = $this->productRepository->get([
            'whereConditions' => [
                ['field' => 'stock_quantity', 'operator' => '<=', 'value' => $lowStockThreshold],
            ],
            'count' => true
        ]);
        return $count;
    }

    public function getById(int $id)
    {
        return $this->productRepository->find($id);
    }

    public function getForListing(): LengthAwarePaginator
    {
        $userId = $this->authService->getAuthenticatedUser()?->id;
        return $this->productRepository->get([
            'relations' => [
                'productImages' => null,
                'cartItems' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ],
            'order_by' => ['created_at' => 'desc'],
            'paginate' => true,
        ]);
    }

    public function isStockAvailable(int $productId, int $requestedQuantity): bool
    {
        $product = $this->productRepository->find($productId);
        if (!$product) {
            return false;
        }
        return $requestedQuantity <= $product->stock_quantity;
    }

    public function lockProductsForUpdate(array $productIds)
    {
        return $this->productRepository->get([
            'whereInConditions' => [
                ['field' => 'id', 'values' => $productIds],
            ],
            'lockForUpdate' => true,
        ]);
    }

    public function decreaseStockQuantity(int $productId, int $quantity): void
    {
        $product = $this->productRepository->find($productId);
        if ($product) {
            $this->productRepository->update($productId, ['stock_quantity' => $product->stock_quantity - $quantity]);
        }
    }
}
