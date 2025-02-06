<?php
 
namespace Modules\Package\App\Enums;

use App\Traits\EnumToArray;

enum ReturnTypeEnum: string
{
    use EnumToArray;

    
    case LIFE_TIME = '1';
    case REPEAT = '2';
}