<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum InvestTypeStatus: string {
    use EnumToArray;
    
    case RANGE = '1';
    case FIXED = '2';
}
