<?php

namespace Modules\Merchant\App\Enums;

use App\Traits\EnumToArray;

enum MerchantPaymentUlrStatusEnum: string
{
    use EnumToArray;

    case ACTIVE     = '1';
    case EXPIRED    = '0';
}
