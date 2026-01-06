<?php

namespace App\Repositories;

use App\Models\Setting as Model;
use App\Contracts\Repositories\SettingRepositoryInterface as RepositoryInterface;

class SettingRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
