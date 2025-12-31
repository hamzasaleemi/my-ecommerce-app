<?php

namespace App\Repositories;

use App\Models\User as Model;
use App\Contracts\Repositories\UserRepositoryInterface as RepositoryInterface;

class UserRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
