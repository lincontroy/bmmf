<?php
 
namespace Modules\Package\App\Enums;

use App\Traits\EnumToArray;

enum CapitalBackEnum: string
{
    use EnumToArray;
    case YES = '1';
    case NO = '0';
}