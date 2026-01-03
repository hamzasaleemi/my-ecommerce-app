<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Contracts\Services\DashboardServiceInterface;

class DashboardController extends Controller
{
    private DashboardServiceInterface $dashboardService;

    public function __construct(DashboardServiceInterface $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display the dashboard.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Dashboard', $this->dashboardService->getDashboardData());
    }
}
