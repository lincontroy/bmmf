<?php

namespace Modules\Stake\App\Enums;

use App\Traits\EnumToArray;

enum CustomerStakeInterestEnum: string {
    use EnumToArray;

    case RECEIVED = "1";
    case RUNNING  = "2";
}