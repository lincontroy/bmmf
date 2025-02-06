<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum UserStatusEnum: string {
    use EnumToArray;

    case INACTIVE  = '0';
    case ACTIVE    = '1';
    case PENDING   = '2';
    case SUSPEND   = '3';
}
