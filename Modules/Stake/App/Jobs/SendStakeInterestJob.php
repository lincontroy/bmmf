<?php

namespace Modules\Stake\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Stake\App\Services\StakeInterestService;

class SendStakeInterestJob implements ShouldQueue
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
        $stakeInterestService = app(StakeInterestService::class);

        $stakeInterestService->findRedeemedStake()
            ->chunk($this->limit, function ($stake) use ($stakeInterestService) {

                foreach ($stake as $key => $value) {
                    $stakeInterestService->sendInterest($value);
                }

            });
    }

}
