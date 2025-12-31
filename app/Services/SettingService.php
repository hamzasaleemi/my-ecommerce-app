<?php

namespace App\Services;

use App\Contracts\Services\SettingServiceInterface as ServiceInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;


class SettingService extends BaseService implements ServiceInterface
{
    private SettingRepositoryInterface $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function get(): array
    {
        return $this->settingRepository->first()?->toArray() ?? [];
    }

    public function update(array $data): bool
    {
        $setting = $this->settingRepository->first();
        if ($setting) {
            return $this->settingRepository->update($setting->id, $data);
        }
        return false;
    }
}
