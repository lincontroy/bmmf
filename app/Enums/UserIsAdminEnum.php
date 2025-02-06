<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum UserIsAdminEnum: string {
    use EnumToArray;

    case NOT_ADMIN  = '0';
    case ADMIN      = '1';
}
