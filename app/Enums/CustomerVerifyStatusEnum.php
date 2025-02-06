<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum CustomerVerifyStatusEnum: string {

    use EnumToArray;

    case NOT_SUBMIT = '0';
    case VERIFIED   = '1';
    case CANCELED   = '2';
    case PROCESSING = '3';
}
