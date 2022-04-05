<?php

namespace App\Listeners;

use App\Events\MonthlyReportEvent;
use App\Mail\MonthlyReport;
use Illuminate\Support\Facades\Mail;

class SendMonthlyReport
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(MonthlyReportEvent $event): void
    {
        $recipients = [];

        if (config('settings.reports_email') !== null) {
            $recipients[] = ['email' => explode(',', config('settings.reports_email'))];
        }

        Mail::to($recipients)->queue(new MonthlyReport());
    }
}
