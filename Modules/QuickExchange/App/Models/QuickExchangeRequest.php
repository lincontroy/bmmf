<?php

namespace Modules\QuickExchange\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickExchangeRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'request_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'sell_coin',
        'sell_amount',
        'buy_coin',
        'buy_amount',
        'user_send_hash',
        'admin_send_hash',
        'admin_payment_wallet',
        'user_payment_wallet',
        'document',
        'status',
        'fiat_currency',
        'show_status',
        'request_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id'              => 'string',
        'sell_coin'            => 'string',
        'sell_amount'          => 'float',
        'buy_coin'             => 'string',
        'buy_amount'           => 'float',
        'user_send_hash'       => 'string',
        'admin_send_hash'      => 'string',
        'admin_payment_wallet' => 'string',
        'user_payment_wallet'  => 'string',
        'document'             => 'string',
        'status'               => 'integer',
        'fiat_currency'        => 'integer',
        'show_status'          => 'integer',
        'request_date'         => 'datetime',
    ];

    /**
     * Sell Coin
     *
     * @return BelongsTo
     */
    public function sellCoin(): BelongsTo
    {
        return $this->belongsTo(QuickExchangeCoin::class, 'sell_coin', 'symbol');
    }

    /**
     * Buy Coin
     *
     * @return BelongsTo
     */
    public function buyCoin(): BelongsTo
    {
        return $this->belongsTo(QuickExchangeCoin::class, 'buy_coin', 'symbol');
    }

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return '';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}
