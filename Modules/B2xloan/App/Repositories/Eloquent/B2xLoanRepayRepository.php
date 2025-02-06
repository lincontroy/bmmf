<?php

namespace Modules\B2xloan\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\B2xloan\App\Models\B2xLoanRepay;
use Modules\B2xloan\App\Repositories\Interfaces\B2xLoanRepayRepositoryInterface;

class B2xLoanRepayRepository extends BaseRepository implements B2xLoanRepayRepositoryInterface
{
    public function __construct(B2xLoanRepay $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): object
    {
        return $this->model->create($attributes);
    }
}
