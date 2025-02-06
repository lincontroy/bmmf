<?php

namespace Modules\Stake\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Stake\App\Models\CustomerStake;
use Modules\Stake\App\Repositories\Interfaces\CustomerStakeRepositoryInterface;

class CustomerStakeRepository extends BaseRepository implements CustomerStakeRepositoryInterface
{
    public function __construct(CustomerStake $model)
    {
        parent::__construct($model);
    }
}
