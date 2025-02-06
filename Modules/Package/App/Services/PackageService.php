<?php

namespace Modules\Package\App\Services;

use App\Enums\AssetsFolderEnum;
use App\Enums\InvestDetailStatusEnum;
use App\Enums\NotificationEnum;
use App\Enums\StatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Enums\WalletManageLogEnum;
use App\Helpers\ImageHelper;
use App\Http\Resources\ArticleLangResource;
use App\Http\Resources\ManyArticlesResource;
use App\Http\Resources\PackageResource;
use App\Repositories\Eloquent\AcceptCurrencyRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CommissionSetupRepositoryInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\InvestmentDetailsRepositoryInterface;
use App\Repositories\Interfaces\InvestmentEarningRepositoryInterface;
use App\Repositories\Interfaces\InvestmentRepositoryInterface;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;
use App\Repositories\Interfaces\WalletTransactionLogRepositoryInterface;
use App\Services\CustomerService;
use App\Services\NotificationService;
use App\Services\WalletManageService;
use App\Services\WalletTransactionLogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Enums\CapitalReturnStatusEnum;
use Modules\Package\App\Enums\InterestTypeEnum;
use Modules\Package\App\Enums\InvestTypeEnum;
use Modules\Package\App\Enums\ReturnTypeEnum;
use Modules\Package\App\Repositories\Eloquent\EarningRepository;
use Modules\Package\App\Repositories\Eloquent\UserLevelRepository;
use Modules\Package\App\Repositories\Interfaces\CapitalReturnRepositoryInterface;
use Modules\Package\App\Repositories\Interfaces\InvestmentRoiRepositoryInterface;
use Modules\Package\App\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\App\Repositories\Interfaces\TeamBonusDetailsRepositoryInterface;
use Modules\Package\App\Repositories\Interfaces\TeamBonusRepositoryInterface;

class PackageService
{
    /**
     * PackageService constructor.
     *
     */
    public function __construct(
        private PackageRepositoryInterface $packageRepository,
        private ArticleRepositoryInterface $articleRepository,
        private WalletManageRepositoryInterface $walletManageRepository,
        private WalletTransactionLogRepositoryInterface $walletTransactionLogRepository,
        private InvestmentRepositoryInterface $investmentRepository,
        private CustomerRepositoryInterface $customerRepository,
        private CommissionSetupRepositoryInterface $commissionSetupRepository,
        private InvestmentEarningRepositoryInterface $investmentEarningRepository,
        private TeamBonusRepositoryInterface $teamBonusRepository,
        private TeamBonusDetailsRepositoryInterface $teamBonusDetailsRepository,
        private UserLevelRepository $userLevelRepository,
        private EarningRepository $earningRepository,
        private InvestmentDetailsRepositoryInterface $investmentDetailsRepository,
        private CapitalReturnRepositoryInterface $capitalReturnRepository,
        private NotificationService $notificationService,
        private AcceptCurrencyRepository $acceptCurrencyRepository,
        private WalletManageService $walletManageService,
        private WalletTransactionLogService $walletTransactionLogService,
        private InvestmentRoiRepositoryInterface $investmentRoiRepository,
        private CustomerService $customerService
    ) {
    }

    /**
     * get all active packages
     * @param int $pageNo
     * @return object|null
     */
    public function allActivePackages(array $attributes = []): ?object
    {
        return $this->packageRepository->allActivePackages();
    }

    /**
     * get all active packages paginate data
     * @param int $pageNo
     * @return object|null
     */
    public function packagesPaginate(array $attributes = []): ?object
    {
        return $this->packageRepository->packagesPaginate();
    }

    public function findPackages(int $pageNo): ?object
    {
        $packages = $this->packageRepository->orderPaginate([
            "orderByColumn"     => "id",
            "order"             => "asc",
            "searchColumn"      => "status",
            "searchColumnValue" => StatusEnum::ACTIVE->value,
            "perPage"           => 6,
            "page"              => $pageNo,
        ]);

        if ($packages) {
            return PackageResource::collection($packages);
        }

        return (object) [];
    }

    /**
     * Fetch data for home slider
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function findManyArticles(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findArticle($slug, $languageId);

        return ManyArticlesResource::collection($articleData);
    }

    /**
     * Find Language Article
     * @param string $slug
     * @param int $languageId
     * @return object|AnonymousResourceCollection
     */
    public function findLangArticle(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findDoubleWhereFirst(
            'slug',
            $slug,
            'status',
            StatusEnum::ACTIVE->value
        );

        if ($articleData) {
            $langData = $articleData->articleLangData->where('language_id', $languageId);

            if ($langData->isNotEmpty()) {
                return ArticleLangResource::collection($langData);
            }

        }

        return null;
    }

    /**
     * Required data to populate form
     *
     * @return array
     */
    public function formData(): array
    {
        $investmentType = InvestTypeEnum::toArray();
        $interestType   = InterestTypeEnum::toArray();
        $returnType     = ReturnTypeEnum::toArray();
        $capitalBack    = CapitalBackEnum::toArray();

        return compact('investmentType', 'interestType', 'returnType', 'capitalBack');
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        return $this->packageRepository->find($id);
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findPackageById(int $id): object
    {
        return $this->packageRepository->findOrFail($id, ['planTime']);
    }

    /**
     * Update package
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $packageId = $attributes['package_id'];
        $package = $this->packageRepository->firstWhere('id', $packageId);

        $attributes['image']  = ImageHelper::upload($attributes['image'] ?? null, AssetsFolderEnum::PACKAGE->value, $package->image ?? null);

        try {
            DB::beginTransaction();

            $this->packageRepository->updateById($packageId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Package update error"),
                    'title'   => localize('Package'),
                    'errors'  => $exception,
                ], 422)
            );
        }

    }

    /**
     * Delete expense
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $packageId = $attributes['package_id'];

        try {
            DB::beginTransaction();

            $this->packageRepository->destroyById($packageId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Package delete error"),
                    'title'   => localize('Package delete error'),
                    'errors'  => $exception,
                ], 422)
            );
        }

    }

    public function buyPackage(array $attributes = []): object
    {
        try {
            DB::beginTransaction();

            $packageId         = $attributes['package_id'];
            $quantity          = $attributes['quantity'];
            $investAmount      = $attributes['investAmt'];
            $totalInvestAmount = $quantity * $investAmount;
            $userId            = Auth::user()->user_id;
            $customerId        = Auth::id();

            $package = $this->packageRepository->findOrFail($packageId, ['planTime']);

            $currency = $this->acceptCurrencyRepository->firstWhere('symbol', 'USD');

            if (($package->invest_type->value === InvestTypeEnum::RANGE->value && ($investAmount < $package->min_price || $investAmount > $package->max_price)) || ($investAmount < $package->min_price)) {
                return (object) ['status' => false, 'message' => localize('Your data is invalid!')];
            }

            $balance = $this->walletManageRepository->findDoubleWhereFirst(
                'user_id',
                $userId,
                'accept_currency_id',
                $currency->id
            );

            if (!$balance || $balance->balance < $totalInvestAmount) {
                return (object) [
                    'status'  => false,
                    'message' => localize('You have not enough balance, please try again!'),
                ];
            }

            $nowDate = Carbon::now();

            $nextROIDate = Carbon::now()->addHours($package->planTime->hours_);
            $expireDate  = $nextROIDate;

            if ($package->return_type->value === ReturnTypeEnum::REPEAT->value) {
                $expireDate = Carbon::now()->addHours($package->planTime->hours_ * $package->repeat_time);
            }

            if ($this->checkInvestment($userId) == 0) {
                $saveLevel = [
                    'user_id'            => $userId,
                    'sponsor_commission' => 0,
                    'team_commission'    => 0,
                    'level'              => 1,
                    'last_update'        => $nowDate,
                ];

                $teambRes = $this->teamBonusDetailsRepository->create($saveLevel);

                $saveLevel['team_bonus_id'] = $teambRes['id'];
                $this->teamBonusRepository->create($saveLevel);
            }

            $investmentData['package_id']          = $package->id;
            $investmentData['user_id']             = $userId;
            $investmentData['invest_amount']       = $investAmount;
            $investmentData['total_invest_amount'] = $totalInvestAmount;
            $investmentData['invest_qty']          = $quantity;
            $investmentData['status']              = '1';
            $investmentData['expiry_at']           = $expireDate;

            $res = $this->investmentRepository->create($investmentData);

            $newBalance['balance']    = $balance->balance - $totalInvestAmount;
            $newBalance['investment'] = $balance->investment + $totalInvestAmount;
            $this->balanceUpdate($userId, $newBalance);

            $balanceLogData = [
                'user_id'            => $userId,
                'accept_currency_id' => $currency->id,
                'transaction_type'   => 'Debit',
                'transaction'        => 'INVESTMENT',
                'amount'             => $totalInvestAmount,
            ];
            $this->balanceLog($balanceLogData);

            $this->notificationService->create([
                'customer_id'       => Auth::id(),
                'notification_type' => 'pack_purchase',
                'subject'           => 'Purchase Package',
                'details'           => 'You bought a $' . $totalInvestAmount . ' package successfully',
                'status'            => NotificationEnum::UNREAD->value,
            ]);

            $roiAmountPerQty  = ($package->interest / $quantity);
            $roiAmount        = $package->interest;
            $totalNumberOfRoi = $package->repeat_time;
            $totalRoiAmount   = $package->interest * $quantity;

            if ($package->interest_type->value === InterestTypeEnum::PERCENT->value && $package->return_type->value === ReturnTypeEnum::REPEAT->value) {
                $roiAmountPerQty = (($investAmount * $package->interest) / 100) / $totalNumberOfRoi;
                $roiAmount       = (($investAmount * $package->interest) / 100);
                $totalRoiAmount  = $roiAmount * $quantity;
            }

            $details['investment_id']       = $res->id;
            $details['user_id']             = $userId;
            $details['customer_id']         = $customerId;
            $details['roi_time']            = $package->planTime->hours_;
            $details['invest_qty']          = $quantity;
            $details['roi_amount_per_qty']  = $roiAmountPerQty;
            $details['roi_amount']          = $roiAmount;
            $details['total_number_of_roi'] = $totalNumberOfRoi ?? 1;
            $details['total_roi_amount']    = $totalRoiAmount;
            $details['paid_number_of_roi']  = 0;
            $details['paid_roi_amount']     = 0;
            $details['status']              = InvestDetailStatusEnum::RUNNING->value;
            $details['next_roi_at']         = $nextROIDate;

            $this->investmentDetailsRepository->create($details);

            if ($package->capital_back->value === CapitalBackEnum::YES->value) {
                $capitalReturnData['investment_id'] = $res->id;
                $capitalReturnData['user_id']       = $userId;
                $capitalReturnData['return_amount'] = $totalInvestAmount;
                $capitalReturnData['status']        = CapitalReturnStatusEnum::PENDING->value;
                $capitalReturnData['return_at']     = $expireDate;

                $this->capitalReturnRepository->create($capitalReturnData);
            }

            $sponsorId = Auth::user()->referral_user;

            if ($sponsorId) {
                $sponsorInfo = $this->customerRepository->firstWhere('user_id', $sponsorId);

                $sponsorBalance = $this->walletManageRepository->findDoubleWhereFirst(
                    'user_id',
                    $sponsorId,
                    'accept_currency_id',
                    $currency->id
                );
                $investment = $this->investmentRepository->investmentCount($sponsorId);

                if ($investment > 0) {
                    $sponsors      = $this->teamBonusRepository->firstWhere('user_id', $sponsorId);
                    $sponsorLevel  = $sponsors->level ?? 1;
                    $referralBonus = $this->commissionSetupRepository->firstWhere('level_name', $sponsorLevel);

                    $commissionAmount = ($totalInvestAmount * $referralBonus->referral_bonus) / 100;
                    $commission       = [
                        'user_id'       => $sponsorId,
                        'customer_id'   => $sponsorInfo->id,
                        'earning_type'  => 'referral_commission',
                        'package_id'    => $package->id,
                        'investment_id' => $res->id,
                        'amount'        => $commissionAmount,
                        'date'          => Carbon::now(),
                    ];

                    $this->earningRepository->create($commission);

                    $newBalance2['accept_currency_id'] = $currency->id;
                    $newBalance2['user_id']            = $sponsorId;
                    $newBalance2['balance']            = $commissionAmount;
                    $newBalance2['referral']           = $commissionAmount;
                    $this->walletManageService->create($newBalance2);

                    $roiBalanceLogData1 = [
                        'user_id'            => $sponsorId,
                        'accept_currency_id' => $currency->id,
                        'transaction_type'   => 'Credit',
                        'transaction'        => 'referral',
                        'amount'             => $commissionAmount,
                    ];
                    $this->balanceLog($roiBalanceLogData1);

                    $this->notificationService->create([
                        'customer_id'       => $sponsorInfo->id,
                        'notification_type' => 'referral',
                        'subject'           => 'Purchase Package',
                        'details'           => 'You received a referral commission of ' . $commissionAmount . ' . Your new balance is ' . ($sponsorBalance->balance + $commissionAmount),
                        'status'            => NotificationEnum::UNREAD->value,
                    ]);

                    if ($sponsors) {
                        $scom = $sponsors->sponsor_commission + $totalInvestAmount;
                        $tcom = $sponsors->team_commission + $totalInvestAmount;

                        $sData = [
                            'sponsor_commission' => $scom,
                            'team_commission'    => $tcom,
                            'last_update'        => $nowDate,
                        ];
                        $detailsData = [
                            'user_id'            => $sponsorId,
                            'sponsor_commission' => $scom,
                            'team_commission'    => $tcom,
                            'last_update'        => $nowDate,
                        ];

                        $this->teamBonusDetailsRepository->create($detailsData);
                        $this->teamBonusRepository->updateByUserId($sponsorId, $sData);
                        $this->setLevelWithBonus($sponsorId);
                    }

                }

                $tuSdata = [
                    //'generation' => 2,
                    'generation' => 1,
                    'package_id' => $package->id,
                    'amount'     => $totalInvestAmount,
                    'sponsor_id' => $sponsorId,
                ];

                $this->recursive_data($tuSdata);
            }

            DB::commit();

            return $res;
        } catch (Exception $e) {
            DB::rollBack();
            // Log the error message
            Log::error('Error in buyPackage: ' . $e->getMessage());

            return (object) [
                'status'  => false,
                'message' => 'An error occurred, please try again later, ' . $e->getMessage(),
            ];
        }

    }

    /***************************
     *   check investment
     * @param $userId
     *   return number of rows
     ***************************/
    private function checkInvestment($userId = null)
    {
        return $this->investmentRepository->investmentCount($userId);
    }

    /**
     * Create Package
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        if (isset($attributes['image'])) {
            $attributes['image'] = ImageHelper::upload($attributes['image'], AssetsFolderEnum::PACKAGE->value);
        }
   
        try {
            DB::beginTransaction();
            $package = $this->packageRepository->create($attributes);
            DB::commit();

            return $package;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    private function balanceUpdate($userId, array $data = []): bool
    {
        $currency                   = $this->acceptCurrencyRepository->firstWhere('symbol', 'USD');
        $data['accept_currency_id'] = $currency->id;
        $this->walletManageRepository->updateByUserId($userId, $data);

        return true;
    }

    private function balanceLog($data): bool
    {
        $this->walletTransactionLogRepository->create($data);

        return true;
    }

    /*
    |   SET LEVEL with Level bonus
    |   @param sponser id
    |   return ture or false
     */

    private function setLevelWithBonus($sponsorId): bool
    {
        $investment = $this->investmentRepository->investmentCount($sponsorId);
        $currency   = $this->acceptCurrencyRepository->firstWhere('symbol', 'USD');

        if ($investment > 0) {
            $sponsorInfo = $this->customerRepository->firstWhere('user_id', $sponsorId);
            $sponsor2    = $this->teamBonusRepository->firstWhere('user_id', $sponsorId);

            if ($sponsor2->sponsor_commission != 0 && $sponsor2->team_commission != 0) {
                $level = $sponsor2->level;

                $attributes['personal_invest'] = $sponsor2->sponsor_commission;
                $attributes['total_invest']    = $sponsor2->team_commission;
                $attributes['level_name']      = $level;

                $getCommi = $this->commissionSetupRepository->getCommission($attributes);

                $incrementLevel = 0;

                if ($sponsor2->level < 5) {
                    $incrementLevel = 1;
                }

                if ($getCommi != null) {
                    $balance2 = $this->walletManageRepository->findDoubleWhereFirst(
                        'user_id',
                        $sponsorId,
                        'accept_currency_id',
                        $currency->id
                    );

                    $newBalance2 = $balance2->balance + $getCommi->team_bonus;

                    $newLevel   = $level + $incrementLevel;
                    $updateData = [
                        'level' => $newLevel,
                    ];
                    $this->teamBonusRepository->updateByUserId($sponsorId, $updateData);

                    $levelData = [
                        'user_id'      => $sponsorId,
                        'level_id'     => $level,
                        'achieve_date' => Carbon::now(),
                        'bonus'        => $getCommi->team_bonus,
                        'status'       => 1,
                    ];
                    $this->userLevelRepository->create($levelData);
                    $this->notificationService->create([
                        'customer_id'       => $sponsorInfo->id,
                        'notification_type' => 'team_bonus',
                        'subject'           => 'Team Bonus',
                        'details'           => 'Congrats! You received the amount $' . $getCommi->team_bonus . ' for team bonus. Your new balance is $' . $newBalance2 . '. You are now in Stage ' . $newLevel,
                        'status'            => NotificationEnum::UNREAD->value,
                    ]);

                    $this->extracted($balance2, $getCommi, $sponsorId, $sponsorInfo, $currency);

                    return true;
                }

            }

        }

        return false;
    }

    /**
     * @param object|null $balance2
     * @param object $getCommi
     * @param $sponsorId
     * @param object|null $sponsorInfo
     * @param mixed $currency
     * @return void
     */
    private function extracted(
        ?object $balance2,
        object $getCommi,
        $sponsorId,
        ?object $sponsorInfo,
        mixed $currency
    ): void {
        $newBalance3['balance']  = $balance2->balance + $getCommi->team_bonus;
        $newBalance3['referral'] = $balance2->referral + $getCommi->team_bonus;
        $this->balanceUpdate($sponsorId, $newBalance3);

        $roiBalanceLogData4 = [
            'user_id'            => $sponsorInfo->user_id,
            'accept_currency_id' => $currency->id,
            'transaction_type'   => 'Credit',
            'transaction'        => 'team_bonus',
            'amount'             => $getCommi->team_bonus,
        ];
        $this->balanceLog($roiBalanceLogData4);
    }

    /**
     * recursive function
     *
     * @param array $sp
     * @return   1 and finish recursive function
     */

    public function recursive_data($sp = null)
    {
        $data     = $this->customerRepository->firstWhere('user_id', $sp['sponsor_id']);
        $currency = $this->acceptCurrencyRepository->firstWhere('symbol', 'USD');

        if (!$data || !isset($sp['generation'])) {
            return;
        }

        if ($data->referral_user != null && $sp['generation'] <= 5) {
            $sponsorId = $data->referral_user;

            $customerInfo = $this->customerRepository->firstWhere('user_id', $sponsorId);

            $investment = $this->investmentRepository->investmentCount($sponsorId);

            if ($investment != null) {
                $sponsors = $this->teamBonusRepository->firstWhere('user_id', $sponsorId);

                if ($sponsors) {
                    $scom = $sponsors->sponser_commission+@$sp['amount'];
                    $tcom = $sponsors->team_commission+@$sp['amount'];

                    $detailsData = [
                        'user_id'            => $sponsorId,
                        'team_commission'    => $tcom,
                        'sponsor_commission' => $scom,
                        'last_update'        => Carbon::now(),
                    ];

                    $this->teamBonusDetailsRepository->create($detailsData);

                    $sdata = [
                        'team_commission' => $tcom,
                        'last_update'     => Carbon::now(),
                    ];

                    $this->teamBonusRepository->updateByUserId($sponsorId, $sdata);
                }

                $this->setLevelWithBonus($sponsorId);

                $lc = $this->teamBonusRepository->firstWhere('user_id', $sponsorId);

                if ($lc) {
                    $sponsorBalanceL = $this->walletManageRepository->findDoubleWhereFirst(
                        'user_id',
                        $sponsorId,
                        'accept_currency_id',
                        $currency->id
                    );

                    $referralBonus = $this->commissionSetupRepository->firstWhere('level_name', $lc->level);

                    $package = $this->packageRepository->findOrFail($sp['package_id'], ['planTime']);

                    $commissionAmount = (@$sp['amount'] / 100) * $referralBonus->referral_bonus;

                    $commission = [
                        'user_id'      => $sponsorId,
                        'customer_id'  => $customerInfo->id,
                        'earning_type' => 'referral_commission',
                        'package_id'   => $package->id,
                        'amount'       => $commissionAmount,
                        'date'         => Carbon::now(),
                    ];

                    $this->earningRepository->create($commission);

                    $newBalance3['balance']  = $sponsorBalanceL->balance + $commissionAmount;
                    $newBalance3['referral'] = $sponsorBalanceL->referral + $commissionAmount;
                    $this->balanceUpdate($sponsorId, $newBalance3);

                    $roiBalanceLogData3 = [
                        'user_id'            => $sponsorId,
                        'accept_currency_id' => $currency->id,
                        'transaction_type'   => 'Credit',
                        'transaction'        => 'referral',
                        'amount'             => $commissionAmount,
                    ];
                    $this->balanceLog($roiBalanceLogData3);
                }

            }

            $tuSdata = [
                'generation' => $sp['generation'] + 1,
                'amount'     => $sp['amount'],
                'package_id' => $sp['package_id'],
                'sponsor_id' => $sponsorId,
            ];
            $this->recursive_data($tuSdata);
        } else {
            return 1;
        }

    }

    /**
     * Send Investment Interest
     * @return void
     */
    public function findInvestmentForInterest(): ?object
    {
        return $this->investmentDetailsRepository->findInvestmentDetailsByNextInterestDate();
    }

    /**
     * Send Investment Interest data
     * @param object $value
     * @param mixed $acceptCurrencyId
     * @return bool
     */
    public function sendInterest(object $value, $acceptCurrencyId): bool
    {
        $userID                = $value->user_id;
        $interestIntervalTime  = $value->roi_time;
        $investmentQty         = $value->invest_qty;
        $interestAmountPerQty  = $value->roi_amount_per_qty;
        $totalNumberOfInterest = $value->total_number_of_roi;
        $paidNoOfInterest      = $value->paid_number_of_roi;
        $paidInterestAmount    = $value->paid_roi_amount;
        $interestTime          = Carbon::parse($value->next_roi_at);
        $nextInterestTime      = $interestTime->addHours($interestIntervalTime);
        $investmentId          = $value->investment_id;

        $sendInterestAmount = number_format($investmentQty * $interestAmountPerQty, 6, '.', '');
        $paidNoOfInterest++;
        $paidInterestAmount += $sendInterestAmount;

        $updateInvestmentDetailsData = [
            'paid_number_of_roi' => $paidNoOfInterest,
            'paid_roi_amount'    => $paidInterestAmount,
            'next_roi_at'        => $nextInterestTime,
        ];

        if ($paidNoOfInterest == $totalNumberOfInterest) {
            $updateInvestmentData                  = ['status' => StatusEnum::INACTIVE->value];
            $updateInvestmentDetailsData['status'] = InvestDetailStatusEnum::PAUSE->value;
        }

        $updateWalletBalanceData = [
            'user_id'            => $userID,
            'accept_currency_id' => $acceptCurrencyId,
            'roi_'               => $sendInterestAmount,
            'balance'            => $sendInterestAmount,
        ];

        $createBalanceLogData = [
            'user_id'            => $userID,
            'accept_currency_id' => $acceptCurrencyId,
            'transaction'        => WalletManageLogEnum::ROI->value,
            'transaction_type'   => TransactionTypeEnum::CREDIT->value,
            'amount'             => $sendInterestAmount,
        ];

        $createInvestmentROIData = [
            'investment_id' => $investmentId,
            'user_id'       => $userID,
            'roi_amount'    => $sendInterestAmount,
            'received_at'   => $value->next_roi_at,
        ];

        try {

            DB::beginTransaction();

            if (isset($updateInvestmentData)) {
                $this->investmentRepository->updateById($investmentId, $updateInvestmentData);
            }

            $this->investmentDetailsRepository->updateById($value->id, $updateInvestmentDetailsData);
            $this->walletManageService->create($updateWalletBalanceData);
            $this->walletTransactionLogService->create($createBalanceLogData);
            $this->investmentRoiRepository->create($createInvestmentROIData);

            $this->notificationService->create([
                'customer_id'       => $value->customer_id,
                'notification_type' => 'interest',
                'subject'           => 'Investment Interest',
                'details'           => 'You have received an interest payment of $' . $sendInterestAmount .
                ' USD for Order ID ' . $investmentId,
            ]);

            DB::commit();

            return true;

        } catch (\Throwable $th) {

            DB::rollBack();

            return false;
        }

    }

    /**
     * Find capital return for send capital of investment
     * @return object|null
     */
    public function findCapitalReturn(): ?object
    {
        return $this->capitalReturnRepository->findCapitalReturnByReturnAt();
    }

    /**
     * Send Capital Return
     * @return bool
     */
    public function sendCapital(object $value, $acceptCurrencyId): bool
    {
        $customerInfo = $this->customerService->findCustomer(['user' => $value->user_id]);

        if (!$customerInfo) {
            return false;
        }

        $userID        = $value->user_id;
        $investmentId  = $value->investment_id;
        $capitalAmount = $value->return_amount;

        try {

            DB::beginTransaction();

            $this->investmentDetailsRepository->changeStatusByInvestmentId($investmentId, [
                'status' => InvestDetailStatusEnum::COMPLETE->value,
            ]);

            $this->capitalReturnRepository->updateById($value->id, [
                'status' => CapitalReturnStatusEnum::DONE->value,
            ]);

            $this->walletManageService->create([
                'user_id'            => $userID,
                'accept_currency_id' => $acceptCurrencyId,
                'capital_return'     => $capitalAmount,
                'balance'            => $capitalAmount,
            ]);

            $this->walletTransactionLogService->create([
                'user_id'            => $userID,
                'accept_currency_id' => $acceptCurrencyId,
                'transaction'        => WalletManageLogEnum::CAPITAL_RETURN->value,
                'transaction_type'   => TransactionTypeEnum::CREDIT->value,
                'amount'             => $capitalAmount,
            ]);

            $this->notificationService->create([
                'customer_id'       => $customerInfo->id,
                'notification_type' => 'capital',
                'subject'           => 'Capital Return',
                'details'           => 'You have received an capital return payment of $' . $capitalAmount .
                ' USD for Order ID ' . $investmentId,
            ]);

            DB::commit();

            return true;

        } catch (\Throwable $th) {

            DB::rollBack();

            Log::info('Capital Return' . $th->getMessage());

            return false;
        }

    }

}
