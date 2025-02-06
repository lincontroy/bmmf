<?php

namespace App\Models;

use App\Enums\TxnTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TxnReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'accept_currency_id',
        'txn_type',
        'amount',
        'usd_value',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'customer_id'        => 'integer',
        'accept_currency_id' => 'integer',
        'txn_type'           => TxnTypeEnum::class,
        'amount'             => 'float',
        'usd_value'          => 'float',
    ];

    public function customerInfo(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function currencyInfo(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'accept_currency_id', 'id');
    }
}
