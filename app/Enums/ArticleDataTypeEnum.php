<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum ArticleDataTypeEnum: string {
    use EnumToArray;

    case IMAGE        = 'image';
    case URL          = 'url';
    case NAME         = 'name';
    case COMPANY_NAME = 'company_name';
    case DESIGNATION  = 'designation';
}
