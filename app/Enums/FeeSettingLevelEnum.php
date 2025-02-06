<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum FeeSettingLevelEnum: string {

    use EnumToArray;

    case DEPOSIT  = 'Deposit';
    case TRANSFER = 'Transfer';
    case WITHDRAW = 'Withdraw';
    case REPAYMENT = 'Repayment';
    case MERCHANT = 'Merchant';
}
