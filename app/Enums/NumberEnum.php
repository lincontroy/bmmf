<?php

namespace App\Enums;

enum NumberEnum: int {
    case DECIMAL                = 5;
    case QUICK_EXCHANGE_DECIMAL = 6;
    case MAX_DECIMAL            = 18;
    case MIN_DECIMAL            = 2;
}