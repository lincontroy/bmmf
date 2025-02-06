<?php

namespace Modules\Finance\App\Enums;

use App\Traits\EnumToArray;

enum DepositEnum: string
{

    use EnumToArray;

    case PENDING    = '0';
    case CONFIRM    = '1';
    case CANCEL     = '2';
    case PROCESSING = '3';
}
