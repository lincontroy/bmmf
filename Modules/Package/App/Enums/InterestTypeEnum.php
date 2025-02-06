<?php

namespace Modules\Package\App\Enums;

use App\Traits\EnumToArray;

enum InterestTypeEnum: string
{
    use EnumToArray;

    case PERCENT = '1';
    case FIXED = '2';
}
