<?php

namespace Modules\Merchant\App\Enums;

use App\Traits\EnumToArray;

enum MerchantWithdrawEnum: string
{
    use EnumToArray;

    case PENDING = '1';
    case CONFIRM = '2';
    case CANCEL = '3';
}
