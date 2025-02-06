<?php

namespace Modules\Merchant\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Merchant\App\Models\MerchantFee;
use Modules\Merchant\App\Repositories\Interfaces\MerchantFeeRepositoryInterface;

class MerchantFeeRepository extends BaseRepository implements MerchantFeeRepositoryInterface
{
    public function __construct(MerchantFee $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        return parent::create($attributes);
    }


}
