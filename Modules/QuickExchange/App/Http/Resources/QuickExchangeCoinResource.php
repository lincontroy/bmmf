<?php

namespace Modules\QuickExchange\App\Http\Resources;

use App\Enums\NumberEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuickExchangeCoinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id ?? null,
            'image'              => $this->image ?? null,
            'coin_name'          => $this->coin_name ?? null,
            'symbol'             => $this->symbol ?? null,
            'reserve_balance'    => number_format($this->reserve_balance ?? 0, NumberEnum::DECIMAL->value, '.', ''),
            'market_rate'        => number_format($this->market_rate ?? 0, NumberEnum::DECIMAL->value, '.', ''),
            'price_type'         => $this->price_type,
            'sell_adjust_price'  => number_format($this->sell_adjust_price ?? 0, NumberEnum::DECIMAL->value, '.', ''),
            'buy_adjust_price'   => number_format($this->buy_adjust_price ?? 0, NumberEnum::DECIMAL->value, '.', ''),
            'minimum_tx_amount'  => number_format($this->minimum_tx_amount ?? 0, NumberEnum::DECIMAL->value, '.', ''),
            'wallet_id'          => $this->wallet_id,
            'exchange_sell_rate' => number_format($this->exchange_sell_rate ?? 0, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', ''),
            'exchange_buy_rate'  => number_format($this->exchange_buy_rate ?? 0, NumberEnum::QUICK_EXCHANGE_DECIMAL->value, '.', ''),
        ];
    }
}
