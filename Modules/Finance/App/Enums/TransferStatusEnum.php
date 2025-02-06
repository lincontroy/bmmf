<?php

namespace Modules\Finance\App\Enums;

use App\Traits\EnumToArray;

enum TransferStatusEnum: string
{
    use EnumToArray;

    case PENDING = '0';
    case DONE = '1';
}
