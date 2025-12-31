<?php

namespace App\Contracts\Services;

interface SettingServiceInterface extends BaseServiceInterface
{
    public function get(): array;
    public function update(array $data): bool;
}
