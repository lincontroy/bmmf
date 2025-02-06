<?php

namespace App\Services;

use App\Enums\PaymentRequestStatusEnum;
use App\Repositories\Interfaces\PaymentRequestRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PaymentRequestService
{
    public function __construct(
        private PaymentRequestRepositoryInterface $paymentRequestRepository
    ) {
    }

    /**
     * Find payment active transaction Id
     * @param array $attributes
     * @return object|null
     */
    public function findTxnId(array $attributes): ?object
    {
        return $this->paymentRequestRepository->findPendingTx($attributes);
    }

    /**
     * Create Payment Request
     * @param array $attributes
     * @return \App\Models\PaymentRequest
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();

            $createData = $this->paymentRequestRepository->create($attributes);

            DB::commit();

            if (!$createData) {
                return (object) ["status" => "error", "message" => "Something went wrong"];
            } else {
                return (object) ["status" => "success", "data" => $createData];
            }

        } catch (\Exception $exception) {
            DB::rollBack();

            return (object) ["status" => "error", "message" => $exception->getMessage()];
        }

    }

    /**
     * Find Transaction By Tx Token
     * @param string $txnToken
     * @return object|null
     */
    public function findTxByToken(string $txnToken): ?object
    {
        return $this->paymentRequestRepository->findDoubleWhereFirst(
            'txn_token',
            $txnToken,
            'tx_status',
            PaymentRequestStatusEnum::PENDING->value
        );
    }

    /**
     * Payment change status
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function changePaymentStatus(int $id, array $attributes): bool
    {
        return $this->paymentRequestRepository->updateById($id, $attributes);
    }

    /**
     * Find by attributes
     *
     * @param array $attributes
     * @param array $relations
     *
     * @return object|null
     */
    public function findByAttributes(array $attributes = [], array $relations = []): ?object
    {
        return $this->paymentRequestRepository->findByAttributes($attributes, $relations);
    }

}
