<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum InterestTypeStatus: string {
    use EnumToArray;

    case PERCENT = '1';
    case FIXED   = '2';
}
