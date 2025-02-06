<?php

namespace Modules\Stake\App\Enums;

use App\Traits\EnumToArray;

enum CustomerStakeEnum: string {
    use EnumToArray;

    case REDEEMED        = "0";
    case RUNNING         = "1";
    case REDEEMED_ENABLE = "2";
}