<?php

namespace Modules\QuickExchange\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickExchangeCoin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'symbol',
        'coin_name',
        'reserve_balance',
        'market_rate',
        'price_type',
        'sell_adjust_price',
        'buy_adjust_price',
        'minimum_tx_amount',
        'wallet_id',
        'coin_position',
        'url',
        'base_currency',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'image'             => 'string',
        'symbol'            => 'string',
        'coin_name'         => 'string',
        'reserve_balance'   => 'float',
        'market_rate'       => 'float',
        'price_type'        => 'integer',
        'sell_adjust_price' => 'float',
        'buy_adjust_price'  => 'float',
        'minimum_tx_amount' => 'float',
        'wallet_id'         => 'string',
        'coin_position'     => 'integer',
        'url'               => 'string',
        'base_currency'     => 'integer',
        'status'            => 'integer',
    ];

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return '';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}
