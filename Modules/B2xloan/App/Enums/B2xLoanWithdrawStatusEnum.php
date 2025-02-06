<?php

namespace Modules\B2xloan\App\Enums;

use App\Traits\EnumToArray;

enum B2xLoanWithdrawStatusEnum: string
{
    use EnumToArray;

    case CANCELED = '0';
    case SUCCESS = '1';
    case PENDING = '2';
    case NOT_SUBMIT = '3';
}
