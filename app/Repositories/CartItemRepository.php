<?php

namespace App\Repositories;

use App\Models\CartItem as Model;
use App\Contracts\Repositories\CartItemRepositoryInterface as RepositoryInterface;

class CartItemRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
