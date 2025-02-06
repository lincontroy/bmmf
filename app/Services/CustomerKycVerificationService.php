<?php

namespace App\Services;

use App\Enums\AuthGuardEnum;
use App\Enums\GenderEnum;
use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\CustomerVerifyRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CustomerKycVerificationService
{
    /**
     * CustomerKycVerificationService constructor.
     *
     * @param CustomerVerifyRepositoryInterface $customerVerifyRepository
     */
    public function __construct(
        private CustomerVerifyRepositoryInterface $customerVerifyRepository,
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    /**
     * Form data of app setting
     *
     * @return array
     */
    public function formData(): array
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();
        $genders  = GenderEnum::toArray();

        return compact('customer', 'genders');
    }

    /**
     * Create Customer Kyc Verification docs data
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        $attributes['customer_id'] = $customer->id;
        $attributes['document1']   = ImageHelper::upload($attributes['document1'] ?? null, 'kyc-verification');
        $attributes['document2']   = ImageHelper::upload($attributes['document2'] ?? null, 'kyc-verification');
        $attributes['document3']   = ImageHelper::upload($attributes['document3'] ?? null, 'kyc-verification');

        try {
            DB::beginTransaction();

            $customerVerifyDoc = $this->customerVerifyRepository->createCustomerVerifyDoc($attributes);

            $this->customerRepository->updateVerifiedStatus($customer->id, ['verified_status' => 3]);

            DB::commit();

            return $customerVerifyDoc;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Customer Kyc Verification create error"),
                'title'   => localize('Customer Kyc Verification'),
                'errors'  => $exception,
            ], 422));
        }
    }

}
