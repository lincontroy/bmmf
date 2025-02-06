<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum ReturnTypeStatus: string 
{
    use EnumToArray;

    case LIFE_TIME = '1';
    case REPEAT    = '2';
}
