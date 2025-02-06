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
use App\Services\FeeSettingService;
use App\Services\NotificationService;
use App\Services\OtpVerificationService;
use App\Services\TxnFeeReportService;
use App\Services\TxnReportService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use App\Services\WithdrawalAccountService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Finance\App\Enums\WithdrawStatusEnum;
use Modules\Finance\App\Repositories\Interfaces\WithdrawRepositoryInterface;

class WithdrawService
{
    /**
     * WithdrawService constructor.
     *
     */
    public function __construct(
        private WithdrawRepositoryInterface $withdrawRepository,
        private WithdrawalAccountService $withdrawalAccountService,
        private AcceptCurrencyService $acceptCurrencyService,
        private FeeSettingService $feeSettingService,
        private WalletManageService $walletManageService,
        private OtpVerificationService $verificationService,
        private WalletTransactionLogService $walletTransactionLogService,
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
    public function getAll(array $attributes): object
    {
        return $this->withdrawRepository->getAll($attributes);
    }

    /**
     * Create withdraw
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): bool
    {
        return true;
    }

    /**
     * Update withdraw
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $withdrawId         = $attributes['withdraw_id'];
        $data['status']     = $attributes['set_status'];
        $data['updated_by'] = $attributes['updated_by'];

        try {
            DB::beginTransaction();

            $this->withdrawRepository->updateById($withdrawId, $data);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Withdraw update error"),
                'title'   => localize('Withdraw'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Withdraw Verify
     * @param array $attributes
     * @return object
     */
    public function withdrawVerify(array $attributes): ?object
    {

        if (auth()->user()->status->value != CustomerStatusEnum::ACTIVE->value) {
            return (object) [
                'status'  => 'error',
                'message' => localize('To proceed with the withdraw, you must first activate your account.'),
            ];
        }

        if (auth()->user()->verified_status->value != CustomerVerifyStatusEnum::VERIFIED->value) {
            return (object) [
                'status'  => 'error',
                'message' => localize('To proceed with the withdraw, you must first complete the KYC verification.'),
            ];
        }

        $withdrawalAccountData = $this->withdrawalAccountService->findWithdrawalAccount($attributes);

        if (!$withdrawalAccountData) {
            return (object) [
                'status'  => 'error',
                'message' => localize('You do not have withdrawal account'),
            ];
        }

        $currencyData = $this->acceptCurrencyService->findCurrencyBySymbol($attributes['payment_currency']);

        if (!$currencyData) {
            return (object) [
                'status'  => 'error',
                'message' => localize('Invalid Currency'),
            ];
        }

        $feesInfo = $this->feeSettingService->findFeeByLevel(FeeSettingLevelEnum::WITHDRAW->value);
        $fees     = 0;

        if ($feesInfo) {
            $fees = $attributes['withdraw_amount'] * ($feesInfo->fee / 100);
        }

        $totalWithdraw = $attributes['withdraw_amount'] + $fees;

        $walletBalanceData = $this->walletManageService->walletBalance([
            'user_id'     => auth()->user()->user_id,
            'currency_id' => $currencyData->id,
        ]);

        if (!$walletBalanceData || $walletBalanceData->balance < $totalWithdraw) {
            return (object) [
                'status'  => 'error',
                'message' => localize('You do not have sufficient balance.'),
            ];
        }

        return (object) ['status' => 'success', 'data' => [
            'gateway_id'          => $attributes['payment_method'],
            'withdraw_amount'     => $attributes['withdraw_amount'],
            'fees'                => $fees,
            'total_withdraw'      => $totalWithdraw,
            'accept_currency_id'  => $currencyData->id,
            'currency_name'       => $currencyData->name,
            'currency_symbol'     => $attributes['payment_currency'],
            'withdrawal_account'  => $withdrawalAccountData->id,
            'withdrawal_comments' => $attributes['withdrawal_comments'],
            'wallet_id'           => $walletBalanceData->id,
        ]];
    }

    /**
     * Make Withdraw
     * @param array $attributes
     * @return object
     */
    public function makeWithdraw(array $attributes): ?object
    {
        $withdrawData = json_encode($attributes);

        $otpVerifyData = $this->verificationService->create([
            'customer_id' => auth()->user()->id,
            'verify_type' => OtpVerifyTypeEnum::WITHDRAW->value,
            'verify_data' => $withdrawData,
            'subject'     => 'Withdrawal Verification',
            'htmlData'    => 'You are about to withdraw '
            . $attributes['total_withdraw'] . ' ' . $attributes['currency_symbol'],
        ]);

        return $otpVerifyData;
    }

    public function confirmWithdraw(int $verifyId): object
    {
        $verifyData = $this->verificationService->findOtpData($verifyId);

        if (!$verifyData) {
            return (object) ['status' => 'error', 'message' => localize('Wrong withdraw data')];
        }

        $withdrawData = json_decode($verifyData->verify_data);

        try {

            DB::beginTransaction();

            $this->withdrawRepository->create([
                'customer_id'           => auth()->user()->id,
                'payment_gateway_id'    => $withdrawData->gateway_id,
                'accept_currency_id'    => $withdrawData->accept_currency_id,
                'withdrawal_account_id' => $withdrawData->withdrawal_account,
                'amount'                => $withdrawData->withdraw_amount,
                'fees'                  => $withdrawData->fees,
                'comments'              => $withdrawData->withdrawal_comments,
                'status'                => WithdrawStatusEnum::PENDING->value,
            ]);

            $this->walletManageService->balanceDeduct([
                'withdraw'     => $withdrawData->total_withdraw,
                'withdraw_fee' => $withdrawData->fees,
                'balance'      => $withdrawData->total_withdraw,
            ], $withdrawData->wallet_id);

            $this->walletTransactionLogService->create([
                'user_id'            => auth()->user()->user_id,
                'accept_currency_id' => $withdrawData->accept_currency_id,
                'transaction'        => WalletManageLogEnum::WITHDRAW->value,
                'transaction_type'   => TransactionTypeEnum::DEBIT->value,
                'amount'             => $withdrawData->total_withdraw,
            ]);

            $this->notificationService->create([
                'customer_id'       => auth()->user()->id,
                'notification_type' => 'withdraw',
                'subject'           => 'Withdraw',
                'details'           => 'Your withdraw of ' . $withdrawData->total_withdraw . ' '
                . $withdrawData->currency_symbol . ' has been successfully processed.',
            ]);

            DB::commit();

            return (object) ['status' => 'success'];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

    /**
     * Withdrawal approve from admin
     * @param array $attributes
     * @return object
     */
    public function withdrawApprove(array $attributes): ?object
    {
        $withdrawId = $attributes['withdraw_id'];

        $withdrawalInfo = $this->withdrawRepository->find($withdrawId);

        if (!$withdrawalInfo) {
            return (object) ['status' => 'error', 'message' => localize('Invalid withdrawal request')];
        }

        try {

            DB::beginTransaction();

            $this->withdrawRepository->updateById($withdrawId, [
                'audited_by' => auth()->user()->id,
                'status'     => WithdrawStatusEnum::SUCCESS->value,
            ]);

            $convertRate = 1;

            if ($withdrawalInfo->currencyInfo->symbol != "USD") {
                $withdrawalUsdRate = $this->currencyConvertService->coinRate($withdrawalInfo->currencyInfo->name);

                if ($withdrawalUsdRate->status == "success") {
                    $convertRate = $withdrawalUsdRate->rate;
                }

            }

            $this->txnReportService->create([
                'customer_id'        => $withdrawalInfo->customer_id,
                'accept_currency_id' => $withdrawalInfo->accept_currency_id,
                'txn_type'           => TxnTypeEnum::WITHDRAW->value,
                'amount'             => $withdrawalInfo->amount,
                'usd_value'          => $convertRate * $withdrawalInfo->amount,
            ]);

            if ($withdrawalInfo->fees > 0) {
                $feesUsdValue = number_format($convertRate * $withdrawalInfo->fees, 2, '.', '');
                $this->txnFeeService->create([
                    'customer_id'        => $withdrawalInfo->customer_id,
                    'accept_currency_id' => $withdrawalInfo->accept_currency_id,
                    'txn_type'           => TxnTypeEnum::WITHDRAW->value,
                    'fee_amount'         => $withdrawalInfo->fees,
                    'usd_value'          => $feesUsdValue,
                ]);
            }

            $this->notificationService->create([
                'customer_id'       => $withdrawalInfo->customer_id,
                'notification_type' => 'withdraw',
                'subject'           => 'Withdraw',
                'details'           => 'Your withdraw of ' . ($withdrawalInfo->amount + $withdrawalInfo->fees) . ' '
                . $withdrawalInfo->currencyInfo->symbol . ' has been approved.',
            ]);

            DB::commit();

            return (object) ['status' => 'success', 'data' => $withdrawalInfo];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

    /**
     * Withdrawal cancel from admin
     * @param array $attributes
     * @return object
     */
    public function withdrawCancel(array $attributes): ?object
    {
        $withdrawId = $attributes['withdraw_id'];

        $withdrawalInfo = $this->withdrawRepository->find($withdrawId);

        if (!$withdrawalInfo) {
            return (object) ['status' => 'error', 'message' => localize('Invalid withdrawal request')];
        }

        $userID = $withdrawalInfo->customerInfo->user_id;

        try {

            DB::beginTransaction();

            $this->withdrawRepository->updateById($withdrawId, [
                'audited_by' => auth()->user()->id,
                'status'     => WithdrawStatusEnum::CANCEL->value,
            ]);

            $totalWithdrawalAmount = $withdrawalInfo->amount + $withdrawalInfo->fees;

            $this->walletManageService->reverseTxn([
                'accept_currency_id' => $withdrawalInfo->accept_currency_id,
                'user_id'            => $userID,
                'withdraw'           => $totalWithdrawalAmount,
                'withdraw_fee'       => $withdrawalInfo->fees,
                'balance'            => $totalWithdrawalAmount,
            ]);

            $this->walletTransactionLogService->create([
                'user_id'            => $userID,
                'accept_currency_id' => $withdrawalInfo->accept_currency_id,
                'transaction'        => WalletManageLogEnum::WITHDRAW_CANCEL->value,
                'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                'amount'             => $totalWithdrawalAmount,
            ]);

            $this->notificationService->create([
                'customer_id'       => $withdrawalInfo->customerInfo->id,
                'notification_type' => 'withdraw',
                'subject'           => 'Withdraw',
                'details'           => 'Your withdraw of ' . $totalWithdrawalAmount . ' '
                . $withdrawalInfo->currencyInfo->symbol . ' has been cancelled.',
            ]);
            DB::commit();

            return (object) ['status' => 'success', 'data' => $withdrawalInfo];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

    public function findById(int $id): ?object
    {
        return $this->withdrawRepository->firstWhere('id', $id);
    }

}