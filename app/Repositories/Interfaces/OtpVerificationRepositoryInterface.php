<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface OtpVerificationRepositoryInterface extends BaseRepositoryInterface
{
    public function verifyOtp(array $attributes): ?object;
}
