<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily warranty-expiring reminders (30 days before expiry)
Schedule::command('vbs:send-warranty-reminders --days=30')
    ->dailyAt('09:00')
    ->onOneServer();

// Final warning at 7 days
Schedule::command('vbs:send-warranty-reminders --days=7')
    ->dailyAt('09:15')
    ->onOneServer();
