<?php

namespace App\Repositories;

use App\Models\Product as Model;
use App\Contracts\Repositories\ProductRepositoryInterface as RepositoryInterface;

class ProductRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
