<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum SiteAlignEnum: string
{
    use EnumToArray;

    case LEFT_TO_RIGHT = 'LTR';
    case RIGHT_TO_LEFT = 'RTL';
}
