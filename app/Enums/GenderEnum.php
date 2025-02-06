<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum GenderEnum: string {
    use EnumToArray;

    case MALE   = '1';
    case FEMALE = '0';
}
