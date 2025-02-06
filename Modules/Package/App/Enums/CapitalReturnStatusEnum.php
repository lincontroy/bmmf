<?php

namespace Modules\Package\App\Enums;

use App\Traits\EnumToArray;

enum CapitalReturnStatusEnum: string
{
    use EnumToArray;
    case PENDING = '2';
    case DONE = '1';
}
