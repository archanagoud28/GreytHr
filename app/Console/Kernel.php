<?php

namespace App\Console;

use App\Console\Commands\ExportDataEntries;
use App\Console\Commands\ManageSwipeRecordsTables;
use App\Console\Commands\ScheduledExportDataEntries;
use App\Console\Commands\SendEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendTaskReminder;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        ScheduledExportDataEntries::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('generate:monthly-leaves')->monthly();
        // $schedule->command('export:data-entries')->everyFifteenMinutes();
        // $schedule->command('export:data-entries')->everyMinute();
        // $schedule->command(SendTaskReminder::class)->everyMinute();
        // $schedule->command('app:manage-swipe-records-tables')->monthlyOn(1, '00:00');
        $schedule->command(ManageSwipeRecordsTables::class)->monthlyOn(1, '00:00');
        // $schedule->command(ManageSwipeRecordsTables::class)->everyMinute();
    }

    /**
     * Register the commands for the application.
     */

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
