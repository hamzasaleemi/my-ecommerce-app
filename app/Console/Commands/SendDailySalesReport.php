<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendDailySalesReportEmail;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-email:daily-sales-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report to admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new SendDailySalesReportEmail());
    }
}
