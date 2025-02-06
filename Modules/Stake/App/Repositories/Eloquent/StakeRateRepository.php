<?php

namespace Modules\Stake\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Stake\App\Models\StakeRateInfo;
use Modules\Stake\App\Repositories\Interfaces\StakeRateRepositoryInterface;

class StakeRateRepository extends BaseRepository implements StakeRateRepositoryInterface
{
    public function __construct(StakeRateInfo $model)
    {
        parent::__construct($model);
    }

}
