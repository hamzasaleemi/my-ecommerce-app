<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Contracts\Services\ReportServiceInterface;
use App\Mail\DailySalesReportEmail;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Services\UserServiceInterface;

class SendDailySalesReportEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $adminEmails = app(UserServiceInterface::class)->getAdminEmails();
        $reportData = app(ReportServiceInterface::class)->getDailyProductSalesReport();
        Mail::to($adminEmails)->send(new DailySalesReportEmail($reportData));
    }
}
