<?php

namespace Modules\B2xloan\App\Services;

use Modules\B2xloan\App\Repositories\Interfaces\B2xLoanRepayRepositoryInterface;

class B2xLoanRepayService
{
    /**
     * B2xLoanService constructor.
     *
     */
    public function __construct(
        private B2xLoanRepayRepositoryInterface $b2xLoanRepayRepositoryInterface,
    ) {
    }
}
