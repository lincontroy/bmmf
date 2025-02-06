<?php

namespace Modules\Stake\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Carbon\Carbon;
use Modules\Stake\App\Enums\CustomerStakeInterestEnum;
use Modules\Stake\App\Models\CustomerStakeInterest;
use Modules\Stake\App\Repositories\Interfaces\CustomerStakeInterestRepositoryInterface;

class CustomerStakeInterestRepository extends BaseRepository implements CustomerStakeInterestRepositoryInterface
{
    public function __construct(CustomerStakeInterest $model)
    {
        parent::__construct($model);
    }

    /**
     * Find redeemed able stake by redemption At
     * @return mixed
     */
    public function findRedeemedStake(): ?object
    {
        $nowTime = Carbon::now();

        return $this->model->where('status', CustomerStakeInterestEnum::RUNNING->value)
            ->where("redemption_at", "<=", $nowTime);
    }
}