<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SendOrderNotifications::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Send notifications for new orders every 5 minutes
        $schedule->command('notify:orders --status=process --days=1')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/order-notifications.log'));
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
} 