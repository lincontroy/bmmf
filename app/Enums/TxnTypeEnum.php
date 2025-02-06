<?php

namespace App\Enums;

enum TxnTypeEnum: string {
    case DEPOSIT  = '1';
    case WITHDRAW = '2';
    case TRANSFER = '3';
}