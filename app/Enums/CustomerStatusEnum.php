<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum CustomerStatusEnum: string
{
    use EnumToArray;

    case ACTIVE = '1';
    case DEACTIVE = '0';
    case PENDING = '2';
    case SUSPEND = '3';
}
