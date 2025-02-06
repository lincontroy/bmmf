<?php

namespace App\Enums;

enum ErrorEnum: string
{
    case FILTER_ERROR = 'Filter Error';
    case VALIDATION_FAILED = 'Validation Failed';
}