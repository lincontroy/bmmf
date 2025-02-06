<?php

namespace App\Repositories\Eloquent;

use App\Enums\OtpVerifyStatusEnum;
use App\Models\OtpVerification;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\OtpVerificationRepositoryInterface;
use Carbon\Carbon;

class OtpVerificationRepository extends BaseRepository implements OtpVerificationRepositoryInterface
{
    public function __construct(OtpVerification $model)
    {
        parent::__construct($model);
    }

    public function verifyOtp(array $attributes): ?object
    {
        return $this->model->where('customer_id', $attributes['customer_id'])
            ->where('verify_type', $attributes['verify_type'])
            ->where('code', $attributes['code'])
            ->where('status', OtpVerifyStatusEnum::NEW )
            ->where('expired_at', '>', Carbon::now())
            ->first();
    }
}
