<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PermissionActionEnum: string {
    use EnumToArray;

    case READ   = 'read';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
}
