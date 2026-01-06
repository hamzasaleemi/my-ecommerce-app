<?php

namespace App\Contracts\Services;

interface SettingServiceInterface extends BaseServiceInterface
{
    public function update(array $data): bool;
}
