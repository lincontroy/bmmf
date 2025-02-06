<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum StatusEnum: string
{
    use EnumToArray;

    case SUCCESS           = 'success';
    case FAILED            = 'failed';
    case ACTIVE            = '1';
    case INACTIVE          = '0';
    case REJECTED          = '3';
    case REDEMPTION_ENABLE = '2';
}
