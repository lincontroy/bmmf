<?php

namespace App\Enums;

enum OtpVerifyStatusEnum: string {
    case CANCELED = '0';
    case USED     = '1';
    case NEW      = '2';
}
