<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Services\UserServiceInterface;

class SendLowStockEmail implements ShouldQueue
{
    use Queueable;

    private array $products;

    /**
     * Create a new job instance.
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $adminEmails = app(UserServiceInterface::class)->getAdminEmails();
        Mail::to($adminEmails)->send(new LowStockNotification($this->products));
    }
}
