<?php

namespace App\Enums;

enum OtpVerifyTypeEnum: string {
    case TRANSFER       = '1';
    case WITHDRAW       = '2';
    case PROFILE_UPDATE = '3';
    case LOGIN          = '4';
    case OTHERS         = '0';
}
