<?php

namespace Modules\Merchant\App\Services;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Enums\MerchantPaymentInfoStatusEnum;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentInfoRepositoryInterface;

class MerchantPaymentInfoService
{
    /**
     * MerchantPaymentInfoService constructor.
     *
     * @param MerchantPaymentInfoRepositoryInterface $merchantPaymentInfoRepository
     */
    public function __construct(
        private MerchantPaymentInfoRepositoryInterface $merchantPaymentInfoRepository,
    ) {
    }

    /**
     * Find Merchant Payment Info or throw 404
     *
     * @param  int  $id
     * @return object|null
     */
    public function findOrFail(int $id): ?object
    {
        return $this->merchantPaymentInfoRepository->findOrFail($id);
    }

    /**
     * Create Merchant Payment Info
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): ?object
    {

        if (!isset($attributes['status'])) {
            $attributes['status'] = MerchantPaymentInfoStatusEnum::PENDING->value;
        }

        try {
            DB::beginTransaction();

            $merchantPaymentInfo = $this->merchantPaymentInfoRepository->create($attributes);

            DB::commit();

            return $merchantPaymentInfo;

        } catch (Exception $exception) {

            DB::rollBack();

            if (request()->ajax()) {
                $response = response()->json([
                    'success' => false,
                    'message' => localize("Merchant Payment Info create error"),
                    'title'   => localize("Merchant Payment Info"),
                    'errors'  => $exception,
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

            } else {
                error_message(localize("Merchant Payment Info create error"));

                $response = redirect()->back()->withInput();
            }

            throw new HttpResponseException($response);
        }

    }

}
