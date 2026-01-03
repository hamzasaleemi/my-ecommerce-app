<?php

namespace App\Repositories;

use App\Models\OrderItem as Model;
use App\Contracts\Repositories\OrderItemRepositoryInterface as RepositoryInterface;

class OrderItemRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
