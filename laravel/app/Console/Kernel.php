<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\LatePaymentReminders\ADayPassed;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ProjectionsList::class,
        ProjectionsRebuild::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function (EventStore $eventStore) {
            $eventStore->storeEvent(new ADayPassed(new \DateTimeImmutable('now')));
        })->dailyAt('23:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path('routes/console.php');
    }
}
