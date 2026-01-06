<?php

namespace App\Repositories;

use App\Models\ProductImage as Model;
use App\Contracts\Repositories\ProductImageRepositoryInterface as RepositoryInterface;

class ProductImageRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
