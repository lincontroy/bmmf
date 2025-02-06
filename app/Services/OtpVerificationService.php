<?php

namespace App\Services;

use App\Enums\OtpVerifyStatusEnum;
use App\Repositories\Interfaces\OtpVerificationRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OtpVerificationService
{
    public function __construct(
        private OtpVerificationRepositoryInterface $otpVerificationRepository,
        private EmailService $emailService,
        private SettingService $settingService
    ) {

    }

    /**
     * Create Notification
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): ?object
    {
        $settingData = $this->settingService->findById();
        $verifyCode  = Str::upper(Str::random(6));

        $mailSendResult = $this->emailService->send([
            'to'       => auth()->user()->email,
            'title'    => $settingData->title ?? 'OTP Verification',
            'subject'  => $attributes['subject'],
            'htmlData' => $attributes['htmlData'] . '<br> Your verification code is <h1>' . $verifyCode . '</h1>',
        ]);

        if ($mailSendResult->status != "success") {
            return $mailSendResult;
        }

        try {

            $expiryTimeInfo = Carbon::now()->addMinutes(20);
            $expiryTime     = $expiryTimeInfo->format('Y-m-d H:i:s');

            $attributesData = [
                'customer_id' => $attributes['customer_id'],
                'verify_type' => $attributes['verify_type'],
                'code'        => $verifyCode,
                'verify_data' => $attributes['verify_data'],
                'expired_at'  => $expiryTime,
            ];

            DB::beginTransaction();

            $otpVerifyData = $this->otpVerificationRepository->create($attributesData);

            DB::commit();

            return (object) ['status' => 'success', 'data' => $otpVerifyData];

        } catch (Exception $exception) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $exception->getMessage()];
        }

    }

    /**
     * Verify OTP Code
     * @param array $attributes
     * @return object
     */
    public function otpVerify(array $attributes): ?object
    {
        $verifyResult = $this->otpVerificationRepository->verifyOtp($attributes);

        if ($verifyResult) {

            $this->otpVerificationRepository->updateById($verifyResult->id, ['status' => OtpVerifyStatusEnum::USED->value]);

            return (object) ['status' => 'success', 'data' => $verifyResult];
        } else {
            return (object) ['status' => 'error', 'message' => 'Invalid Verification Code'];
        }

    }

    /**
     * Find OTP Data by Id
     * @param int $id
     * @return object|null
     */
    public function findOtpData(int $id): ?object
    {
        return $this->otpVerificationRepository->find($id);
    }

}
