<?php

namespace Modules\Merchant\App\Services;

use App\Enums\CustomerStatusEnum;
use App\Enums\CustomerVerifyStatusEnum;
use App\Enums\FeeSettingLevelEnum;
use App\Enums\OtpVerifyTypeEnum;
use App\Enums\TransactionTypeEnum;
use App\Enums\WalletManageLogEnum;
use App\Services\AcceptCurrencyService;
use App\Services\FeeSettingService;
use App\Services\NotificationService;
use App\Services\OtpVerificationService;
use App\Services\WalletTransactionLogService;
use App\Services\WithdrawalAccountService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\App\Enums\MerchantWithdrawEnum;
use Modules\Merchant\App\Repositories\Interfaces\WithdrawRepositoryInterface;
use Modules\Merchant\App\Services\MerchantAccountService;

class MerchantWithdrawService
{
    /**
     * MerchantWithdrawService constructor.
     *
     */
    public function __construct(
        private WithdrawRepositoryInterface $withdrawRepository,
        private WithdrawalAccountService $withdrawalAccountService,
        private AcceptCurrencyService $acceptCurrencyService,
        private FeeSettingService $feeSettingService,
        private MerchantBalanceService $balanceService,
        private OtpVerificationService $verificationService,
        private NotificationService $notificationService,
        private MerchantAccountService $accountService,
        private WalletTransactionLogService $walletTransactionLogService,
    ) {
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

        $merchantAccountData = $this->accountService->findMerchantAccount(auth()->user()->user_id);

        if (!$merchantAccountData) {
            return (object) [
                'status'  => 'error',
                'message' => localize('You do not have a merchant account'),
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

        $walletBalanceData = $this->balanceService->walletBalance([
            'user_id'     => auth()->user()->user_id,
            'currency_id' => $currencyData->id,
        ]);

        if (!$walletBalanceData || $walletBalanceData->amount < $totalWithdraw) {
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
            'merchant_account_id' => $merchantAccountData->id,
            'method'              => $attributes['payment_method'],
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
                'merchant_account_id' => $withdrawData->merchant_account_id,
                'user_id'             => auth()->user()->user_id,
                'accept_currency_id'  => $withdrawData->accept_currency_id,
                'wallet_id'           => $withdrawData->withdrawal_account,
                'method'              => $withdrawData->method,
                'amount'              => $withdrawData->withdraw_amount,
                'fees'                => $withdrawData->fees,
                'request_date'        => Carbon::now(),
                'comments'            => $withdrawData->withdrawal_comments,
            ]);

            $this->balanceService->balanceDeduct([
                'amount' => $withdrawData->total_withdraw,
            ], $withdrawData->wallet_id);

            $this->walletTransactionLogService->create([
                'user_id'            => auth()->user()->user_id,
                'accept_currency_id' => $withdrawData->accept_currency_id,
                'transaction'        => WalletManageLogEnum::MERCHANT_WITHDRAW->value,
                'transaction_type'   => TransactionTypeEnum::DEBIT->value,
                'amount'             => $withdrawData->total_withdraw,
            ]);

            $this->notificationService->create([
                'customer_id'       => auth()->user()->id,
                'notification_type' => 'withdraw',
                'subject'           => 'Withdraw',
                'details'           => 'Your Withdraw of ' . $withdrawData->total_withdraw . ' '
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
                'status'     => MerchantWithdrawEnum::CONFIRM->value,
            ]);

            $this->notificationService->create([
                'customer_id'       => auth()->user()->id,
                'notification_type' => 'withdraw',
                'subject'           => 'Withdraw',
                'details'           => 'Your withdraw of ' . ($withdrawalInfo->amount + $withdrawalInfo->fees) . ' '
                . $withdrawalInfo->coinInfo->symbol . ' has been approved.',
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

        $userID = $withdrawalInfo->user_id;

        try {

            DB::beginTransaction();

            $this->withdrawRepository->updateById($withdrawId, [
                'updated_by' => auth()->user()->id,
                'status'     => MerchantWithdrawEnum::CANCEL->value,
            ]);

            $totalWithdrawalAmount = $withdrawalInfo->amount + $withdrawalInfo->fees;

            $this->balanceService->reverseTxn([
                'accept_currency_id' => $withdrawalInfo->accept_currency_id,
                'user_id'            => $userID,
                'amount'             => $totalWithdrawalAmount,
            ]);

            $this->walletTransactionLogService->create([
                'user_id'            => $userID,
                'accept_currency_id' => $withdrawalInfo->accept_currency_id,
                'transaction'        => WalletManageLogEnum::WITHDRAW_CANCEL->value,
                'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                'amount'             => $totalWithdrawalAmount,
            ]);

            $this->notificationService->create([
                'customer_id'       => $withdrawalInfo->merchantInfo->id,
                'notification_type' => 'withdraw',
                'subject'           => 'Withdraw',
                'details'           => 'Your withdraw of ' . $totalWithdrawalAmount . ' '
                . $withdrawalInfo->coinInfo->symbol . ' has been cancelled.',
            ]);
            DB::commit();

            return (object) ['status' => 'success', 'data' => $withdrawalInfo];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

}
