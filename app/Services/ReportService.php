<?php

namespace App\Services;

use App\Contracts\Services\ReportServiceInterface as ServiceInterface;
use App\Contracts\Repositories\OrderItemRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReportService extends BaseService implements ServiceInterface
{
    private OrderItemRepositoryInterface $orderItemRepository;

    public function __construct(OrderItemRepositoryInterface $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function getDailyProductSalesReport()
    {
        $startDate = now()->subDay()->toDateTimeString();
        $endDate = now()->toDateTimeString();

        $salesData = $this->orderItemRepository->get([
            'joins' => [
                [
                    'table' => 'products',
                    'first' => 'order_items.product_id',
                    'operator' => '=',
                    'second' => 'products.id',
                    'type' => 'inner',
                ],
                [
                    'table' => 'orders',
                    'first' => 'order_items.order_id',
                    'operator' => '=',
                    'second' => 'orders.id',
                    'type' => 'inner',
                ]
            ],
            'whereConditions' => [
                ['field' => 'orders.created_at', 'operator' => '>=', 'value' => $startDate],
                ['field' => 'orders.created_at', 'operator' => '<=', 'value' => $endDate],
            ],
            'groupBy' => ['order_items.product_id', 'products.name', 'order_items.price_at_time_of_purchase'],
            'select' => [
                'order_items.product_id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as quantity_sold'),
                DB::raw('SUM(order_items.price_at_time_of_purchase * order_items.quantity) as total_revenue'),
                'order_items.price_at_time_of_purchase',
            ],
        ]);

        return $salesData;
    }
}
