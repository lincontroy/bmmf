<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PaymentRequestEnum: string {

    use EnumToArray;

    case DEPOSIT  = '1';
    case WITHDRAW = '2';
    case MERCHANT = '3';
    case REPAYMENT = '4';
}
