<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\UpdateSettingsRequest;
use Inertia\Inertia;
use Inertia\Response;
use App\Contracts\Services\SettingServiceInterface;
use App\Contracts\Repositories\SettingRepositoryInterface;

class SettingsController extends Controller
{
    private SettingServiceInterface $settingService;
    private SettingRepositoryInterface $settingRepository;

    public function __construct(SettingServiceInterface $settingService, SettingRepositoryInterface $settingRepository)
    {
        $this->settingService = $settingService;
        $this->settingRepository = $settingRepository;
    }

    /**
     * Display the dashboard.
     */
    public function edit(): Response
    {
        $settings = $this->settingRepository->first();
        return Inertia::render('Settings/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(UpdateSettingsRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $this->settingService->update($validated);
        return redirect()->route('settings.edit')->with('success', 'Settings updated successfully.');
    }
}
