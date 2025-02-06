<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Enums\TxnTypeEnum;
use App\Enums\WalletManageLogEnum;
use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\WithdrawAccountCredentialRepositoryInterface;
use App\Repositories\Interfaces\WithdrawAccountRepositoryInterface;
use App\Services\AcceptCurrencyService;
use App\Services\CurrencyConvertService;
use App\Services\Customer\CustomerService;
use App\Services\NotificationService;
use App\Services\TxnFeeReportService;
use App\Services\TxnReportService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use App\Services\WithdrawalAccountService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Finance\App\Enums\DepositEnum;
use Modules\Finance\App\Enums\TransferStatusEnum;
use Modules\Finance\App\Enums\WithdrawStatusEnum;
use Modules\Finance\App\Repositories\Interfaces\DepositRepositoryInterface;
use Modules\Finance\App\Repositories\Interfaces\TransferRepositoryInterface;
use Modules\Finance\App\Repositories\Interfaces\WithdrawRepositoryInterface;

class DemoDataController extends Controller
{
    private $dataStartDate;
    private $noOfMonth;

    public function __construct(
        private Customer $customer,
        private AcceptCurrencyService $acceptCurrencyService,
        private CustomerService $customerService,
        private TxnReportService $txnReportService,
        private TxnFeeReportService $txnFeeService,
        private NotificationService $notificationService,
        private WalletManageService $walletManageService,
        private DepositRepositoryInterface $depositRepository,
        private WalletTransactionLogService $walletTransactionLogService,
        protected CustomerRepositoryInterface $customerRepository,
        private WithdrawalAccountService $withdrawalAccountService,
        private WithdrawAccountRepositoryInterface $withdrawAccountRepository,
        private WithdrawAccountCredentialRepositoryInterface $withdrawCredentialRepository,
        private WithdrawRepositoryInterface $withdrawRepository,
        private CurrencyConvertService $currencyConvertService,
        private TransferRepositoryInterface $transferRepository,
    ) {
        $this->noOfMonth     = 5;
        $currentDate         = Carbon::now();
        $this->dataStartDate = $currentDate->subMonths($this->noOfMonth);
    }

    public function createDemo()
    {

// $this->createUsers();

// $this->createDemoDeposit();

// $this->addWithdrawalCredential();

// $this->createDemoWithdraw();
        // $this->createDemoTransfer();
    }

    private function createUsers()
    {
        $referralUser = '';

        for ($i = 1; $i <= $this->noOfMonth + 1; $i++) {

            $customCreatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $this->dataStartDate);

            $noOfUsers = 5;

            if ($i % 2 == 0) {
                $noOfUsers = $noOfUsers - $i;
            } else {
                $noOfUsers = $noOfUsers + $i;
            }

            if ($noOfUsers <= 0) {
                $noOfUsers = 1;
            }

            for ($j = 1; $j <= $noOfUsers; $j++) {

                $randomString = strtoupper(Str::random(8));

                $data['first_name']               = 'Demo' . $i . $j;
                $data['last_name']                = 'demo' . $i . $j;
                $data['phone']                    = '01000000' . $i . $j;
                $data['email']                    = 'demo' . $i . $j . '@bdtask.com';
                $data['username']                 = 'demo' . $i . $j;
                $data['user_id']                  = $randomString;
                $data['password']                 = Hash::make('123456');
                $data['status']                   = '1';
                $data['verified_status']          = '1';
                $data['created_at']               = $customCreatedAt;
                $data['email_verification_token'] = sha1(time());

                if ($referralUser) {
                    $data['referral_user'] = $referralUser;
                }

                try {
                    DB::beginTransaction();
                    $createResult = $this->customer->create($data);

                    if ($createResult) {
                        $referralUser = $createResult->user_id;
                    }

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    throw $th;
                }

            }

            $this->dataStartDate = $this->dataStartDate->addMonth(1);

        }

    }

    private function createDemoDeposit()
    {
        $allCustomer = $this->customerRepository->all();
        // $allCustomer         = $this->customerRepository->findWhere('id', 1);
        $currentDate         = Carbon::now();
        $this->dataStartDate = $currentDate->subMonths(6);

        $addAmount           = ['BTC' => 100, 'ETH' => 100, 'USD' => 0.1, 'LTCT' => 1];
        $depositLimit        = ['BTC' => 1, 'ETH' => 2, 'USD' => 100, 'LTCT' => 20];
        $methods             = ['BTC' => 'Coinpayments', 'ETH' => 'Coinpayments', 'USD' => 'Stripe', 'LTCT' => 'Coinpayments'];
        $currencyData        = [0 => 'BTC', 1 => 'ETH', 2 => 'USD', 3 => 'LTCT'];
        $currencyNo          = 0;
        $chartData           = 1;
        $this->dataStartDate = $this->dataStartDate->addMonth(1);
        $addMonth            = 0;

        foreach ($allCustomer as $key => $value) {

            if ($currencyNo == 3) {
                $currencyNo = 0;
            }

            if ($key % 5 == 0 && $addMonth <= 4) {
                $this->dataStartDate = $this->dataStartDate->addMonth(1);
                $chartData++;
                $addMonth++;
            }

            $currencySymbol = $currencyData[$currencyNo];
            $currencyInfo   = $this->acceptCurrencyService->findCurrencyBySymbol($currencySymbol);
            $txnAmount      = $depositLimit[$currencySymbol];

            if ($chartData % 2 == 0) {
                $newAmount = $chartData / $addAmount[$currencySymbol];
                $txnAmount = $txnAmount + $newAmount;
            }

            if ($txnAmount < 0) {
                $txnAmount = $depositLimit[$currencySymbol];
            }

            $usdValue = $currencyInfo->rate * $txnAmount;
            $fees     = $txnAmount * 0.1;

            $this->makeSystemDeposit((object) [
                'user'       => $value->user_id,
                'txn_amount' => $depositLimit[$currencySymbol],
                'usd_amount' => $usdValue,
                'currency'   => $currencySymbol,
                'method'     => $methods[$currencySymbol],
                'fees'       => $fees,
                'comment'    => 'Demo Deposit',
                'created_at' => $this->dataStartDate,
            ]);

            $currencyNo++;
        }

    }

    private function makeSystemDeposit(object $attributes): object
    {
        $userId    = $attributes->user;
        $amount    = $attributes->txn_amount;
        $usdAmount = $attributes->usd_amount;

        if ($amount <= 0 || $usdAmount <= 0) {
            return (object) ['status' => 'error', 'message' => localize('Something went wrong')];
        }

        $currencyInfo = $this->acceptCurrencyService->findCurrencyBySymbol($attributes->currency);

        if (!$currencyInfo) {
            return (object) ['status' => 'error', 'message' => localize('Invalid Currency!')];
        }

        $customerInfo = $this->customerService->findCustomerByUserId($userId);

        if (!$customerInfo) {
            return (object) ['status' => 'error', 'message' => localize('Invalid Customer Id')];
        }

        try {
            DB::beginTransaction();

            $this->createDeposit([
                'accept_currency_id' => $currencyInfo->id,
                'user_id'            => $userId,
                'customer_id'        => $customerInfo->id,
                'method'             => $attributes->method,
                'amount'             => $amount,
                'fees'               => $attributes->fees,
                'comment'            => $attributes->comment,
                'created_at'         => $attributes->created_at,
            ]);

            $this->txnReportService->create([
                'customer_id'        => $customerInfo->id,
                'accept_currency_id' => $currencyInfo->id,
                'txn_type'           => TxnTypeEnum::DEPOSIT->value,
                'amount'             => $amount,
                'usd_value'          => $usdAmount,
                'created_at'         => $attributes->created_at,
            ]);

            if ($attributes->fees > 0) {
                $currencyUsdRate = $usdAmount / $amount;
                $feesUsdValue    = number_format($currencyUsdRate * $attributes->fees, 2, '.', '');
                $this->txnFeeService->create([
                    'customer_id'        => $customerInfo->id,
                    'accept_currency_id' => $currencyInfo->id,
                    'txn_type'           => TxnTypeEnum::DEPOSIT->value,
                    'fee_amount'         => $attributes->fees,
                    'usd_value'          => $feesUsdValue,
                    'created_at'         => $attributes->created_at,
                ]);
            }

            $this->notificationService->create([
                'customer_id'       => $customerInfo->id,
                'notification_type' => 'deposit',
                'subject'           => 'Deposit',
                'details'           => 'Your deposit of ' . $amount . ' ' . $attributes->currency . ' has been successfully processed.',
                'created_at'        => $attributes->created_at,
            ]);

            DB::commit();

            return (object) ['status' => 'success'];

        } catch (Exception $exception) {

            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $exception->getMessage()];
        }

    }

    public function createDeposit(array $attributes): ?object
    {
        $amount           = $attributes['amount'];
        $acceptCurrencyId = $attributes['accept_currency_id'];
        $userId           = $attributes['user_id'];

        $depositData = [
            'customer_id'        => $attributes['customer_id'],
            'accept_currency_id' => $acceptCurrencyId,
            'user_id'            => $userId,
            'amount'             => $amount,
            'method'             => $attributes['method'] ?? 'Credited',
            'fees'               => $attributes['fees'],
            'comments'           => $attributes['comment'],
            'date'               => Carbon::now(),
            'status'             => DepositEnum::CONFIRM->value,
            'created_at'         => $attributes['created_at'],
        ];

        $createDeposit = $this->depositRepository->create($depositData);

        if ($createDeposit) {

            if (isset($attributes['method'])) {
                $newArray = [
                    'deposit'     => $amount,
                    'deposit_fee' => $attributes['fees'],
                ];
                $walletLogTransaction = WalletManageLogEnum::DEPOSIT->value;
            } else {
                $newArray = [
                    'credited' => $amount,
                ];
                $walletLogTransaction = WalletManageLogEnum::CREDITED->value;
            }

            $balance = $amount;

            if ($attributes['fees'] > 0) {
                $balance = $balance - $attributes['fees'];
            }

            $walletManage = $this->walletManageService->create([
                'accept_currency_id' => $acceptCurrencyId,
                'user_id'            => $userId,
                'balance'            => $balance,
                ...$newArray,
            ]);

            if ($walletManage) {
                $this->walletTransactionLogService->create([
                    'user_id'            => $userId,
                    'accept_currency_id' => $acceptCurrencyId,
                    'transaction'        => $walletLogTransaction,
                    'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                    'amount'             => $balance,
                    'created_at'         => $attributes['created_at'],
                ]);
            }

        } else {
            return null;
        }

        return $createDeposit;
    }

    private function addWithdrawalCredential()
    {
        $allCustomer = $this->customerRepository->all();
        // $allCustomer  = $this->customerRepository->findWhere('id', 1);
        $currencyData = [0 => 'BTC', 1 => 'ETH', 2 => 'USD', 3 => 'LTCT'];
        $methods      = ['BTC' => 1, 'ETH' => 1, 'USD' => 2, 'LTCT' => 1];

        foreach ($allCustomer as $key => $value) {

            foreach ($currencyData as $key2 => $value2) {

                if ($value2 == "USD") {
                    $accountLabel = "Email";
                    $accountValue = $value->email;
                } else {
                    $accountLabel = "Wallet Address";
                    $accountValue = '0xxxxxxxxxxx' . $value->id;
                }

                $resultData = $this->accountCreate([
                    'payment_currency' => $value2,
                    'payment_method'   => $methods[$value2],
                    'account_label'    => [$accountLabel],
                    'account_value'    => [$accountValue],
                    'customer_id'      => $value->id,
                ]);
            }

        }

    }

    public function accountCreate(array $attributes): ?object
    {
        $currencyInfo = $this->acceptCurrencyService->findCurrencyBySymbol($attributes['payment_currency']);

        if (!$currencyInfo) {
            return (object) ['status' => 'error', 'message' => 'Invalid Currency'];
        }

        $checkExists = $this->withdrawAccountRepository->findAccount([
            'customer_id'        => $attributes['customer_id'],
            'payment_gateway_id' => $attributes['payment_method'],
            'accept_currency_id' => $currencyInfo->id,
        ]);

        if ($checkExists) {
            return (object) ['status' => 'error', 'message' => 'Withdrawal account already exist'];
        }

        try {
            DB::beginTransaction();

            $withdrawalAccount = $this->withdrawAccountRepository->create([
                'customer_id'        => $attributes['customer_id'],
                'payment_gateway_id' => $attributes['payment_method'],
                'accept_currency_id' => $currencyInfo->id,
                'status'             => StatusEnum::ACTIVE->value,
            ]);

            if ($withdrawalAccount) {

                foreach ($attributes['account_label'] as $key => $value) {
                    $type = Str::lower($value);
                    $type = Str::replace(' ', '_', $type);
                    $this->withdrawCredentialRepository->create([
                        "withdrawal_account_id" => $withdrawalAccount->id,
                        "type"                  => $type,
                        "name"                  => $value,
                        "credential"            => $attributes['account_value'][$key],
                    ]);
                }

            }

            DB::commit();

            return (object) ['status' => 'success', 'data' => $withdrawalAccount];

        } catch (Exception $exception) {
            DB::rollBack();
            return (object) ['status' => 'error', 'message' => $exception->getMessage()];
        }

    }

    public function createDemoWithdraw()
    {
        $allCustomer = $this->customerRepository->all();
        // $allCustomer         = $this->customerRepository->findWhere('id', 1);
        $currentDate         = Carbon::now();
        $this->dataStartDate = $currentDate->subMonths(6);

        $addAmount           = ['BTC' => 200, 'ETH' => 200, 'USD' => 0.7, 'LTCT' => 5];
        $depositLimit        = ['BTC' => 0.5, 'ETH' => 1, 'USD' => 50, 'LTCT' => 10];
        $methods             = ['BTC' => 1, 'ETH' => 1, 'USD' => 2, 'LTCT' => 1];
        $currencyData        = [0 => 'BTC', 1 => 'ETH', 2 => 'USD', 3 => 'LTCT'];
        $currencyNo          = 0;
        $chartData           = 1;
        $this->dataStartDate = $this->dataStartDate->addMonth(1);
        $addMonth            = 0;

        foreach ($allCustomer as $key => $value) {

            if ($currencyNo == 3) {
                $currencyNo = 0;
            }

            if ($key % 5 == 0 && $addMonth <= 4) {
                $this->dataStartDate = $this->dataStartDate->addMonth(1);
                $chartData++;
                $addMonth++;
            }

            $currencySymbol = $currencyData[$currencyNo];
            $currencyInfo   = $this->acceptCurrencyService->findCurrencyBySymbol($currencySymbol);
            $txnAmount      = $depositLimit[$currencySymbol];

            if ($chartData % 2 == 0) {
                $newAmount = $chartData / $addAmount[$currencySymbol];
                $txnAmount = $txnAmount + $newAmount;
            }

            if ($txnAmount < 0) {
                $txnAmount = $depositLimit[$currencySymbol];
            }

            $fees = $txnAmount * 0.1;

            $withdrawalAccount = $this->withdrawAccountRepository->findAccount([
                'customer_id'        => $value->id,
                'payment_gateway_id' => $methods[$currencySymbol],
                'accept_currency_id' => $currencyInfo->id,
            ]);

            $walletBalanceData = $this->walletManageService->walletBalance([
                'user_id'     => $value->user_id,
                'currency_id' => $currencyInfo->id,
            ]);

            $totalWithdrawal = $depositLimit[$currencySymbol] + $fees;

            $withdrawalResult = $this->confirmWithdraw((object) [
                'gateway_id'          => $methods[$currencySymbol],
                'accept_currency_id'  => $currencyInfo->id,
                'withdrawal_account'  => $withdrawalAccount->id,
                'withdraw_amount'     => $depositLimit[$currencySymbol],
                'fees'                => $fees,
                'withdrawal_comments' => 'Demo withdraw',
                'currency_symbol'     => $currencySymbol,
                'total_withdraw'      => $totalWithdrawal,
                'created_at'          => $this->dataStartDate,
                'user_id'             => $value->user_id,
                'customer_id'         => $value->id,
                'wallet_id'           => $walletBalanceData->id,
            ]);

            if ($withdrawalResult->status == 'success') {
                $resultData = $withdrawalResult->data;

                $this->withdrawApprove([
                    'withdraw_id' => $resultData->id,
                    'created_at'  => $this->dataStartDate,
                ]);
            }

            $currencyNo++;
        }

    }

    public function confirmWithdraw(object $withdrawData): object
    {
        try {

            DB::beginTransaction();

            $withdrawResult = $this->withdrawRepository->create([
                'customer_id'           => $withdrawData->customer_id,
                'payment_gateway_id'    => $withdrawData->gateway_id,
                'accept_currency_id'    => $withdrawData->accept_currency_id,
                'withdrawal_account_id' => $withdrawData->withdrawal_account,
                'amount'                => $withdrawData->withdraw_amount,
                'fees'                  => $withdrawData->fees,
                'comments'              => $withdrawData->withdrawal_comments,
                'status'                => WithdrawStatusEnum::SUCCESS->value,
            ]);

            $this->walletManageService->balanceDeduct([
                'withdraw'     => $withdrawData->total_withdraw,
                'withdraw_fee' => $withdrawData->fees,
                'balance'      => $withdrawData->total_withdraw,
            ], $withdrawData->wallet_id);

            $this->walletTransactionLogService->create([
                'user_id'            => $withdrawData->user_id,
                'accept_currency_id' => $withdrawData->accept_currency_id,
                'transaction'        => WalletManageLogEnum::WITHDRAW->value,
                'transaction_type'   => TransactionTypeEnum::DEBIT->value,
                'amount'             => $withdrawData->total_withdraw,
                'created_at'         => $withdrawData->created_at,
            ]);

            $this->notificationService->create([
                'customer_id'       => $withdrawData->customer_id,
                'notification_type' => 'withdraw',
                'subject'           => 'Withdraw',
                'details'           => 'Your withdraw of ' . $withdrawData->total_withdraw . ' '
                . $withdrawData->currency_symbol . ' has been successfully processed.',
                'created_at'        => $withdrawData->created_at,
            ]);

            DB::commit();

            return (object) ['status' => 'success', 'data' => $withdrawResult];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

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
                'audited_by' => 1,
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
                'created_at'         => $attributes['created_at'],
            ]);

            if ($withdrawalInfo->fees > 0) {
                $feesUsdValue = number_format($convertRate * $withdrawalInfo->fees, 2, '.', '');
                $this->txnFeeService->create([
                    'customer_id'        => $withdrawalInfo->customer_id,
                    'accept_currency_id' => $withdrawalInfo->accept_currency_id,
                    'txn_type'           => TxnTypeEnum::WITHDRAW->value,
                    'fee_amount'         => $withdrawalInfo->fees,
                    'usd_value'          => $feesUsdValue,
                    'created_at'         => $attributes['created_at'],
                ]);
            }

            $this->notificationService->create([
                'customer_id'       => $withdrawalInfo->customer_id,
                'notification_type' => 'withdraw',
                'subject'           => 'Withdraw',
                'details'           => 'Your withdraw of ' . ($withdrawalInfo->amount + $withdrawalInfo->fees) . ' '
                . $withdrawalInfo->currencyInfo->symbol . ' has been approved.',
                'created_at'        => $attributes['created_at'],
            ]);

            DB::commit();

            return (object) ['status' => 'success', 'data' => $withdrawalInfo];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

    public function createDemoTransfer()
    {
        $allCustomer = $this->customerRepository->all();
        // $allCustomer         = $this->customerRepository->findWhere('id', 1);
        $currentDate         = Carbon::now();
        $this->dataStartDate = $currentDate->subMonths(6);

        $addAmount    = ['BTC' => 200, 'ETH' => 200, 'USD' => 0.7, 'LTCT' => 5];
        $depositLimit = ['BTC' => 0.1, 'ETH' => 0.4, 'USD' => 30, 'LTCT' => 2];
        // $methods             = ['BTC' => 1, 'ETH' => 1, 'USD' => 2, 'LTCT' => 1];
        $currencyName        = ['BTC' => 'Bitcoin', 'ETH' => 'Ethereum', 'USD' => 'US Dollar', 'LTCT' => 'LiteCoin Testnet'];
        $currencyData        = [0 => 'BTC', 1 => 'ETH', 2 => 'USD', 3 => 'LTCT'];
        $currencyNo          = 0;
        $chartData           = 1;
        $this->dataStartDate = $this->dataStartDate->addMonth(1);
        $addMonth            = 0;

        foreach ($allCustomer as $key => $value) {

            if ($currencyNo == 3) {
                $currencyNo = 0;
            }

            if ($key % 5 == 0 && $addMonth <= 4) {
                $this->dataStartDate = $this->dataStartDate->addMonth(1);
                $chartData++;
                $addMonth++;
            }

            $currencySymbol = $currencyData[$currencyNo];
            $currencyInfo   = $this->acceptCurrencyService->findCurrencyBySymbol($currencySymbol);
            $txnAmount      = $depositLimit[$currencySymbol];

            if ($chartData % 2 == 0) {
                $newAmount = $chartData / $addAmount[$currencySymbol];
                $txnAmount = $txnAmount + $newAmount;
            }

            if ($txnAmount < 0) {
                $txnAmount = $depositLimit[$currencySymbol];
            }

            $fees = $txnAmount * 0.1;

            $walletBalanceData = $this->walletManageService->walletBalance([
                'user_id'     => $value->user_id,
                'currency_id' => $currencyInfo->id,
            ]);

            $totalTransfer = $depositLimit[$currencySymbol] + $fees;

            if (!$walletBalanceData || $walletBalanceData->balance < $totalTransfer) {
                continue;
            }

            if (!$value->referral_user) {
                continue;
            }

            $receiverInfo = $this->customerService->findCustomerByUserId($value->referral_user);

            if (!$receiverInfo) {
                continue;
            }

            $this->confirmTransfer((object) [
                'transfer_amount'    => $txnAmount,
                'fees'               => $fees,
                'total_transfer'     => $totalTransfer,
                'accept_currency_id' => $currencyInfo->id,
                'currency_name'      => $currencyName[$currencySymbol],
                'currency_symbol'    => $currencySymbol,
                'receiver_user'      => $receiverInfo->user_id,
                'receiver_id'        => $receiverInfo->id,
                'transfer_comments'  => 'Demo Transfer',
                'wallet_id'          => $walletBalanceData->id,
                'created_at'         => $this->dataStartDate,
                'sender_user_id'     => $value->user_id,
                'sender_id'          => $value->id,
            ]);

            $currencyNo++;
        }

    }

    public function confirmTransfer(object $transferData): object
    {
        try {

            DB::beginTransaction();

            $now      = Carbon::now();
            $dateOnly = $now->format('Y-m-d');

            $this->transferRepository->create([
                'sender_user_id'   => $transferData->sender_user_id,
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
                'created_at'         => $transferData->created_at,
            ]);

            $this->walletManageService->balanceDeduct([
                'transfer'     => $transferData->total_transfer,
                'transfer_fee' => $transferData->fees,
                'balance'      => $transferData->total_transfer,
            ], $transferData->wallet_id);

            $this->walletTransactionLogService->create([
                'user_id'            => $transferData->sender_user_id,
                'accept_currency_id' => $transferData->accept_currency_id,
                'transaction'        => WalletManageLogEnum::TRANSFER->value,
                'transaction_type'   => TransactionTypeEnum::DEBIT->value,
                'amount'             => $transferData->total_transfer,
                'created_at'         => $transferData->created_at,
            ]);

            $convertRate = 1;

            if ($transferData->currency_symbol != "USD") {
                $transferUsdAmount = $this->currencyConvertService->coinRate($transferData->currency_name);

                if ($transferUsdAmount->status == "success") {
                    $convertRate = $transferUsdAmount->rate;
                }

            }

            $this->txnReportService->create([
                'customer_id'        => $transferData->sender_id,
                'accept_currency_id' => $transferData->accept_currency_id,
                'txn_type'           => TxnTypeEnum::TRANSFER->value,
                'amount'             => $transferData->total_transfer,
                'usd_value'          => $convertRate * $transferData->transfer_amount,
                'created_at'         => $transferData->created_at,
            ]);

            if ($transferData->fees > 0) {
                $feesUsdValue = number_format($convertRate * $transferData->fees, 2, '.', '');
                $this->txnFeeService->create([
                    'customer_id'        => $transferData->sender_id,
                    'accept_currency_id' => $transferData->accept_currency_id,
                    'txn_type'           => TxnTypeEnum::TRANSFER->value,
                    'fee_amount'         => $transferData->fees,
                    'usd_value'          => $feesUsdValue,
                    'created_at'         => $transferData->created_at,
                ]);
            }

            $this->notificationService->create([
                'customer_id'       => $transferData->sender_id,
                'notification_type' => 'transfer',
                'subject'           => 'Transfer',
                'details'           => 'Your transfer of ' . $transferData->total_transfer . ' '
                . $transferData->currency_symbol . ' has been successfully processed.',
                'created_at'        => $transferData->created_at,
            ]);

            $this->notificationService->create([
                'customer_id'       => $transferData->receiver_id,
                'notification_type' => 'transfer',
                'subject'           => 'Transfer',
                'details'           => 'You have received an amount of ' . $transferData->total_transfer
                . $transferData->currency_symbol . ' from ' . $transferData->sender_user_id,
                'created_at'        => $transferData->created_at,
            ]);

            DB::commit();

            return (object) ['status' => 'success'];

        } catch (\Throwable $th) {
            DB::rollBack();

            return (object) ['status' => 'error', 'message' => $th->getMessage()];
        }

    }

    public function createDemoInvestment()
    {

    }

}
