<?php

namespace Modules\Merchant\App\Models;

use App\Models\AcceptCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Merchant\App\Models\MerchantAccount;

class MerchantBalance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accept_currency_id',
        'symbol',
        'merchant_account_id',
        'user_id',
        'amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'accept_currency_id'  => 'integer',
        'symbol'              => 'string',
        'merchant_account_id' => 'integer',
        'user_id'             => 'string',
        'amount'              => 'float',
    ];

    /**
     * Accept Currency
     *
     * @return BelongsTo
     */
    public function acceptCurrency(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class);
    }

    /**
     * Merchant Account
     *
     * @return BelongsTo
     */
    public function merchantAccount(): BelongsTo
    {
        return $this->belongsTo(MerchantAccount::class);
    }
}
