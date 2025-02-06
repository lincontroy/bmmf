<?php

namespace Modules\CMS\App\Enums;

use App\Traits\EnumToArray;

enum CMSMenuListEnum: string {
    use EnumToArray;

    case HEADER = 'Header';
    case FOOTER = 'Footer';
}
