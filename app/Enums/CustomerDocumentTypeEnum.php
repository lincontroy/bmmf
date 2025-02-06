<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum CustomerDocumentTypeEnum: string {
    use EnumToArray;

    case PASSPORT        = 'Passport';
    case DRIVING_LICENSE = 'Driving License';
    case VOTER_ID_CARD   = 'Voter Id Card';
}
