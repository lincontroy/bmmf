<?php

namespace Modules\Merchant\App\Enums;

use App\Traits\EnumToArray;

enum MerchantPaymentUlrPaymentTypeEnum: string
{
    use EnumToArray;

    case SINGLE    = '0';
    case MULTIPLE  = '1';
}
