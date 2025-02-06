<?php

namespace App\Console;

use App\Jobs\CurrencyPriceUpdateJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Package\App\Jobs\SendCapitalReturnJob;
use Modules\Package\App\Jobs\SendInvestmentInterestJob;
use Modules\Stake\App\Jobs\SendStakeInterestJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            dispatch(new CurrencyPriceUpdateJob);
        })->everyFiveMinutes();

        $schedule->call(function () {
            dispatch(new SendStakeInterestJob);
        })->daily();

        $schedule->call(function () {
            dispatch(new SendInvestmentInterestJob);
        })->hourly();

        $schedule->call(function () {
            dispatch(new SendCapitalReturnJob);
        })->hourly();
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
