<?php

namespace Modules\Package\App\Enums;

use App\Traits\EnumToArray;

enum CoinSymbolEnum: string
{
    use EnumToArray;
    case USD = 'USD';
}
