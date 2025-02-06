<?php

namespace Modules\B2xloan\App\Enums;

use App\Traits\EnumToArray;

enum B2xLoanRepaymentStatusEnum: string
{
    use EnumToArray;

    case PENDING = '0';
    case SUCCESS = '1';
}
