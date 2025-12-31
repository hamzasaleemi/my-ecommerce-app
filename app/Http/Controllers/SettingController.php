<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Settings\SettingUpdateRequest;
use Inertia\Inertia;
use Inertia\Response;
use App\Contracts\Services\SettingServiceInterface;

class SettingController extends Controller
{
    private SettingServiceInterface $settingService;

    public function __construct(SettingServiceInterface $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Display the dashboard.
     */
    public function edit(): Response
    {
        $settings = $this->settingService->get();
        return Inertia::render('Settings/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(SettingUpdateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $this->settingService->update($validated);
        return redirect()->route('settings.edit')->with('success', 'Settings updated successfully.');
    }
}
