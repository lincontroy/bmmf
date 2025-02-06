<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum InvestDetailStatusEnum: string
{
    use EnumToArray;

    case PAUSE = '0';
    case COMPLETE = '1';
    case RUNNING = '2';
}
