<?php

namespace App\Services;

use App\Contracts\Services\ProductServiceInterface as ServiceInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;
use Illuminate\Support\Collection;
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

    public function getProductsForListing(): Collection
    {
        return $this->productRepository->get([
            'relations' => ['productImages'],
            'scopeMethods' => [
                'withCartQuantity' => [$this->authService->getAuthenticatedUser()?->id]
            ],
        ]);
    }
}
