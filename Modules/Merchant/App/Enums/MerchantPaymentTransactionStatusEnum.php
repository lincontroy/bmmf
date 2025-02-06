<?php

namespace Modules\Merchant\App\Enums;

use App\Traits\EnumToArray;

enum MerchantPaymentTransactionStatusEnum: string {

    use EnumToArray;

    case COMPLETE  = '1';
    case PENDING   = '2';
    case CANCELLED = '0';
}
