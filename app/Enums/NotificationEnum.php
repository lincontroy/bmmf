<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum NotificationEnum: string {

    use EnumToArray;

    case READ   = '0';
    case UNREAD = '1';
}
