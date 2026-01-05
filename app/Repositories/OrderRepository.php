<?php

namespace App\Repositories;

use App\Models\Order as Model;
use App\Contracts\Repositories\OrderRepositoryInterface as RepositoryInterface;

class OrderRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): Model
    {
        $order = parent::create([
            'user_id' => $data['user_id'],
            'total_amount' => $data['total_amount'],
            'status' => $data['status'],
        ]);
        $order->orderItems()->createMany($data['orderItems']);
        return $order;
    }
}
