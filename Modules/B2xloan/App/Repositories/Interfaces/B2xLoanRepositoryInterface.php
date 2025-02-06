<?php

namespace Modules\B2xloan\App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface B2xLoanRepositoryInterface extends BaseRepositoryInterface
{
    public function pendingAndSuccessLoanAmount(array $attributes = []);
}
