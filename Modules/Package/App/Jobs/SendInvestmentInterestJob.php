<?php

namespace Modules\Package\App\Jobs;

use App\Services\AcceptCurrencyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Package\App\Services\PackageService;

class SendInvestmentInterestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $limit;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->limit = 1000;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $packageService  = app(PackageService::class);
        $currencyService = app(AcceptCurrencyService::class);

        $currencyInfo = $currencyService->findCurrencyBySymbol('USD');

        $packageService->findInvestmentForInterest()
            ->chunk($this->limit, function ($investment) use ($currencyInfo, $packageService) {

                foreach ($investment as $key => $value) {
                    $packageService->sendInterest($value, $currencyInfo->id);
                }

            });
    }

}
