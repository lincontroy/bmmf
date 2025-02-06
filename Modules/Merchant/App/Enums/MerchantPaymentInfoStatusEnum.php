<?php

namespace Modules\Merchant\App\Enums;

use App\Traits\EnumToArray;

enum MerchantPaymentInfoStatusEnum: string
{
    use EnumToArray;

    case CANCELED = '3';
    case COMPLETE = '1';
    case PENDING = '2';
}
