<?php

namespace Modules\Package\App\Enums;

use App\Traits\EnumToArray;

enum InvestTypeEnum: string
{
    use EnumToArray;


    case RANGE = '1';
    case FIXED = '2';
}
