<?php

namespace App\Contracts\Repositories;

interface SettingRepositoryInterface extends BaseRepositoryInterface
{
    public function first(): ?\App\Models\Setting;
}
