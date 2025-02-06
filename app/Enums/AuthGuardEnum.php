<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum AuthGuardEnum: string
{
    use EnumToArray;

    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case SANCTUM = 'sanctum';
    case CUSTOMER_HOME = 'customer/dashboard';
}