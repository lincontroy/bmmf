<?php

namespace Modules\B2xloan\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\B2xloan\App\Models\B2xCurrency;
use Modules\B2xloan\App\Repositories\Interfaces\B2xCurrencyRepositoryInterface;

class B2xCurrencyRepository extends BaseRepository implements B2xCurrencyRepositoryInterface
{
    public function __construct(B2xCurrency $model)
    {
        parent::__construct($model);
    }
}
