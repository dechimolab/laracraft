<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily automatic package stats synchronization (03:00 AM)
Schedule::command('generator:sync-packages --trigger=cron_scheduler')
    ->dailyAt('03:00')
    ->withoutOverlapping();

