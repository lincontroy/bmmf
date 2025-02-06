<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Merchant\App\Models\MerchantWithdraw;
use Modules\Merchant\App\Repositories\Interfaces\WithdrawRepositoryInterface;

class WithdrawRepository extends BaseRepository implements WithdrawRepositoryInterface
{
    public function __construct(MerchantWithdraw $model)
    {
        parent::__construct($model);
    }
}
