<?php

namespace Modules\Finance\App\Enums;

use App\Traits\EnumToArray;

enum WithdrawStatusEnum: string 
{
    use EnumToArray;

    case PENDING = '2';
    case SUCCESS = '1';
    case CANCEL  = '0';
}
