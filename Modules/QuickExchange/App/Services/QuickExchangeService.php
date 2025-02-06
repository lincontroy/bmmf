<?php

namespace Modules\QuickExchange\App\Services;

use App\Enums\AssetsFolderEnum;
use App\Enums\NumberEnum;
use App\Enums\StatusEnum;
use App\Helpers\ImageHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\QuickExchange\App\Http\Resources\QuickExchangeCoinResource;
use Modules\QuickExchange\App\Http\Resources\QuickExchangeTransactionResource;
use Modules\QuickExchange\App\Repositories\Interfaces\QuickExchangeCoinRepositoryInterface;
use Modules\QuickExchange\App\Repositories\Interfaces\QuickExchangeRequestRepositoryInterface;

class QuickExchangeService
{
    /**
     * QuickExchangeService constructor.
     *
     */
    public function __construct(
        private QuickExchangeCoinRepositoryInterface $quickExchangeCoinRepository,
        private QuickExchangeRequestRepositoryInterface $quickExchangeRequestRepository,
    ) {
    }

    /**
     * Quick Exchange View Data
     * @return object
     */
    public function quickExchange(): ?object
    {
        $baseCoin = $this->quickExchangeCoinRepository->findBaseCoin();

        if ($baseCoin) {
            $baseCoinResponse     = new QuickExchangeCoinResource($baseCoin);
            $activeCoinCollection = $this->quickExchangeCoinRepository->findSupportActiveCoins();
            $activeCoinCollection = new Collection($activeCoinCollection);
            $activeCoinList       = $activeCoinCollection->map(function ($item) use ($baseCoin) {

                if ($item->symbol == $baseCoin->symbol) {
                    $item->exchange_sell_rate = 1;
                    $item->exchange_buy_rate  = 1;
                } else {

                    $sellMarketRate   = $baseCoin->market_rate + $baseCoin->sell_adjust_price;
                    $sellBaseCoinRate = number_format($sellMarketRate, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
                    $sellExchangeRate = $item->market_rate > 0 ? number_format($sellBaseCoinRate / $item->market_rate,
                        NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '') : 0;

                    $buyMarketRate    = $baseCoin->market_rate + $baseCoin->buy_adjust_price;
                    $sellBaseCoinRate = number_format($buyMarketRate, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
                    $buyExchangeRate  = number_format($sellBaseCoinRate * $item->market_rate,
                        NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');

                    $item->exchange_sell_rate = number_format($sellExchangeRate,
                        NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
                    $item->exchange_buy_rate = $buyExchangeRate > 0 ? number_format(1 / $buyExchangeRate,
                        NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '') : 0;
                }

                return $item;
            });
        } else {
            $baseCoinResponse = [];
            $activeCoinList   = [];
        }

        $recentTransaction = $this->quickExchangeRequestRepository->findRecentTransaction(5);

        return (object) [
            "activeCoin"  => QuickExchangeCoinResource::collection($activeCoinList),
            "baseCoin"    => $baseCoinResponse,
            "recentTrans" => QuickExchangeTransactionResource::collection($recentTransaction),
        ];
    }

    /**
     * Get quick exchange support all coin
     * @param mixed $sellCurrency
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function supportCoins($sellCurrency): ?object
    {
        $activeCoinList = $this->quickExchangeCoinRepository->findSupportActiveCoins();
        $baseCoin       = $this->quickExchangeCoinRepository->findBaseCoin();

        if (!$baseCoin || !$activeCoinList) {
            return (object) [];
        }

        $activeCoinList = collect($activeCoinList);

        if ($baseCoin->symbol === $sellCurrency) {
            $rejectCondition = function ($item) use ($baseCoin) {
                return $baseCoin->symbol == $item->symbol;
            };
        } else {
            $rejectCondition = function ($item) use ($baseCoin) {
                return $baseCoin->symbol != $item->symbol;
            };
        }

        $filterCollection = $activeCoinList->reject($rejectCondition);
        $activeCoinList   = $filterCollection->map(function ($item) use ($baseCoin) {

            if ($item->symbol == $baseCoin->symbol) {
                $item->exchange_sell_rate = 1;
                $item->exchange_buy_rate  = 1;
            } else {

                $sellMarketRate   = $baseCoin->market_rate + $baseCoin->sell_adjust_price;
                $sellBaseCoinRate = number_format($sellMarketRate, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
                $sellExchangeRate = $item->market_rate > 0 ? number_format($sellBaseCoinRate / $item->market_rate,
                    NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '') : 0;

                $buyMarketRate    = $baseCoin->market_rate + $baseCoin->buy_adjust_price;
                $sellBaseCoinRate = number_format($buyMarketRate, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
                $buyExchangeRate  = number_format($sellBaseCoinRate * $item->market_rate,
                    NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');

                $item->exchange_sell_rate = number_format($sellExchangeRate,
                    NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
                $item->exchange_buy_rate = $buyExchangeRate > 0 ? number_format(1 / $buyExchangeRate,
                    NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '') : 0;
            }

            return $item;
        });
        return QuickExchangeCoinResource::collection($filterCollection);
    }

    /**
     * Fetch Quick Exchange
     * @param array $attribute
     * @return object
     */
    public function quickExchangeRate(array $attribute): ?object
    {
        $sellCoin     = $attribute["sell_coin"];
        $buyCoin      = $attribute["buy_coin"];
        $sellAmount   = $attribute["sell_amount"];
        $buyAmount    = $attribute["buy_amount"];
        $sellCoinInfo = $attribute["validateData"]["sellCoinInfo"];
        $buyCoinInfo  = $attribute["validateData"]["buyCoinInfo"];
        $baseCoinInfo = $attribute["validateData"]["baseCoinInfo"];
        $tnxType      = "sell";

        if ($sellCoin == $baseCoinInfo->symbol) {
            $tnxType = "buy";
        }

        if ($tnxType == "sell") {
            $baseCoinRate = 0;

            $marketRate   = $baseCoinInfo->market_rate + $baseCoinInfo->sell_adjust_price;
            $baseCoinRate = number_format($marketRate, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');

            $finalRate = $sellCoinInfo->market_rate > 0 ? number_format($baseCoinRate / $sellCoinInfo->market_rate,
                NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '') : 0;
            $userMsg        = "We Buy 1 " . $baseCoinInfo->symbol . " For " . $finalRate . " " . $sellCoin;
            $reserveBalance = $baseCoinInfo->reserve_balance;

        } else {
            $baseCoinRate = 0;

            $marketRate   = $baseCoinInfo->market_rate + $baseCoinInfo->buy_adjust_price;
            $baseCoinRate = number_format($marketRate, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');

            $finalRate = number_format($baseCoinRate * $buyCoinInfo->market_rate,
                NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
            $userMsg        = "We Sell 1 " . $buyCoin . " For " . $finalRate . " " . $baseCoinInfo->symbol;
            $reserveBalance = $buyCoinInfo->reserve_balance;
        }

        if ($sellAmount > 0) {
            $buyAmount = $finalRate > 0 ? $sellAmount / $finalRate : 0;
        } else {
            $sellAmount = $buyAmount * $finalRate;
        }

        if ($buyAmount > $buyCoinInfo->reserve_balance) {
            return (object) [
                'status'    => StatusEnum::FAILED->value,
                'errorData' => [
                    "buy_coin" => [
                        localize("Sorry, we have not enough balance to pay you"),
                    ],
                ],
            ];
        }

        if ($sellAmount < $sellCoinInfo->minimum_tx_amount) {
            return (object) [
                'status'    => StatusEnum::FAILED->value,
                'errorData' => [
                    "sell_coin" => [
                        "Min: " . $sellCoinInfo->minimum_tx_amount,
                    ],
                ],
            ];
        }

        return (object) [
            "status" => StatusEnum::SUCCESS->value,
            "data"   => [
                "sell_amount" => number_format($sellAmount, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', ''),
                "buy_amount"  => number_format($buyAmount, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', ''),
                "label"       => $userMsg,
                "reserve"     => number_format($reserveBalance, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', ''),
                "tnx_type"    => $tnxType,
            ],
        ];
    }

    /**
     * List of Quick Exchange Transaction List
     * @param int $pageNo
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function quickExchangeTransaction(int $pageNo): ?object
    {
        $transactions = $this->quickExchangeRequestRepository->orderPaginate([
            "orderByColumn" => "request_id",
            "order"         => "desc",
            "perPage"       => 10,
            "page"          => $pageNo,
        ],
            ['sellCoin', 'buyCoin']
        );

        return QuickExchangeTransactionResource::collection($transactions);
    }

    public function quickExchangeNextValidate(array $attribute): ?object
    {
        $sellCoin = $attribute["sell_coin"];
        $buyCoin  = $attribute["buy_coin"];

        $baseCoinInfo = $this->quickExchangeCoinRepository->findBaseCoin();

        if (!$baseCoinInfo) {
            return (object) [
                'status'    => StatusEnum::FAILED->value,
                'errorData' => [
                    "sell_coin" => [
                        localize("The system's base coin does not exist."),
                    ],
                ],
            ];
        }

        $sellCoinInfo = $this->quickExchangeCoinRepository->findDoubleWhereFirst(
            'symbol',
            $sellCoin,
            'status',
            StatusEnum::ACTIVE->value
        );

        if (!$sellCoinInfo) {
            return (object) [
                'status'    => StatusEnum::FAILED->value,
                'errorData' => [
                    "sell_coin" => [
                        localize("The sell coin is not valid!"),
                    ],
                ],
            ];
        }

        $buyCoinInfo = $this->quickExchangeCoinRepository->findDoubleWhereFirst(
            'symbol',
            $buyCoin,
            'status',
            StatusEnum::ACTIVE->value
        );

        if (!$buyCoinInfo) {
            return (object) [
                'status'    => StatusEnum::FAILED->value,
                'errorData' => [
                    "buy_coin" => [
                        localize("The buy coin is not valid!"),
                    ],
                ],
            ];
        }

        return (object) [
            'status' => StatusEnum::SUCCESS->value,
            'data'   => [
                'sellCoinInfo' => $sellCoinInfo,
                'buyCoinInfo'  => $buyCoinInfo,
                'baseCoinInfo' => $baseCoinInfo,
            ],
        ];
    }

    public function quickExchangeNext(array $attribute): ?object
    {
        $sellCoin = $attribute["sell_coin"];
        $buyCoin  = $attribute["buy_coin"];
        $rateData = $this->quickExchangeRate($attribute);

        if ($rateData->status == StatusEnum::FAILED->value) {
            return $rateData;
        }

        $sellCoinInfo = $attribute["validateData"]["sellCoinInfo"];

        if (
            is_string($sellCoinInfo->wallet_id)
            && is_array(json_decode($sellCoinInfo->wallet_id, true))
            && (json_last_error() == JSON_ERROR_NONE) ? true : false
        ) {
            $adminWallet     = json_decode($sellCoinInfo->wallet_id);
            $adminWalletData = [];

            foreach ($adminWallet as $key => $value) {
                $adminWalletData[] = [
                    'label' => $key,
                    'value' => $value,
                ];
            }

            $adminWallet = $adminWalletData;
        } else {
            $adminWallet = $sellCoinInfo->wallet_id;
        }

        return (object) [
            "status" => StatusEnum::SUCCESS->value,
            "data"   => [
                "sell_coin"    => $sellCoin,
                "buy_coin"     => $buyCoin,
                "sell_amount"  => number_format($rateData->data['sell_amount'], NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', ''),
                "buy_amount"   => number_format($rateData->data['buy_amount'], NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', ''),
                "tnx_type"     => $rateData->data['tnx_type'],
                "admin_wallet" => $adminWallet,
            ],
        ];
    }

    public function quickExchangeRequest(array $attribute): ?object
    {
        $validateData = $this->quickExchangeNextValidate($attribute);

        if ($validateData->status == StatusEnum::FAILED->value) {
            return $validateData;
        }

        $sellCoin        = $attribute["sell_coin"];
        $buyCoin         = $attribute["buy_coin"];
        $transaction     = $attribute["transaction"];
        $receiverAccount = $attribute["receiver_account"];
        $tnxImage        = $attribute["tx_image"];

        $rateData = $this->quickExchangeNext([
            'validateData' => $validateData->data,
            'sell_coin'    => $sellCoin,
            'buy_coin'     => $buyCoin,
            'sell_amount'  => $attribute["sell_amount"],
            'buy_amount'   => $attribute["buy_amount"],
        ]);

        if ($rateData->status == StatusEnum::FAILED->value) {
            return $rateData;
        }

        $sellAmount   = number_format($rateData->data['sell_amount'], NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
        $buyAmount    = number_format($rateData->data['buy_amount'], NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', '');
        $sellCoinInfo = $validateData->data['sellCoinInfo'];
        $tnxType      = $rateData->data['tnx_type'] == 'sell' ? 1 : 0;

        $documentPath = ImageHelper::upload($tnxImage, AssetsFolderEnum::QUICK_EXCHANGE_TNX_IMAGE->value);

        try {
            DB::beginTransaction();

            $this->quickExchangeRequestRepository->create([
                'sell_coin'            => $sellCoin,
                'sell_amount'          => $sellAmount,
                'buy_coin'             => $buyCoin,
                'buy_amount'           => $buyAmount,
                'user_send_hash'       => $transaction,
                'admin_payment_wallet' => $sellCoinInfo->wallet_id,
                'user_payment_wallet'  => $receiverAccount,
                'document'             => $documentPath ?? 0,
                'fiat_currency'        => $tnxType,
                'status'               => 0,
            ]);

            DB::commit();
            return (object) [
                "status"  => StatusEnum::SUCCESS->value,
                "message" => localize("Your request has been sent successfully!"),
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Create quick exchange coin
     * @param array $attributes
     * @return object
     */
    public function createCoin(array $attributes): object
    {
        $createData = [
            "image"             => Str::lower($attributes["symbol"]) . ".svg",
            "symbol"            => $attributes["symbol"],
            "coin_name"         => $attributes["coin_name"],
            "reserve_balance"   => $attributes["reserve_balance"],
            "market_rate"       => 0,
            "price_type"        => 1,
            "sell_adjust_price" => 0,
            "buy_adjust_price"  => 0,
            "minimum_tx_amount" => $attributes["min_transaction"],
            "wallet_id"         => $attributes["wallet_id"] ?? null,
            "url"               => '',
            "base_currency"     => 0,
            "status"            => $attributes["status"],
        ];

        if (isset($attributes["coinType"])) {

            $walletData = [];

            foreach ($attributes["account_label_name"] as $key => $value) {
                $walletData[$value] = $attributes["account_label_value"][$key];
            }

            $walletData                      = json_encode($walletData);
            $createData["market_rate"]       = $attributes["market_rate"];
            $createData["sell_adjust_price"] = $attributes["sell_adjust_price"];
            $createData["buy_adjust_price"]  = $attributes["buy_adjust_price"];
            $createData["wallet_id"]         = $walletData;
            $createData["base_currency"]     = 1;
        }

        $coinData = $this->quickExchangeCoinRepository->create($createData);

        return $coinData;
    }

    /**
     * Delete stake plan data
     * @param array $attributes
     * @return bool
     */
    public function destroy(array $attributes): bool
    {
        $stakeId = $attributes['coin_id'];
        try {
            DB::beginTransaction();

            $this->quickExchangeCoinRepository->delete($stakeId);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Find OR Fail Model
     * @param array $attributes
     * @return object
     */
    public function find(array $attributes): object
    {
        return $this->quickExchangeCoinRepository->findOrFail($attributes['id']);
    }

    /**
     * Find OR Fail Transaction
     * @param array $attributes
     * @return object
     */
    public function findTransaction(array $attributes): object
    {
        return $this->quickExchangeRequestRepository->findOrFail($attributes['id']);
    }

    /**
     * Update quick exchange data
     * @param array $attributes
     * @param int $coinId
     * @return bool
     */
    public function update(array $attributes, int $coinId): bool
    {
        try {

            $updateData = [
                "image"             => Str::lower($attributes["symbol"]) . ".svg",
                "symbol"            => $attributes["symbol"],
                "coin_name"         => $attributes["coin_name"],
                "reserve_balance"   => $attributes["reserve_balance"],
                "minimum_tx_amount" => $attributes["min_transaction"],
                "wallet_id"         => $attributes["wallet_id"] ?? null,
                "status"            => $attributes["status"],
            ];

            if (isset($attributes["coinType"])) {

                $walletData = [];

                foreach ($attributes["account_label_name"] as $key => $value) {
                    $walletData[$value] = $attributes["account_label_value"][$key];
                }

                $walletData                      = json_encode($walletData);
                $updateData["market_rate"]       = $attributes["market_rate"];
                $updateData["sell_adjust_price"] = $attributes["sell_adjust_price"];
                $updateData["buy_adjust_price"]  = $attributes["buy_adjust_price"];
                $updateData["wallet_id"]         = $walletData;
            }

            DB::beginTransaction();

            $this->quickExchangeCoinRepository->updateById($coinId, $updateData);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Find Base Coin
     * @return object|null
     */
    public function baseCoin(): ?object
    {
        return $this->quickExchangeCoinRepository->findBaseCoin();
    }

    /**
     * Transaction update
     * @param array $attributes
     * @param mixed $id
     * @return bool
     */
    public function transactionUpdate(array $attributes, $id): bool
    {
        $updateData = [];

        if ($attributes['transactionStatus'] == StatusEnum::ACTIVE->value) {
            $updateData = [
                "admin_send_hash" => $attributes["admin_payment_tnx_hash"],
                "status"          => StatusEnum::ACTIVE->value,
            ];
        } else {
            $updateData = [
                "status" => '3',
            ];
        }

        return $this->quickExchangeRequestRepository->updateById($id, $updateData);
    }

}
