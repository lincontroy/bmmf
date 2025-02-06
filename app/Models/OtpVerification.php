<?php

namespace App\Models;

use App\Enums\OtpVerifyStatusEnum;
use App\Enums\OtpVerifyTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'verify_type',
        'code',
        'verify_data',
        'status',
        'expired_at',
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'verify_type' => OtpVerifyTypeEnum::class,
        'code'        => 'string',
        'verify_data' => 'string',
        'status'      => OtpVerifyStatusEnum::class,
        'expired_at'  => 'datetime',
    ];
}
