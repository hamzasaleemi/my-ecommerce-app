<?php

namespace App\Repositories;

use App\Models\Payment as Model;
use App\Contracts\Repositories\PaymentRepositoryInterface as RepositoryInterface;

class PaymentRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
