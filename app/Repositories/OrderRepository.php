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
}
