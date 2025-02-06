<?php

namespace App\Enums;

enum PaymentRequestStatusEnum: string {
    case SUCCESS = '1';
    case PENDING = '2';
    case EXECUTE = '3';
    case CANCEL  = '0';
}
