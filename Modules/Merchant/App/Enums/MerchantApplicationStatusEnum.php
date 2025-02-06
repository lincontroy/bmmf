<?php

namespace Modules\Merchant\App\Enums;

use App\Traits\EnumToArray;

enum MerchantApplicationStatusEnum: string
{
    use EnumToArray;

    case REJECT = '0';
    case APPROVED = '1';
    case PENDING = '2';
    case SUSPEND = '3';
}
