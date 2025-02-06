<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum NotificationSetupGroupEnum: string {

    use EnumToArray;

    case EMAIL = 'Email';
    case SMS   = 'SMS';
}
