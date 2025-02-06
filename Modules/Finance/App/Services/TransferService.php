<?php

namespace Modules\Finance\App\Services;

use App\Enums\CustomerStatusEnum;
use App\Enums\CustomerVerifyStatusEnum;
use App\Enums\FeeSettingLevelEnum;
use App\Enums\OtpVerifyTypeEnum;
use App\Enums\TransactionTypeEnum;
use App\Enums\TxnTypeEnum;
use App\Enums\WalletManageLogEnum;
use App\Services\AcceptCurrencyService;
use App\Services\CurrencyConvertService;
use App\Services\CustomerService;
use App\Services\FeeSettingService;
use App\Services\NotificationService;
use App\Services\OtpVerificationService;
use App\Services\TxnFeeReportService;
use App\Services\TxnReportService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Finance\App\Enums\TransferStatusEnum;
use Modules\Finance\App\Repositories\Interfaces\TransferRepositoryInterface;

class TransferService
{
    /**
     * TransferService constructor.
     *
     */
    public function __construct(
        private TransferRepositoryInterface $transferRepository,
        private WalletManageService $walletManageService,
        private WalletTransactionLogService $walletTransactionLogService,
        private AcceptCurrencyService $acceptCurrencyService,
        private FeeSettingService $feeSettingService,
        private OtpVerificationService $verificationService,
        private CustomerService $customerService,
        private TxnReportService $txnReportService,
        private TxnFeeReportService $txnFeeService,
        private NotificationService $notificationService,
        private CurrencyConvertService $currencyConvertService
    ) {
    }

    /**
     * get data by id
     * @param array $attributes
     * @return object
     */
    public function getAllReceived(array $attributes): object
    {
        $attributes['receiver_user_id'] = $attributes['customer_id'];
        return $this->transferRepository->getAllReceived($attributes);
    }

    /**
     * get data by id
     * @param array $attributes
     * @return object
     */
    public function getAllTransfer(array $attributes): object
    {
        $attributes['sender_user_id'] = $attributes['customer_id'];
        return $this->transferRepository->getAllTransfer($attributes);
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        return $this->transferRepository->find($id);

    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function transferDetails($id): object
    {
        return $this->transferRepository->transferDetails($id);

    }

    /**
     * Create credit
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();
            $credit = $this->transferRepository->create($attributes);
            DB::commit();

            return $credit;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Update deposit
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $depositId = $attributes['deposit_id'];

        try {
            DB::beginTransaction();

            $this->transferRepository->updateById($depositId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Deposit update error"),
                'title'   => localize('Deposit'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Transfer Verify
     * @param array $attributes
     * @return object
     */
    public function transferVerify(array $attributes): ?object
    {

        if (auth()->user()->status->value != CustomerStatusEnum::ACTIVE->value) {
            return (object) [
                'status'  => 'error',
                'message' => localize('To proceed with the transfer, you must first activate your account.'),
            ];
        }

        if (auth()->user()->verified_status->value != CustomerVerifyStatusEnum::VERIFIED->value) {
            return (object) [
                'status'  => 'error',
                'message' => localize('To proceed with the transfer, you must first complete the KYC verification.'),
            ];
        }

        $receiverInfo = $this->customerService->findCustomer(['user' => $attributes['receiver_user']]);

        if (!$receiverInfo) {
            return (object) [
                'status'  => 'error',
                'message' => localize('The receiver account is invalid!'),
            ];
        }

        $currencyData = $this->acceptCurrencyService->findCurrencyBySymbol($attributes['payment_currency']);

        if (!$currencyData) {
            return (object) [
                'status'  => 'error',
                'message' => localize('Invalid Currency'),
            ];
        }

        $feesInfo = $this->feeSettingService->findFeeByLevel(FeeSettingLevelEnum::TRANSFER->value);
        $fees     = 0;

        if ($feesInfo) {
            $fees = $attributes['transfer_amount'] * ($feesInfo->fee / 100);
        }

        $totalTransfer = $attributes['transfer_amount'] + $fees;

        $walletBalanceData = $this->walletManageService->walletBalance([
            'user_id'     => auth()->user()->user_id,
            'currency_id' => $currencyData->id,
        ]);

        if (!$walletBalanceData || $walletBalanceData->balance < $totalTransfer) {
            return (object) [
                'status'  => 'error',
                'message' => localize('You do not have sufficient balance.'),
            ];
        }

        return (object) ['status' => 'success', 'data' => [
            'transfer_amount'    => $attributes['transfer_amount'],
            'fees'               => $fees,
            'total_transfer'     => $totalTransfer,
            'accept_currency_id' => $currencyData->id,
            'currency_name'      => $currencyData->name,
            'currency_symbol'    => $attributes['payment_currency'],
            'receiver_user'      => $receiverInfo->user_id,
            'receiver_id'        => $receiverInfo->id,
            'transfer_comments'  => $attributes['transfer_comments'],
            'wallet_id'          => $walletBalanceData->id,
        ]];
    }

    /**
     * Make Transfer
     * @param array $attributes
     * @return object
     */
    public function makeTransfer(array $attributes): ?object
    {
        $transferData = json_encode($attributes);

        $otpVerifyData = $this->verificationService->create([
            'customer_id' => auth()->user()->id,
            'verify_type' => OtpVerifyTypeEnum::TRANSFER->value,
            'verify_data' => $transferData,
            'subject'     => 'Transfer Verification',
            'htmlData'    => 'You are about to transfer '
            . $attributes['total_transfer'] . ' ' . $attributes['currency_symbol'] . ' to the account ' .
            $attributes['receiver_user'],
        ]);

        return $otpVerifyData;
    }

    public function confirmTransfer(int $verifyId): object
    {
        $verifyData = $this->verificationService->findOtpData($verifyId);

        if (!$verifyData) {
            return (object) ['status' => 'error', 'message' => localize('Wrong transfer data')];
        }

        $transferData = json_decode($verifyData->verify_data);

        try {

            DB::beginTransaction();

            $now      = Carbon::now();
            $dateOnly = $now->format('Y-m-d');

            $this->transferRepository->create([
                'sender_user_id'   => auth()->user()->user_id,
                'receiver_user_id' => $transferData->receiver_user,
                'currency_symbol'  => $transferData->currency_symbol,
                'amount'           => $transferData->transfer_amount,
                'fees'             => $transferData->fees,
                'date'             => $dateOnly,
                'comments'         => $transferData->transfer_comments,
                'status'           => TransferStatusEnum::DONE->value,
            ]);

            $receiverBalance = [
                'received' => $transferData->transfer_amount,
            ];
            $this->walletManageService->create([
                'accept_currency_id' => $transferData->accept_currency_id,
                'user_id'            => $transferData->receiver_user,
                'balance'            => $transferData->transfer_amount,
                ...$receiverBalance,
            ]);

            $this->walletTransactionLogService->create([
                'user_id'            => $transferData->receiver_user,
                'accept_currency_id' => $transferData->accept_currency_id,
                'transaction'        => WalletManageLogEnum::RECEIVED->value,
                'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                'amount'             => $transferData->transfer_amount,
            ]);

            $this->walletManageService->balanceDeduct([
                'transfer'     => $transferData->total_transfer,
                'transfer_fee' => $transferData->fees,
                'balance'      => $transferData->total_transfer,
            ], $transferData->wallet_id);

            $this->walletTransactionLogService->create([
                'user_id'            => auth()->user()->user_id,
                'accept_currency_id' => $transferData->accept_currency_id,
                'transaction'        => WalletManageLogEnum::TRANSFER->value,
                'transaction_type'   => TransactionTypeEnum::DEBIT->value,
                'amount'             => $transferData->total_transfer,
            ]);

            $convertRate = 1;

            if ($transferData->currency_symbol != "USD") {
                $transferUsdAmount = $this->currencyConvertService->coinRate($transferData->currency_name);

                if ($transferUsdAmount->status == "success") {
                    $convertRate = $transferUsdAmount->rate;
                }

            }

            $this->txnReportService->create([
                'customer_id'        => auth()->user()->id,
                'accept_currency_id' => $transferData->accept_currency_id,
                'txn_type'           => TxnTypeEnum::TRANSFER->value,
                'amount'             => $transferData->total_transfer,
                'usd_value'          => $convertRate * $transferData->transfer_amount,
            ]);

            if ($transferData->fees > 0) {
                $feesUsdValue = number_format($convertRate * $transferData->fees, 2, '.', '');
                $this->txnFeeService->create([
                    'customer_id'        => auth()->user()->id,
                    'accept_currency_id' => $transferData->accept_currency_id,
                    'txn_type'           => TxnTypeEnum::TRANSFER->value,
                    'fee_amount'         => $transferData->fees,
                    'usd_value'          => $feesUsdValue,
                ]);
            }

            $this->notificationService->create([
                'customer_id'       => auth()->user()->id,
                'notification_type' => 'transfer',
                'subject'           => 'Transfer',
                'details'           => 'Your transfer of ' . $transferData->total_transfer . ' '
                . $transferData->currency_symbol . ' has been successfully processed.',
            ]);

            $this->notificationService->create([
                'customer_id'       => $transferData->receiver_id,
                'notification_type' => 'transfer',
                'subject'           => 'Transfer',
                'details'           => 'You have received an amount of ' . $transferData->total_transfer
                . $transferData->currency_symbol . ' from ' . auth()->user()->user_id,
            ]);

            DB::commit();

            return (object) ['status' => 'success'];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

}
