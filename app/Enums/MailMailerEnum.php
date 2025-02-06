<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum MailMailerEnum: string
{
    use EnumToArray;

    case SMTP     = 'smtp';
    case SENDMAIL = 'sendmail';
    case MAILGUN  = 'mailgun';
    case SES      = 'ses';
    case POSTMARK = 'postmark';
    case LOG      = 'log';
    case ARRAY    = 'array';
    case FAILOVER = 'failover';

}
