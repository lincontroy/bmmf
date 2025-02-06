<?php

namespace Modules\Merchant\App\Services;

use App\Enums\PaymentRequestStatusEnum;
use App\Services\PaymentRequestService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Enums\MerchantPaymentInfoStatusEnum;
use Modules\Merchant\App\Enums\MerchantPaymentTransactionStatusEnum;
use Modules\Merchant\App\Repositories\Interfaces\MerchantAcceptCoinRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantBalanceRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentInfoRepositoryInterface;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentTransactionRepositoryInterface;

class PaymentDepositCallBackService
{
    /**
     * PaymentDepositCallBackService constructor.
     *
     * @param  MerchantPaymentTransactionRepositoryInterface $merchantPaymentTransactionRepository
     * @param  MerchantPaymentInfoRepositoryInterface $merchantPaymentInfoRepository
     * @param  MerchantAcceptCoinRepositoryInterface $merchantAcceptCoinRepository
     * @param  MerchantBalanceRepositoryInterface $merchantBalanceRepository
     */
    public function __construct(
        private MerchantPaymentTransactionRepositoryInterface $merchantPaymentTransactionRepository,
        private MerchantPaymentInfoRepositoryInterface $merchantPaymentInfoRepository,
        private MerchantAcceptCoinRepositoryInterface $merchantAcceptCoinRepository,
        private MerchantBalanceRepositoryInterface $merchantBalanceRepository,
        private PaymentRequestService $paymentRequestService,
    ) {
    }

    /**
     * Update Merchant Payment Transaction Status Complete
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function updateStatusByPaymentComplete($paymentRequests)
    {
        $txn_token = $paymentRequests['txn_token'];
        $amount    = $paymentRequests['txn_amount'];
        $feeAmount = $paymentRequests['fees'];

        if ($feeAmount > 0) {
            $amount = $amount - $feeAmount;
        }

        try {
            DB::beginTransaction();

            $response = false;

            $this->paymentRequestService->changePaymentStatus($paymentRequests['id'], [
                'usd_value' => $paymentRequests['usd_value'],
                'tx_status' => PaymentRequestStatusEnum::SUCCESS->value,
            ]);

            $merchantPaymentTransaction = $this->merchantPaymentTransactionRepository->findByAttributes([
                'transaction_hash' => $txn_token,
            ]);

            /**
             * Check Merchant Payment Transaction
             */

            if ($merchantPaymentTransaction) {
                $this->merchantPaymentTransactionRepository->updateStatusById($merchantPaymentTransaction->id, MerchantPaymentTransactionStatusEnum::COMPLETE->value);

                $merchantPaymentInfo = $this->merchantPaymentInfoRepository->findByAttributes([
                    'merchant_payment_transaction_id' => $merchantPaymentTransaction->id,
                ], ['merchantAccountInfo']);

                /**
                 * Check Merchant Payment Info
                 */

                if ($merchantPaymentInfo) {
                    $this->merchantPaymentInfoRepository->updateStatusAndAmountById($merchantPaymentInfo->id, [
                        'status'          => MerchantPaymentInfoStatusEnum::COMPLETE->value,
                        'received_amount' => $amount,
                    ]);

                    $merchantAcceptCoin = $this->merchantAcceptCoinRepository->findByIdWithAcceptCurrency($merchantPaymentInfo->merchant_accepted_coin_id);

                    /**
                     * Check Merchant Accept Coin
                     */

                    if ($merchantAcceptCoin) {
                        /**
                         * Create merchant balance
                         */
                        $this->merchantBalanceRepository->createOrUpdateAmount([
                            'accept_currency_id'  => $merchantAcceptCoin->accept_currency_id,
                            'symbol'              => $merchantAcceptCoin->acceptCurrency->symbol,
                            'merchant_account_id' => $merchantPaymentInfo->merchant_account_id,
                            'user_id'             => $merchantPaymentInfo->merchantAccountInfo->user_id,
                            'amount'              => $amount,
                        ]);

                        $response = true;
                    }

                }

            }

            DB::commit();

            return $response;

        } catch (Exception $exception) {

            DB::rollBack();

            return false;
        }

    }

    /**
     * Update Merchant Payment Transaction Status Cancel
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function updateStatusByPaymentCancel($transactionHas)
    {
        try {
            DB::beginTransaction();

            $merchantPaymentTransaction = $this->merchantPaymentTransactionRepository->findByAttributes([
                'transaction_hash' => $transactionHas,
            ]);

            /**
             * Check Merchant Payment Transaction
             */

            if ($merchantPaymentTransaction) {
                $this->merchantPaymentTransactionRepository->updateStatusById($merchantPaymentTransaction->id, MerchantPaymentTransactionStatusEnum::CANCELLED);
            }

            $merchantPaymentInfo = $this->merchantPaymentInfoRepository->findByAttributes([
                'merchant_payment_transaction_id' => $merchantPaymentTransaction->id,
            ]);

            /**
             * Check Merchant Payment Info
             */

            if ($merchantPaymentInfo) {
                $this->merchantPaymentInfoRepository->updateStatusAndAmountById($merchantPaymentInfo->id, [
                    'status' => MerchantPaymentInfoStatusEnum::CANCELED,
                ]);
            }

            DB::commit();

            return true;

        } catch (Exception $exception) {

            DB::rollBack();

            /**
             * Check Request type
             */

            if (request()->ajax()) {
                $response = response()->json([
                    'success' => false,
                    'message' => localize("Payment Deposit Callback update cancel status error"),
                    'title'   => localize("Payment Deposit Callback"),
                    'errors'  => $exception,
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $response = redirect()->back();
            }

            throw new HttpResponseException($response);
        }

    }

}
