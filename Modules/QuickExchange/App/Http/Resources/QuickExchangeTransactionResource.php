<?php

namespace Modules\QuickExchange\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuickExchangeTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "request_date"    => $this->created_at,
            "sell_coin_name"  => $this->sellCoin->coin_name,
            "sell_coin_img"   => $this->sellCoin->image,
            "sell_coin_url"   => $this->sellCoin->url,
            "sell_amount"     => $this->sell_amount,
            "user_send_hash"  => $this->user_send_hash,
            "buy_coin_name"   => $this->buyCoin->coin_name,
            "buy_coin_img"    => $this->buyCoin->image,
            "buy_coin_url"    => $this->buyCoin->url,
            "buy_amount"      => $this->buy_amount,
            "admin_send_hash" => $this->admin_send_hash,
            "status"          => $this->status,
        ];
    }
}
