<?php

namespace App\Services\Customer;

use App\Enums\AuthGuardEnum;
use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use App\Repositories\Interfaces\TxnReportRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class CustomerService
{
    /**
     * CustomerService constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param TxnReportRepositoryInterface $txnReportRepository
     * @param SettingRepositoryInterface $settingRepository
     */
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
        protected TxnReportRepositoryInterface $txnReportRepository,
        protected SettingRepositoryInterface $settingRepository
    ) {
    }

    /**
     * Update customer information
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        $customerPassword = $attributes['account_password'];

        /**
         * Check customer current password
         */

        if (!Hash::check($customerPassword, auth(AuthGuardEnum::CUSTOMER->value)->user()->password)) {  
            error_message(localize("Wrong Password!"));
            return false;
        }

        try {
            DB::beginTransaction();

            $this->customerRepository->updateCustomerInformation($customer->id, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            error_message(localize("Customer Information update error")); 
            return false;
        }

    }

    /**
     * Update customer avatar
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update_avatar(array $attributes): bool
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        $avatar = ImageHelper::upload($attributes['avatar'] ?? null, 'customer', $customer->avatar ?? null);

        try {
            DB::beginTransaction();

            $this->customerRepository->updateAvatar($customer->id, $avatar);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => "Customer Avatar update error",
                    'title'   => 'Customer Avatar',
                    'errors'  => $exception,
                ], 422)
            );
        }

    }

    /**
     * Update customer password
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function updatePassword(array $attributes): bool
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        $customerPassword = $attributes['old_password'];

        /**
         * Check customer current password
         */

        if (!Hash::check($customerPassword, auth(AuthGuardEnum::CUSTOMER->value)->user()->password)) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Wrong Password!"),
            ], JsonResponse::HTTP_UNAUTHORIZED));
        }

        try {
            DB::beginTransaction();

            $this->customerRepository->updatePassword($customer->id, $attributes['password']);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Customer last login Customer Password update error"),
                    'title'   => localize('Customer last login word'),
                    'errors'  => $exception,
                ], 422)
            );
        }

    }

    /**
     * Two Factor Form Data
     *
     * @return array
     */
    public function twoFactorFormData(): array
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();
        $setting  = $this->settingRepository->first();

        if ($customer->google2fa_enable) {
            return compact('customer');
        }

        $google2fa = new Google2FA();

        if (session()->has('google2fa_secret_key')) {
            $secretKey = session()->get('google2fa_secret_key');
        } else {
            $secretKey = $google2fa->generateSecretKey();
            session()->put('google2fa_secret_key', $secretKey);
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            $setting->title,
            $setting->email,
            $secretKey
        );
        $qrImage = qr_code_simple_in_base_64($qrCodeUrl);
        return compact('customer', 'secretKey', 'qrImage');

    }

    /**
     * Update two factor verification
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function updateTwoFactorVerification(array $attributes): bool
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        $verificationCode = $attributes['verification_code'];

        if ($customer->google2fa_enable) {
            $google2fa = new Google2FA();

            $verifyStatus = $google2fa->verifyKey($customer->google2fa_secret, $verificationCode);

            /**
             * Google fa verify key check
             */

            if (!$verifyStatus) {
                throw new HttpResponseException(
                    response()->json([
                        'success' => false,
                        'message' => localize("Verification Code not match"),
                        'title'   => localize("Verification code"),
                    ], 422)
                );
            }

            try {
                DB::beginTransaction();

                $this->customerRepository->removeGoogle2faAuth($customer->id);

                DB::commit();

                return true;
            } catch (Exception $exception) {
                DB::rollBack();

                throw new HttpResponseException(
                    response()->json([
                        'success' => false,
                        'message' => localize("Two Factor Verification remove error"),
                        'title'   => localize('Two Factor Verification'),
                        'errors'  => $exception,
                    ], 422)
                );
            }

        } else {
            /**
             * Google fa Secret key check
             */

            if (!session()->has('google2fa_secret_key')) {
                throw new HttpResponseException(
                    response()->json([
                        'success' => false,
                        'message' => localize("secret key not found"),
                        'title'   => localize("Secret Key Error"),
                    ], 422)
                );
            }

            $secretKey = session()->get('google2fa_secret_key');

            $google2fa = new Google2FA();

            $verifyStatus = $google2fa->verifyKey($secretKey, $verificationCode);

            /**
             * Google fa verify key check
             */

            if (!$verifyStatus) {
                throw new HttpResponseException(
                    response()->json([
                        'success' => false,
                        'message' => localize("Verification Code not match"),
                        'title'   => localize("Verification code"),
                    ], 422)
                );
            }

            try {
                DB::beginTransaction();

                $this->customerRepository->addGoogle2faAuth($customer->id, $secretKey);

                session()->forget('google2fa_secret_key');

                DB::commit();

                return true;
            } catch (Exception $exception) {
                DB::rollBack();

                throw new HttpResponseException(
                    response()->json([
                        'success' => false,
                        'message' => localize("Two Factor Verification add error"),
                        'title'   => localize('Two Factor Verification'),
                        'errors'  => $exception,
                    ], 422)
                );
            }

        }

    }

    /**
     * Last Login
     *
     * @param string $ip
     * @return boolean
     */
    public function lastLogin(string $ip): bool
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        try {
            DB::beginTransaction();

            $attributes = [
                'visitor'    => $ip,
                'last_login' => date("Y-m-d H:i:s"),
            ];

            $this->customerRepository->updateLastLogin($customer->id, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Customer last login update error"),
                    'title'   => localize('Customer last login'),
                    'errors'  => $exception,
                ], 422)
            );
        }

    }

    /**
     * Last Logout
     *
     * @return boolean
     */
    public function lastLogout(): bool
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        try {
            DB::beginTransaction();

            $attributes = [
                'last_logout' => date("Y-m-d H:i:s"),
            ];

            $this->customerRepository->updateLastLogout($customer->id, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Customer last login update error"),
                    'title'   => localize('Customer last login'),
                    'errors'  => $exception,
                ], 422)
            );
        }

    }

    /**
     * Find customer by user Id
     * @param string $userId
     * @return object|null
     */
    public function findCustomerByUserId(string $userId): ?object
    {
        return $this->customerRepository->firstWhere('user_id', $userId);
    }

    /**
     * Find Customer` or throw 404
     *
     * @param  array  $attribute
     * @return object|null
     */
    public function findByAttributes(array $attribute): ?object
    {
        return $this->customerRepository->findByAttributes($attribute);
    }

}
