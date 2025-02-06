<?php

namespace Modules\B2xloan\App\Enums;

use App\Traits\EnumToArray;

enum B2xLoanStatusEnum: string
{
    use EnumToArray;

    case REJECTED = '0';
    case APPROVED = '1';
    case PENDING = '2';
    case CLOSED = '3';
}