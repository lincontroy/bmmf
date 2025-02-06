<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PermissionGroupEnum: string
{
    use EnumToArray;

    case DASHBOARD         = 'dashboard';
    case CUSTOMER          = 'customer';
    case B2X_LOAN          = 'b2x_loan';
    case FINANCE           = 'finance';
    case MERCHANT          = 'merchant';
    case PACKAGE           = 'package';
    case QUICK_EXCHANGE    = 'quick_exchange';
    case REPORTS           = 'reports';
    case STAKE             = 'stake';
    case SUPPORT           = 'support';
    case ROLES_MANAGER     = 'roles_manager';
    case PAYMENTS_SETTING  = 'payments_setting';
    case CMS               = 'cms';
    case SETTING           = 'setting';
}
