<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum UserLogTypeEnum: string
{
    use EnumToArray;

    case LOGIN = 'login';
    case LOGOUT = 'logout';
}
