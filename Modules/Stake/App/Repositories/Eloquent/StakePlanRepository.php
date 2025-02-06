<?php

namespace Modules\Stake\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Stake\App\Models\StakePlan;
use Modules\Stake\App\Repositories\Interfaces\StakePlanRepositoryInterface;

class StakePlanRepository extends BaseRepository implements StakePlanRepositoryInterface
{
    public function __construct(StakePlan $model)
    {
        parent::__construct($model);
    }



    /**
     * get all Active data
     * @param array $attributes
     * @return object
     */
    public function allActive(array $attributes = []): object
    {
        return $this->model->newQuery()
                     ->where('status', $attributes['status'])
                     ->with('acceptCurrency')->with('stakeRateInfo')->get();
    }
}
