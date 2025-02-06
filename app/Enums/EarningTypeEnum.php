<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum EarningTypeEnum: string
{
    use EnumToArray;

    case REFERRAL_COMMISSION = 'referral_commission';
    case ROI = 'roi';
}
